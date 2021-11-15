<?php

namespace Chancenportal\Chancenportal\Utility;

use Chancenportal\Chancenportal\Domain\Model\Offer;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class MailUtility
 * @codeCoverageIgnore
 */
class SelectUtility
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\CarrierRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $carrierRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\CategoryRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $categoryRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\DistrictRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $districtRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\TargetGroupRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $targetGroupRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $offerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $providerRepository = null;

    /**
     * @var \UI\UiProvider\Service\CacheService
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $cacheService = null;

    /**
     * @param null $provider
     * @param bool $onlyAssignedItems
     * @return string
     */
    public function getCarrierForSelect($provider = null, $onlyAssignedItems = false)
    {
        $carrierItems = [
            [
                'id' => '',
                'title' => 'Bitte wählen',
                'active' => false,
            ],
        ];

        $allInactive = true;

        foreach ($this->carrierRepository->findAll() as $item) {
            $isItemActive = $provider && $provider->getCarrier() && $provider->getCarrier()->getUid() === $item->getUid();

            $carrierItems[] = [
                'id' => $item->getUid(),
                'title' => $item->getName(),
                'active' => $isItemActive,
            ];
            if ($isItemActive) {
                $allInactive = false;
            }
        }

        if ($allInactive) {
            $carrierItems[0]['active'] = true;
        }

        return json_encode($carrierItems);
    }

    /**
     * @param $category
     * @return int
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function categoryHasActiveOffers($category) {

        $query = $this->offerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];
        $constraints[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->greaterThan('dates.startDate', new \DateTime())
        ]);
        $constraints[] = $query->in('categories.uid', [$category->getUid()]);
        $constraints[] = $query->equals('active', 1);
        $query->matching($query->logicalAnd($constraints));
        $offers = $query->execute();

        return count($offers) > 0;
    }

    /**
     * @param $category
     * @return int
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function categoryHasActiveProviders($category) {

        $query = $this->providerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];

        $constraints[] = $query->logicalNot($query->equals('name', ''));

        $constraints[] = $query->in('categories.uid', [$category->getUid()]);
        $query->matching($query->logicalAnd($constraints));
        $providers = $query->execute();

        return count($providers) > 0;
    }

    /**
     * @param $targetGroup
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function targetGroupHasActiveOffers($targetGroup) {

        $query = $this->offerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];
        $constraints[] = $query->in('targetGroups.uid', [$targetGroup->getUid()]);
        $constraints[] = $query->equals('active', 1);
        $query->matching($query->logicalAnd($constraints));
        $offers = $query->execute();

        return count($offers) > 0;
    }

    /**
     * @param $district
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function districtHasActiveOffers($district) {

        $query = $this->offerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];
        $constraints[] = $query->logicalOr([
            $query->equals('dateType', 0),
            $query->greaterThan('dates.startDate', new \DateTime())
        ]);
        $constraints[] = $query->in('district', [$district->getUid()]);
        $constraints[] = $query->equals('active', 1);
        $query->matching($query->logicalAnd($constraints));
        $offers = $query->execute();

        return count($offers) > 0;
    }

    /**
     * @return array
     */
    public function getPerimeters()
    {
        $values = [1,2,3,4,5,10,15,20,50,100, 0];
        $categoryItems = [
            [
                'id' => '',
                'title' => 'Umkreis km',
                'active' => true,
            ],
        ];

        foreacH($values as $val) {
            $categoryItems[] = [
                'id' => $val,
                'title' => $val > 0 ? $val . ' km' : 'Unbegrenzt',
                'active' => false,
            ];
        }
        return json_encode($categoryItems);
    }

    public function getProviderUsersForSelect($provider) {
        $items = [];
        $users = UserUtility::getUsersByProvider($provider);
        foreach ($users as $user) {
            $items[] = [
                'id' => $user->getUid(),
                'title' => $user->getName(),
                'active' => $provider->getAuthor() && $provider->getAuthor()->getUid() === $user->getUid() ? true : false,
            ];
        }
        return count($items) ? json_encode($items) : null;
    }


    public function getPlzForSelect() {
        $plzItems = [];
        $offers = $this->offerRepository->findAll();
        foreach($offers as $offer) {
            if(!empty($offer->getZip()) && $offer->getDateType() > 0) {
                $plzItems[$offer->getZip()] = [
                    'id' => $offer->getZip(),
                    'title' => $offer->getZip(),
                    'active' => false,
                ];
            }
        }
        ksort($plzItems);
        return json_encode(array_values($plzItems));
    }

    /**
     * @param null $offerOrProvider
     * @param bool $showCategoryAll
     * @param bool $onlyWithAssignments
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getCategoriesForSelect($offerOrProvider = null, $showCategoryAll = true, $onlyWithAssignments = false, $useProviderCategories = false, $activeCategory = null)
    {
        /** Cache rendered output */
        $cacheKeyValues = [
            !empty($offerOrProvider) ? get_class($offerOrProvider) . ':' . $offerOrProvider->getUid() : null,
            $showCategoryAll,
            $onlyWithAssignments,
            $useProviderCategories,
            $activeCategory
        ];
        $cacheKey = 'getCategoriesForSelect_' . md5(serialize($cacheKeyValues));
        $categoryItems = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($offerOrProvider, $showCategoryAll, $onlyWithAssignments, $useProviderCategories, $activeCategory) {
            $categoryItems = [];

            if ($showCategoryAll) {
                $categoryItems[] = [
                    'id' => '',
                    'title' => 'Alle Kategorien',
                    'active' => false,
                ];
            }

            $allInactive = true;

            foreach ($this->categoryRepository->findRootCategories() as $item) {

                if($onlyWithAssignments && $this->categoryHasActiveOffers($item) === false && ($useProviderCategories === false || $this->categoryHasActiveProviders($item) === false)) {
                    continue;
                }

                $isItemActive = $activeCategory ? $activeCategory === $item->getUid() : $offerOrProvider && $offerOrProvider->getCategories() && $offerOrProvider->getCategories()->contains($item);
                $isSubItemActive = false;
                $subCategoryItems = [];

                foreach ($item->getChildren() as $child) {

                    if($onlyWithAssignments && $this->categoryHasActiveOffers($child) === false && ($useProviderCategories === false || $this->categoryHasActiveProviders($child) === false)) {
                        continue;
                    }

                    $isSubItemActive = $activeCategory ? $activeCategory === $child->getUid() : $offerOrProvider && $offerOrProvider->getCategories() && $offerOrProvider->getCategories()->contains($child);

                    $subCategoryItems[] = [
                        'id' => $child->getUid(),
                        'title' => $child->getName(),
                        'active' => $isSubItemActive,
                    ];
                }

                if ($isItemActive || $isSubItemActive) {
                    $allInactive = false;
                }

                $tempItem = [
                    'id' => $item->getUid(),
                    'title' => $item->getName(),
                    'active' => $isItemActive === true,
                ];

                if(!empty($subCategoryItems)) {
                    $tempItem['items'] = $subCategoryItems;
                }

                $categoryItems[] = $tempItem;
            }

            if($allInactive && $showCategoryAll) {
                $categoryItems[0]['active'] = true;
            }

            return $categoryItems;
        }, [$offerOrProvider, $showCategoryAll, $onlyWithAssignments, $useProviderCategories, $activeCategory], [], 86400);

        return json_encode($categoryItems);
    }

    /**
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getProviderCategoriesForSelect()
    {
        $categoryItems = [];

        $categoryItems[] = [
            'id' => '',
            'title' => 'Alle Kategorien',
            'active' => false,
        ];

        $allInactive = true;

        foreach ($this->categoryRepository->findRootCategories() as $item) {

            if($this->categoryHasActiveProviders($item) === false) {
                continue;
            }

            $isItemActive = false;
            $isSubItemActive = false;
            $subCategoryItems = [];

            foreach ($item->getChildren() as $child) {

                if($this->categoryHasActiveProviders($child) === false) {
                    continue;
                }

                $isSubItemActive = false;

                $subCategoryItems[] = [
                    'id' => $child->getUid(),
                    'title' => $child->getName(),
                    'active' => $isSubItemActive,
                ];
            }

            if ($isItemActive || $isSubItemActive) {
                $allInactive = false;
            }

            $categoryItems[] = [
                'id' => $item->getUid(),
                'title' => $item->getName(),
                'active' => $isItemActive === true,
                'items' => $subCategoryItems,
            ];
        }

        if($allInactive) {
            $categoryItems[0]['active'] = true;
        }

        return json_encode($categoryItems);
    }

    /**
     * @param Offer|null $offer
     * @param bool $onlyWithAssignments
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getTargetGroupsForSelect(Offer $offer = null, $onlyWithAssignments = false)
    {
        /** Cache rendered output */
        $cacheKeyValues = [
            'offer' => $offer ? $offer->getUid() : null,
            'onlyWithAssignments' => $onlyWithAssignments
        ];
        $cacheKey = 'getTargetGroupsForSelect_' . md5(serialize($cacheKeyValues));
        $categoryItems = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($offer, $onlyWithAssignments) {
            $categoryItems = [];

            foreach ($this->targetGroupRepository->findAll() as $item) {

                if($onlyWithAssignments && $this->targetGroupHasActiveOffers($item) === false) {
                    continue;
                }

                $isItemActive = $offer && $offer->getTargetGroups() && $offer->getTargetGroups()->contains($item);

                $categoryItems[] = [
                    'id' => $item->getUid(),
                    'title' => $item->getName(),
                    'active' => $isItemActive,
                ];
            }

            return $categoryItems;
        }, [$offer, $onlyWithAssignments], [], 86400);

        return json_encode($categoryItems);
    }

    /**
     * @param null $offer
     * @param bool $onlyWithAssignments
     * @param bool $addItemForAllDistricts
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getDistrictsForSelect($offer = null, $onlyWithAssignments = false, $addItemForAllDistricts = false, $activeDistricts = [])
    {
        /** Cache rendered output */
        $cacheKeyValues = [
            'offer' => $offer ? $offer->getUid() : null,
            'onlyWithAssignments' => $onlyWithAssignments,
            'addItemForAllDistricts' => $addItemForAllDistricts
        ];
        $cacheKey = 'getDistrictsForSelect_' . md5(serialize($cacheKeyValues));
        $districtItems = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($offer, $onlyWithAssignments, $addItemForAllDistricts) {
            $districtItems = [];

            $hasActive = false;
            foreach ($this->districtRepository->findAll() as $item) {

                if($onlyWithAssignments && $this->districtHasActiveOffers($item) === false) {
                    continue;
                }

                $isItemActive = $offer && $offer->getDistrict() && $offer->getDistrict()->getUid() === $item->getUid();

                if($isItemActive) {
                    $hasActive = true;
                }

                $districtItems[] = [
                    'id' => $item->getUid(),
                    'title' => $item->getName(),
                    'active' => $isItemActive,
                ];
            }

            if($addItemForAllDistricts) {
                $districtItems[] = [
                    'id' => 0,
                    'title' => 'Alle Ortsteile',
                    'active' => !$hasActive,
                ];
            }

            return $districtItems;
        }, [$offer, $onlyWithAssignments, $addItemForAllDistricts], [], 86400);

        foreach ($districtItems as &$districtItem) {
            if (in_array((string)$districtItem['id'], $activeDistricts)) {
                $districtItem['active'] = true;
            }
        }

        return json_encode($districtItems);
    }

    /**
     * @return string
     */
    public function getSalutationsJson($offer = null)
    {

        $districtItems = [
            [
                'id' => 0,
                'title' => 'Frau',
                'active' => !$offer || ($offer && $offer->getContactSalutation() === 0),
            ],
            [
                'id' => 1,
                'title' => 'Herr',
                'active' => ($offer && $offer->getContactSalutation() === 1),
            ],
        ];
        return json_encode($districtItems);
    }
}
