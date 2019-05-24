<?php
namespace Chancenportal\Chancenportal\Domain\Repository;

use Chancenportal\Chancenportal\Domain\Model\Category;
use Chancenportal\Chancenportal\Domain\Model\Date;
use Chancenportal\Chancenportal\Domain\Model\Log;
use Chancenportal\Chancenportal\Domain\Model\Offer;
use Chancenportal\Chancenportal\Domain\Model\Provider;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
/***
 *
 * This file is part of the "Chancenportal" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/

/**
 * The repository for Offers
 */
class OfferRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\LogRepository
     * @inject
     */
    protected $logRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     * @inject
     */
    protected $providerRepository = null;

    /**
     * @var array
     */
    protected $settings = null;

    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $configurationManager = $objectManager->get(ConfigurationManager::class);
        $this->settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
    }

    /**
     * @param Provider|null $provider
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByProvider(Provider $provider = null)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];
        if ($provider) {
            $constraints[] = $query->equals('provider', $provider);
            $query->matching($query->logicalAnd($constraints));
        }
        $query->setOrderings([
            'approved' => QueryInterface::ORDER_ASCENDING,
            'active' => QueryInterface::ORDER_ASCENDING
        ]);
        return $query->execute();
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param null $category
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|ObjectStorage|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByDatesAndCategory($startDate, $endDate, $category = null)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $defaultDateCondition = [];
        if ($this->settings['settings']['chancenportal']['activate_offer_approval'] === '1') {
            $defaultDateCondition[] = $query->equals('approved', 1);
        }
        $now = new \DateTime('midnight');
        $defaultDateCondition[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->logicalAnd([
                $query->greaterThan('dateType', 0),
                $query->logicalOr([
                    $query->greaterThan('dates.endDate', $now->format('Y-m-d')),
                    $query->equals('dates.endDate', null),
                    $query->equals('dates.endDate', '0000-00-00')
                ])
            ])
        ]);
        if (count($defaultDateCondition)) {
            $constraints[] = $query->logicalOr($defaultDateCondition);
        }
        $params = [];
        if (isset($category)) {
            $params[] = $query->equals('categories.uid', $category);
        }
        if (count($params)) {
            $constraints[] = $query->logicalAnd($params);
        }
        $query = $query->matching($query->logicalAnd($constraints));
        $result = $query->execute();
        $result = $this->filterByDateRange($result, [
            'dates' => [
                $startDate,
                $endDate
            ]
        ]);
        return $result;
    }

    /**
     * @param int|null $limit
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|ObjectStorage|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllActive($limit = null)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $now = new \DateTime('midnight');
        $constraints[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->logicalAnd([
                $query->greaterThan('dateType', 0),
                $query->logicalOr([
                    $query->greaterThanOrEqual('dates.endDate', $now->format('Y-m-d')),
                    $query->equals('dates.endDate', null),
                    $query->equals('dates.endDate', '0000-00-00')
                ])
            ])
        ]);
        if ($this->settings['settings']['chancenportal']['activate_offer_approval'] === '1') {
            $constraints[] = $query->logicalAnd([
                $query->equals('active', 1),
                $query->equals('approved', 1)
            ]);
        } else {
            $constraints[] = $query->logicalAnd([
                $query->equals('active', 1)
            ]);
        }
        $query->setOrderings([
            'dates.startDate' => QueryInterface::ORDER_ASCENDING,
            'dates.startTime' => QueryInterface::ORDER_ASCENDING
        ]);
        $result = $query->matching($query->logicalAnd($constraints))->execute();
        $result = $this->filterByActiveProviders($result);
        $newResult = $this->sortOfferTypes($result->toArray());
        if ($limit) {
            $newResult = array_slice($newResult, 0, $limit);
        }
        return $newResult;
    }

    /**
     * @param Offer $offer
     * @param null $limit
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|ObjectStorage|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findSimilarOffers(Offer $offer, $limit = null)
    {
        $params = [];
        $now = new \DateTime('midnight');
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];
        if ($this->settings['settings']['chancenportal']['activate_offer_approval'] === '1') {
            $constraints[] = $query->equals('approved', 1);
        }
        $constraints[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->logicalAnd([
                $query->greaterThan('dateType', 0),
                $query->logicalOr([
                    $query->greaterThanOrEqual('dates.endDate', $now->format('Y-m-d')),
                    $query->equals('dates.endDate', null),
                    $query->equals('dates.endDate', '0000-00-00')
                ])
            ])
        ]);
        $constraints[] = $query->logicalAnd([
            $query->equals('active', 1)
        ]);
        $offerCategories = $offer->getCategories();
        if (!empty($offerCategories)) {
            $constraints_categories = [];
            foreach ($offer->getCategories() as $cat) {
                $constraints_categories[] = $query->equals('categories.uid', $cat->getUid());
            }
            $constraints[] = $query->logicalOr($constraints_categories);
        }
        if (count($params)) {
            $constraints[] = $query->logicalAnd($params);
        }
        $query->setOrderings([
            'dates.startDate' => QueryInterface::ORDER_ASCENDING,
            'dates.startTime' => QueryInterface::ORDER_ASCENDING
        ]);
        if ($limit) {
            $query->setLimit($limit);
        }
        $result = $query->matching($query->logicalAnd($constraints))->execute();
        $result = $this->filterByActiveProviders($result);
        return $result;
    }

    /**
     * @param $catId
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function logCategory($catId)
    {
        $cat = $this->categoryRepository->findByUid($catId);
        if ($cat) {
            $log = new Log();
            $log->setCategory($cat);
            $this->logRepository->add($log);
        }
    }

    /**
     * @param $term
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function logTerm($term)
    {
        $term = strtolower(trim($term));
        if (!empty($term)) {
            $log = new Log();
            $log->setTerm($term);
            $this->logRepository->add($log);
        }
    }

    /**
     * @param $fields
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return array|ObjectStorage|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFields($fields, $log = true)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $now = new \DateTime('midnight');
        $constraints[] = $query->logicalAnd([
            $query->equals('active', 1)
        ]);
        $constraints[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->logicalAnd([
                $query->greaterThan('dateType', 0),
                $query->logicalOr([
                    $query->greaterThan('dates.endDate', $now->modify('-1 day')->format('Y-m-d')),
                    $query->equals('dates.endDate', null),
                    $query->equals('dates.endDate', '0000-00-00')
                ])
            ])
        ]);
        if ($this->settings['settings']['chancenportal']['activate_offer_approval'] === '1') {
            $constraints[] = $query->equals('approved', 1);
        }
        if (count($fields)) {
            $params = [];
            if (isset($fields['targetGroups']) && count($fields['targetGroups'])) {
                $params[] = $query->in('targetGroups.uid', $fields['targetGroups']);
            }
            if (isset($fields['accessibility']) && $fields['accessibility'] === '1') {
                $params[] = $query->equals('accessibility', 2);
            }
            if (isset($fields['noCosts']) && $fields['noCosts'] === '1') {
                $params[] = $query->equals('noCosts', 1);
            }
            if (isset($fields['zip']) && !empty($fields['zip']) && empty($fields['distance']) && $fields['distance'] !== '0') {
                $constraints[] = $query->logicalOr([
                    $query->like('city', "%{$fields['zip']}%"),
                    $query->like('zip', "%{$fields['zip']}%")
                ]);
            }
            if (isset($fields['category'])) {
                $params[] = $query->in('categories.uid', [$fields['category']]);

                if($log) {
                    $this->logCategory($fields['category']);
                }
            }
            if (isset($fields['districts']) && count($fields['districts'])) {
                $params[] = $query->logicalOr([
                    $query->in('district.uid', $fields['districts']),
                    $query->equals('district', null),
                    $query->equals('district', 0)
                ]);
            }
            if (isset($fields['term']) && !empty($fields['term'])) {
                if($log) {
                    $this->logTerm($fields['term']);
                }

                $constraintsTerm = [
                    $query->like('longDescription', '%' . $fields['term'] . '%'),
                    $query->like('shortDescription', '%' . $fields['term'] . '%'),
                    $query->like('name', '%' . $fields['term'] . '%'),
                    $query->like('address', '%' . $fields['term'] . '%')
                ];

                $providers = $this->providerRepository->findByFields(['term' => $fields['term']], false);
                if(count($providers)) {
                    $constraintsTerm[] = $query->in('provider', $providers);
                }

                $params[] = $query->logicalOr($constraintsTerm);
            }
            if (count($params)) {
                $constraints[] = $query->logicalAnd($params);
            }
        }
        if ($fields['sort_offers'] === '2') {
            $query->setOrderings([
                'dates.uid' => QueryInterface::ORDER_DESCENDING,
                'dates.startTime' => QueryInterface::ORDER_ASCENDING
            ]);
        } else {
            $query->setOrderings([
                'dates.startDate' => QueryInterface::ORDER_ASCENDING,
                'dates.startTime' => QueryInterface::ORDER_ASCENDING
            ]);
        }
        $query = $query->matching($query->logicalAnd($constraints));
        //$queryParser = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser::class);
        //var_dump($queryParser->convertQueryToDoctrineQueryBuilder($query)->getSQL());
        $result = $query->execute();
        // Date Range
        if (isset($fields['dateType']) && $fields['dateType'] === '1' && count($fields['dates']) > 1) {
            $result = $this->filterByDateRange($result, $fields);
        }
        // Single Date
        if (isset($fields['dateType']) && $fields['dateType'] === '2' && !empty($fields['dates'][2])) {
            $result = $this->filterBySingleDate($result, $fields);
        }
        // Filter out week days
        if (isset($fields['dateType']) && $fields['dateType'] === '3') {
            $result = $this->filterByWeekdays($result, $fields);
        }
        // Calc distance to zip
        if (isset($fields['zip']) && !empty($fields['zip']) && isset($fields['distance']) && intval($fields['distance']) >= 1) {
            $result = $this->filterByDistance($result, $fields);
        }
        $newResult = $this->filterByActiveProviders($result);
        if (!isset($fields['sort_offers']) || $fields['sort_offers'] === '1') {
            $newResult = $this->sortOfferTypes($newResult->toArray());
        }
        return $newResult;
    }

    /**
     * @param $items
     * @return mixed
     */
    public function sortOfferTypes($items)
    {
        uasort($items, function ($a, $b) {    return $a->getNextDate() > $b->getNextDate();
            });
        return $items;
    }

    /**
     * @param $result
     * @return ObjectStorage
     */
    public function filterByActiveProviders($result)
    {
        $newResult = new ObjectStorage();
        foreach ($result as $key => $item) {
            if ($item->getProvider() && $item->getProvider()->getActive() && $item->getProvider()->getApproved()) {
                $newResult->attach($item);
            }
        }
        return $newResult;
    }

    /**
     * @param $result
     * @param $fields
     * @return ObjectStorage
     */
    public function filterByDistance($result, $fields)
    {
        $newResult = new ObjectStorage();
        $distance = intval($fields['distance']);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($fields['zip']) . '&sensor=false&components=country:DE&key=' . $this->settings['settings']['chancenportal']['google_maps_api_key'];
        $resultString = file_get_contents($url);
        $jsonResult = json_decode($resultString, true);
        if (!empty($jsonResult['results'])) {
            $zipLat = $jsonResult['results'][0]['geometry']['location']['lat'];
            $ziplng = $jsonResult['results'][0]['geometry']['location']['lng'];
            foreach ($result as $item) {
                if ($this->distance($zipLat, $ziplng, $item->getLat(), $item->getLng()) <= $distance) {
                    $newResult->attach($item);
                }
            }
            $result = $newResult;
        }
        return $result;
    }

    /**
     * @param $result
     * @param $fields
     * @return ObjectStorage
     */
    public function filterByWeekdays($result, $fields)
    {
        $newResult = new ObjectStorage();
        $selectedDays = $this->getSelectedDays($fields);
        if (count($selectedDays)) {
            foreach ($result as $item) {
                if ($item->getDateType() === 1) {
                    foreach ($item->getDates() as $date) {
                        foreach ($selectedDays as $day) {
                            if ($day === intval($date->getStartDate()->format('w'))) {
                                $newResult->attach($item);
                                continue 2;
                            }
                        }
                    }
                } elseif ($item->getDateType() === 2 || $item->getDateType() === 3) {
                    foreach ($item->getDates() as $date) {
                        $cloneStart = clone $date->getStartDate();
                        $cloneEnd = clone $date->getEndDate();
                        $cloneStart->modify('midnight');
                        $cloneEnd->modify('midnight');
                        do {    foreach ($selectedDays as $day) {
                                if ($day === intval($cloneStart->format('w'))) {
                                    $newResult->attach($item);
                                    break 2;
                                }
                            }
                            $cloneStart->modify('+1 day');
                        } while ($cloneStart <= $cloneEnd);
                    }
                } elseif ($item->getDateType() === 4) {
                    foreach ($item->getDates() as $date) {
                        $date->getStartDate()->modify('midnight');
                        if ($date->getActive()) {
                            foreach ($selectedDays as $day) {
                                if ($day === intval($date->getStartDate()->format('w'))) {
                                    $newResult->attach($item);
                                    break;
                                }
                            }
                        }
                    }
                } elseif ($item->getDateType() === 0) {
                    $newResult->attach($item);
                }
            }
            $result = $newResult;
        }
        return $result;
    }

    /**
     * @param $result
     * @param $fields
     * @return ObjectStorage
     */
    public function filterBySingleDate($result, $fields)
    {
        $newResult = new ObjectStorage();
        $startDate = \DateTime::createFromFormat('d.m.Y', $fields['dates'][2]);
        $startDate->modify('midnight');
        foreach ($result as $item) {
            // Filter Konkrete Daten
            if ($item->getDateType() === 1) {
                foreach ($item->getDates() as $date) {
                    if ($date->getStartDate()->format('Y-m-d') === $startDate->format('Y-m-d')) {
                        $newResult->attach($item);
                    }
                }
            } elseif ($item->getDateType() === 2 || $item->getDateType() === 3) {
                foreach ($item->getDates() as $date) {
                    $date->getStartDate()->modify('midnight');
                    $date->getEndDate()->modify('midnight');
                    if ($date->getStartDate() <= $startDate && $date->getEndDate() >= $startDate) {
                        $newResult->attach($item);
                    }
                }
            } elseif ($item->getDateType() === 4) {
                foreach ($item->getDates() as $date) {
                    $date->getStartDate()->modify('midnight');
                    if ($date->getEndDate()) {
                        $itemEndDate = $date->getEndDate()->modify('midnight');
                    } else {
                        $itemEndDate = null;
                    }
                    if ($date->getActive()) {
                        if ((!$itemEndDate || $itemEndDate >= $startDate) && $date->getStartDate() <= $startDate) {
                            if ($this->isDayCountInRange($date->getStartDate(), $startDate, $startDate)) {
                                $newResult->attach($item);
                            }
                        }
                    }
                }
            } elseif ($item->getDateType() === 0) {
                $newResult->attach($item);
            }
        }
        return $newResult;
    }

    /**
     * @param $result
     * @param $fields
     * @return ObjectStorage
     */
    public function filterByDateRange($result, $fields)
    {
        $newResult = new ObjectStorage();
        $startDate = \DateTime::createFromFormat('d.m.Y', $fields['dates'][0]);
        $endDate = \DateTime::createFromFormat('d.m.Y', $fields['dates'][1]);
        if (!$startDate) {
            return $result;
        }
        if (!$endDate) {
            $endDate = $startDate;
        }
        $startDate->modify('midnight');
        $endDate->modify('midnight');
        foreach ($result as $item) {
            // Filter Konkrete Daten
            if ($item->getDateType() === 1) {
                foreach ($item->getDates() as $date) {
                    $date->getStartDate()->modify('midnight');
                    if ($date->getEndDate()) {
                        $date->getEndDate()->modify('midnight');
                    }
                    if ($date->getStartDate() >= $startDate && $date->getStartDate() <= $endDate) {
                        $newResult->attach($item);
                    }
                }
            } elseif ($item->getDateType() === 2 || $item->getDateType() === 3) {
                foreach ($item->getDates() as $date) {
                    $date->getStartDate()->modify('midnight');
                    if ($date->getEndDate()) {
                        $date->getEndDate()->modify('midnight');
                    }
                    if ($date->getStartDate() >= $startDate && $date->getStartDate() <= $endDate || $date->getEndDate() >= $startDate && $date->getEndDate() <= $endDate || $date->getEndDate() >= $startDate && $date->getStartDate() <= $endDate) {
                        $newResult->attach($item);
                    }
                }
            } elseif ($item->getDateType() === 4) {
                foreach ($item->getDates() as $date) {
                    if (!$date->getStartDate()) {
                        continue;
                    }
                    $date->getStartDate()->modify('midnight');
                    if ($date->getEndDate()) {
                        $itemEndDate = $date->getEndDate()->modify('midnight');
                    } else {
                        $itemEndDate = null;
                    }
                    if ($date->getActive()) {
                        if (!$itemEndDate || $itemEndDate >= $startDate || $itemEndDate >= $endDate) {
                            if ($date->getStartDate() <= $startDate || $date->getStartDate() <= $endDate) {
                                if ($this->isDayCountInRange($date->getStartDate(), $startDate, $endDate)) {
                                    $newResult->attach($item);
                                }
                            }
                        }
                    }
                }
            } elseif ($item->getDateType() === 0) {
                $newResult->attach($item);
            }
        }
        return $newResult;
    }

    /**
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return float
     */
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return is_nan($miles) ? 0 : $miles * 1.609344;
    }

    /**
     * @param $date
     * @param $rangeStart
     * @param $rangeEnd
     * @return bool
     */
    function isDayCountInRange($date, $rangeStart, $rangeEnd)
    {
        $rangeStart = clone $rangeStart;
        $rangeEnd = clone $rangeEnd;
        $dayNr = intval($date->format('w'));
        while ($rangeStart <= $rangeEnd) {
            if (intval($rangeStart->format('w')) === $dayNr) {
                return true;
            }
            $rangeStart->modify('+1 day');
        }
        return false;
    }

    /**
     * @param $fields
     * @return array
     */
    private function getSelectedDays($fields)
    {
        $selectedDays = [];
        if (isset($fields['so']) && $fields['so'] === '1') {
            $selectedDays[] = 0;
        }
        if (isset($fields['mo']) && $fields['mo'] === '1') {
            $selectedDays[] = 1;
        }
        if (isset($fields['di']) && $fields['di'] === '1') {
            $selectedDays[] = 2;
        }
        if (isset($fields['mi']) && $fields['mi'] === '1') {
            $selectedDays[] = 3;
        }
        if (isset($fields['do']) && $fields['do'] === '1') {
            $selectedDays[] = 4;
        }
        if (isset($fields['fr']) && $fields['fr'] === '1') {
            $selectedDays[] = 5;
        }
        if (isset($fields['sa']) && $fields['sa'] === '1') {
            $selectedDays[] = 6;
        }
        return $selectedDays;
    }
}
