<?php

namespace Chancenportal\Chancenportal\Domain\Repository;

use Chancenportal\Chancenportal\Domain\Model\Date;
use Chancenportal\Chancenportal\Domain\Model\Log;
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
 * The repository for Providers
 */
class ProviderRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     * @inject
     */
    protected $offerRepository = null;

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
        $term = mb_strtolower(trim(implode(', ', $term)));

        if (!empty($term)) {
            $log = new Log();
            $log->setTerm($term);
            $this->logRepository->add($log);
        }
    }

    /**
     * @param null $uid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllActive($uid = null)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        if (!is_null($uid)) {
            $constraints[] = $query->equals('uid', $uid);
        }
        $constraints[] = $query->logicalAnd(
            [
                $query->equals('active', 1),
                $query->equals('approved', 1)
            ]
        );
        $constraints[] = $query->logicalNot($query->equals('name', ''));
        return $query->matching($query->logicalAnd($constraints))->execute();
    }

    /**
     * @param $uid
     * @return bool
     */
    public function isActive($uid)
    {
        $results = $this->findAllActive($uid);
        return count($results) > 0 ? true : false;
    }

    /**
     * @param $fields
     * @param $log
     * @param $onlyActiveOffers
     * @return array|ObjectStorage|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByFields($fields, $log = true, $onlyActiveOffers = false)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints[] = $query->logicalAnd(
            [
                $query->equals('active', 1),
                $query->equals('approved', 1)
            ]
        );
        if (!empty($fields['term'])) {
            $fields['term'] = (array)$fields['term'];
        }
        $constraints[] = $query->logicalNot($query->equals('name', ''));
        if (count($fields)) {
            $params = [];
            if (isset($fields['targetGroups']) && count($fields['targetGroups'])) {
                $params[] = $query->in('offers.targetGroups.uid', $fields['targetGroups']);
            }
            if (isset($fields['zip']) && !empty($fields['zip']) && empty($fields['distance']) && $fields['distance'] !== '0') {
                $constraints[] = $query->logicalOr(
                    [
                        $query->like('city', "%{$fields['zip']}%"),
                        $query->like('zip', "%{$fields['zip']}%")
                    ]
                );
            }
            if (isset($fields['category'])) {
                $params[] = $query->in('categories.uid', [$fields['category']]);
                if ($log) {
                    $this->logCategory($fields['category']);
                }
            }
            if (isset($fields['participation']) && $fields['participation'] === '1') {
                $params[] = $query->equals('participation', 1);
            }
            if (isset($fields['districts']) && count($fields['districts'])) {
                $params[] = $query->in('offers.district.uid', $fields['districts']);
            }
            if (isset($fields['dateType']) && $fields['dateType'] === '1' && count($fields['dates']) > 1) {
                $dates = [];
                $dates2 = [];
                $dates3 = [];
                if (!empty($fields['dates'][0])) {
                    $dates[] = $query->greaterThanOrEqual('offers.dates.startDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][0])->format('Y-m-d'));
                    $dates2[] = $query->greaterThanOrEqual('offers.dates.endDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][0])->format('Y-m-d'));
                    $dates3[] = $query->greaterThanOrEqual('offers.dates.endDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][0])->format('Y-m-d'));
                }
                if (!empty($fields['dates'][1])) {
                    $dates[] = $query->lessThanOrEqual('offers.dates.startDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][1])->format('Y-m-d'));
                    $dates2[] = $query->lessThanOrEqual('offers.dates.endDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][1])->format('Y-m-d'));
                    $dates3[] = $query->lessThanOrEqual('offers.dates.startDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][1])->format('Y-m-d'));
                }
                if (count($dates)) {
                    $params[] = $query->logicalOr(
                        [
                            $query->logicalAnd($dates),
                            $query->logicalAnd($dates2),
                            $query->logicalAnd($dates3)
                        ]
                    );
                }
            } elseif (isset($fields['dateType']) && $fields['dateType'] === '2' && !empty($fields['dates'][2])) {
                $dates = [];
                $dates[] = $query->lessThanOrEqual('offers.dates.startDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][2])->format('Y-m-d'));
                $dates[] = $query->greaterThanOrEqual('offers.dates.endDate', \DateTime::createFromFormat('d.m.Y', $fields['dates'][2])->format('Y-m-d'));
                $params[] = $query->logicalAnd($dates);
            }
            if (isset($fields['term']) && is_array($fields['term'])) {
                if ($log) {
                    $this->logTerm($fields['term']);
                }
                $arr = [];
                foreach ($fields['term'] as $tm) {
                    $arr[] = $query->like('name', '%' . $tm . '%');
                    $arr[] = $query->like('subline', '%' . $tm . '%');
                    $arr[] = $query->like('shortDescription', '%' . $tm . '%');
                    $arr[] = $query->like('longDescription', '%' . $tm . '%');
                }
                $params[] = $query->logicalOr($arr);
            }
            if (count($params)) {
                $constraints[] = $query->logicalAnd($params);
            }
        }
        if (!isset($fields['sort_providers']) || $fields['sort_providers'] === '3') {
            $query->setOrderings(['name' => QueryInterface::ORDER_ASCENDING]);
        } else {
            $query->setOrderings(['uid' => QueryInterface::ORDER_DESCENDING]);
        }
        $result = $query->matching($query->logicalAnd($constraints))->execute();
        if (isset($fields['dateType']) && $fields['dateType'] === '3') {
            $newResult = new ObjectStorage();
            $selectedDays = $this->getSelectedDays($fields);
            if (count($selectedDays)) {
                foreach ($result as $provider) {
                    foreach ($provider->getOffers() as $item) {
                        if ($item->getDateType() === 0) {
                            $newResult->attach($provider);
                        } else {
                            foreach ($item->getDates() as $date) {
                                $weekDays = $this->getWeekDays($date);
                                foreach ($selectedDays as $day) {
                                    if (in_array($day, $weekDays, true)) {
                                        $newResult->attach($provider);
                                        continue 2;
                                    }
                                }
                            }
                        }
                    }
                }
                $result = $newResult;
            }
        }

        // Calc distance to zip
        if (isset($fields['zip']) && !empty($fields['zip']) && isset($fields['distance']) && intval($fields['distance']) >= 1) {
            $newResult = new ObjectStorage();
            $distance = intval($fields['distance']);
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($fields['zip']) . '&sensor=false&components=country:DE&key=' . $this->settings['settings']['chancenportal']['google_maps_api_key'];
            $resultString = file_get_contents($url);
            $jsonResult = json_decode($resultString, true);
            if (!empty($jsonResult['results'])) {
                $zipLat = $jsonResult['results'][0]['geometry']['location']['lat'];
                $ziplng = $jsonResult['results'][0]['geometry']['location']['lng'];
                foreach ($result as $provider) {
                    foreach ($provider->getOffers() as $item) {
                        if ($this->distance($zipLat, $ziplng, $item->getLat(), $item->getLng()) <= $distance) {
                            $newResult->attach($provider);
                            continue 2;
                        }
                    }
                }
                $result = $newResult;
            }
        }

        //Get active offers
        if ($onlyActiveOffers) {
            $newResult = new ObjectStorage();
            foreach ($result as $provider) {
                $offers = new ObjectStorage();
                $_offers = $this->offerRepository->findAllActive(null, $provider);
                foreach ($_offers as $_offer) {
                    $offers->attach($_offer);
                }
                $provider->setOffers($offers);
                $newResult->attach($provider);
            }
            $result = $newResult;
        }
        return $result;
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
        return $miles * 1.609344;
    }

    /**
     * @param $fields
     * @return array
     */
    private function getSelectedDays($fields)
    {
        $selectedDays = [];
        if (isset($fields['so'])) {
            $selectedDays[] = 0;
        }
        if (isset($fields['mo'])) {
            $selectedDays[] = 1;
        }
        if (isset($fields['di'])) {
            $selectedDays[] = 2;
        }
        if (isset($fields['mi'])) {
            $selectedDays[] = 3;
        }
        if (isset($fields['do'])) {
            $selectedDays[] = 4;
        }
        if (isset($fields['fr'])) {
            $selectedDays[] = 5;
        }
        if (isset($fields['sa'])) {
            $selectedDays[] = 6;
        }
        return $selectedDays;
    }

    /**
     * @param Date $date
     * @return array
     * @throws \Exception
     */
    private function getWeekDays(Date $date)
    {
        $days = [];
        $now = new \DateTime('midnight');
        if ($date->getStartDate() >= $now) {
            if ($date->getStartDate() && $date->getEndDate() && $date->getStartDate()->format('dmY') === $date->getEndDate()->format('dmY')) {
                $days[] = intval($date->getStartDate()->format('w'));
            } elseif ($date->getStartDate() && $date->getEndDate()) {
                $startDate = clone $date->getStartDate();
                $endDate = clone $date->getEndDate();
                while ($startDate <= $endDate) {
                    $days[] = intval($startDate->format('w'));
                    $startDate->modify('+1 day');
                }
            }
        }
        return $days;
    }
}
