<?php

namespace Chancenportal\Chancenportal\Controller;

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

use Chancenportal\Chancenportal\Domain\Model\Log;
use Chancenportal\Chancenportal\Domain\Model\Offer;
use Chancenportal\Chancenportal\Utility\OfferUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * FrontendUserController
 */
class FrontendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
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
     * @var \Chancenportal\Chancenportal\Domain\Repository\LogRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $logRepository = null;

    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $providerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Utility\SelectUtility
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $selectUtility = null;

    /**
     * @var \UI\UiProvider\Service\CacheService
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $cacheService = null;
    /**
     * @var string
     */
    protected $entityNotFoundMessage = 'The requested entity could not be found.';

    /**
     * @var string
     */
    protected $unknownErrorMessage = 'An unknown error occurred.';

    /**
     * @var array
     */
    protected $requestArguments;

    /**
     * @var array
     */
    protected $getParameters;

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     * @return void
     * @throws \Exception
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    public function processRequest(\TYPO3\CMS\Extbase\Mvc\RequestInterface $request, \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response)
    {
        try {
            date_default_timezone_set('UTC');
            parent::processRequest($request, $response);
        } catch (\Exception $exception) {
            if ($exception instanceof \TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException || $exception instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException) {
                $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
            }
            throw $exception;
        }
    }

    /**
     * @return void
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    protected function callActionMethod()
    {
        try {
            parent::callActionMethod();
        } catch (\Exception $exception) {
            // This enables you to trigger the call of TYPO3s page-not-found handler by throwing \TYPO3\CMS\Core\Error\Http\PageNotFoundException
            if ($exception instanceof \TYPO3\CMS\Core\Error\Http\PageNotFoundException) {
                $GLOBALS['TSFE']->pageNotFoundAndExit($this->entityNotFoundMessage);
            }

            // If the plugin is configured to do so, we call the page-unavailable handler.
            if (isset($this->settings['usePageUnavailableHandler']) && $this->settings['usePageUnavailableHandler']) {
                $GLOBALS['TSFE']->pageUnavailableAndExit($this->unknownErrorMessage, 'HTTP/1.1 500 Internal Server Error');
            }
            // Else we append the error message to the response. This causes the error message to be displayed inside the normal page layout. WARNING: the plugins output may gets cached.
            if ($this->response instanceof \TYPO3\CMS\Extbase\Mvc\Web\Response) {
                $this->response->setStatus(500);
            }
            $this->response->appendContent($exception->getMessage());
        }
    }

    /**
     * Initialize Action
     */
    public function initializeAction()
    {
        $this->requestArguments = $this->request->getArguments();
        $this->getParameters = GeneralUtility::_GET();
        $registry = GeneralUtility::makeInstance(\Chancenportal\Chancenportal\Domain\Registry::class);

        if ((time() - (int)$registry->get('chancenportal', 'updateNextOfferDate_LastRun')) >= 86400) {
            OfferUtility::updateNextDate();
        }
    }

    /**
     * @return mixed|\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function teaserAction()
    {
        /** Cache rendered output */
        $teaser = $this->cacheService->getFromCacheOrSet('chancenportal', 'teaserAction', function() {
            $this->view->assign('settings', $this->settings);
            $this->view->assign('perimeters', $this->selectUtility->getPerimeters());
            $this->view->assign('categories', $this->selectUtility->getCategoriesForSelect(null, true, true, true));
            $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect(null, true));
            $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect(null, true));

            return $this->view->render();
        }, [], [], $this->settings['chancenportal']['caching']['lifetimes']['teaserAction']);

        return $teaser;
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("offer")
     * @param Offer $offer
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function offerDetailAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer = null)
    {
        if(!$offer) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('No offer selected or offer not active');
        }
        $this->response->addAdditionalHeaderData('<title>' . htmlspecialchars($offer->getName() . ' - ' . $GLOBALS['TSFE']->rootLine[0]['title']) . '</title>');
        $this->response->addAdditionalHeaderData('<meta name="description" content="' . htmlspecialchars($offer->getShortDescription()) . '">');

        $log = new Log();
        $log->setOffer($offer);
        $this->logRepository->add($log);

        $this->view->assign('similarOffers', $this->offerRepository->findSimilarOffers($offer, 8));
        $this->view->assign('offer', $offer);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
     * @param \Chancenportal\Chancenportal\Domain\Model\Provider|null $provider
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function providerDetailAction(\Chancenportal\Chancenportal\Domain\Model\Provider $provider = null)
    {
        if(!$provider || !$this->providerRepository->isActive($provider->getUid())) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('No provider selected or provider not active');
        }

        $this->response->addAdditionalHeaderData('<title>' . htmlspecialchars($provider->getName() . ' - ' . $GLOBALS['TSFE']->rootLine[0]['title']) . '</title>');
        $this->response->addAdditionalHeaderData('<meta name="description" content="' . htmlspecialchars($provider->getShortDescription()) . '">');
        $this->view->assign('provider', $provider);
    }

    /**
     * Ajax provider search call
     */
    public function searchProviderResultAjaxAction()
    {
        $postVars = GeneralUtility::_POST();

        /** Cache rendered output */
        $cacheKey = 'searchProviderResultAjaxAction_' . md5(serialize($postVars));
        $renderedResults = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($postVars) {
            $this->view->assign('settings', $this->settings);
            $this->view->assign('providers', $this->providerRepository->findByFields($postVars, true, true));

            return $this->view->render();
        }, [$postVars], [], $this->settings['chancenportal']['caching']['lifetimes']['searchProviderResultAjaxAction']);

        return $renderedResults;
    }

    /**
     * Aktuelle Angebote
     *
     * @return mixed|\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function offersTeaserAction()
    {
        /** Cache rendered output instead of serialized domain objects, which would be way too big */
        $offers = $this->cacheService->getFromCacheOrSet('chancenportal', 'offersTeaserAction', function() {
            $this->view->assign('settings', $this->settings);
            $this->view->assign('offers', $this->offerRepository->findAllActive(7, null, null, [1,2,3,4]));

            return $this->view->render();
        }, [], [], $this->settings['chancenportal']['caching']['lifetimes']['offersTeaserAction']);

        return $offers;
    }

    /**
     * Auswahl einiger Anbieter
     *
     * @return mixed|\TYPO3\CMS\Core\Cache\Frontend\FrontendInterface
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function providerTeaserAction()
    {
        /** Cache rendered output instead of serialized domain objects, which would be way too big */
        $providers = $this->cacheService->getFromCacheOrSet('chancenportal', 'providerTeaserAction', function() {
            $providers = $this->providerRepository->findAllActive();
            $providers = $providers->toArray();
            shuffle($providers);
            $providers = array_slice($providers, 0, 4);

            $this->view->assign('settings', $this->settings);
            $this->view->assign('providers', $providers);

            return $this->view->render();
        }, [], [], $this->settings['chancenportal']['caching']['lifetimes']['providerTeaserAction']);

        return $providers;
    }

    /**
     * Provider search result page
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function searchProviderResultsAction()
    {
        $sorting = [
            [
                "id" => "3",
                "title" => "A-Z",
                "active" => true
            ],
            [
                "id" => "1",
                "title" => "Neuste",
                "active" => false
            ]
        ];

        $postVars = GeneralUtility::_POST();

        /** Cache rendered output */
        $cacheKey = 'searchProviderResultsAction_' . md5(serialize($postVars));
        $renderedResults = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($sorting, $postVars) {
            $this->view->assign('perimeters', $this->selectUtility->getPerimeters());
            $this->view->assign('settings', $this->settings);
            $this->view->assign('providers', $this->providerRepository->findByFields($postVars, true, true));
            $this->view->assign('categories', $this->selectUtility->getProviderCategoriesForSelect());
            $this->view->assign('sorting', json_encode($sorting));
            $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect(null, true));
            $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect(null, true));

            return $this->view->render();
        }, [$sorting, $postVars], [], $this->settings['chancenportal']['caching']['lifetimes']['searchProviderResultsAction']);

        return $renderedResults;
    }

    /**
     * Offer search result page
     *
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function searchResultsAction()
    {
        $tabConfig = [
            [
                "name" => 'Kachelansicht',
                "icon" => 'th-large',
                "active" => true,
                "actions" => [
                    [
                        "selector" => 'custom-map',
                        "prop" => [
                            "show" => false
                        ],
                    ],
                    [
                        "selector" => 'custom-pagination',
                        "prop" => [
                            "show" => true
                        ],
                    ]
                ]
            ],
            [
                "name" => 'Auf Karte anzeigen',
                "icon" => 'map-marker',
                "active" => false,
                "actions" => [
                    [
                        "selector" => 'custom-map',
                        "prop" => [
                            "show" => true
                        ],
                    ],
                    [
                        "selector" => 'custom-pagination',
                        "prop" => [
                            "show" => false
                        ],
                    ]
                ]
            ]
        ];

        $sortingOffers = [
            [
                "id" => "1",
                "title" => "Aktualität",
                "active" => true
            ],
            [
                "id" => 2,
                "title" => "Zuletzt eingestellt",
                "active" => false
            ]
        ];

        $sortingProviders = [
            [
                "id" => "3",
                "title" => "A-Z",
                "active" => true
            ],
            [
                "id" => "1",
                "title" => "Aktualität",
                "active" => false
            ]
        ];

        $postVars = $this->similiarSearch();

        $offset = !empty($postVars['offset']) ? (int)$postVars['offset'] : 0;
        $offset = !empty($this->requestArguments['offset']) ? (int)$this->requestArguments['offset'] : $offset;
        $limit = !empty($this->requestArguments['limit']) ? (int)$this->requestArguments['limit'] : 10;

        $offsetProvider = !empty($postVars['offset-provider']) ? (int)$postVars['offset-provider'] : 0;
        $offsetProvider = !empty($this->requestArguments['offset-provider']) ? (int)$this->requestArguments['offset-provider'] : $offsetProvider;
        $limitProvider = !empty($this->requestArguments['limit-provider']) ? (int)$this->requestArguments['limit-provider'] : 10;

        /** Cache rendered output */
        $cacheKey = 'searchResultsAction_' . md5(serialize($postVars).'_offset-'.$offset.'_limit-'.$limit);
        $renderedResults = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($postVars, $offset, $limit, $offsetProvider, $limitProvider, $tabConfig, $sortingOffers, $sortingProviders) {
            $this->view->assign('settings', $this->settings);
            $this->view->assign('postVars', $postVars);

            $this->view->assign('offers', $this->offerRepository->findByFields($postVars, true, $offset, $limit));
            $this->view->assign('offers-total', $this->offerRepository->findByFields($postVars, true)->count());
            $this->view->assign('offers-offset', $offset);
            $this->view->assign('offers-limit', $limit);

            $this->view->assign('providers', $this->providerRepository->findByFields($postVars, true, true, $offsetProvider, $limitProvider));
            $this->view->assign('providers-total', $this->providerRepository->findByFields($postVars, true, false)->count());
            $this->view->assign('providers-offset', $offsetProvider);
            $this->view->assign('providers-limit', $limitProvider);

            $this->view->assign('perimeters', $this->selectUtility->getPerimeters());
            $this->view->assign('categories', $this->selectUtility->getCategoriesForSelect(null, true, true, true, (int)$postVars['category']));
            $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect(null, true));
            $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect(null, true, false, (array)$postVars['districts']));
            $this->view->assign('tabConfig', json_encode($tabConfig));
            $this->view->assign('sortingOffers', json_encode($sortingOffers));
            $this->view->assign('sortingProviders', json_encode($sortingProviders));

            return $this->view->render();
        }, [$postVars, $offset, $limit, $offsetProvider, $limitProvider, $tabConfig, $sortingOffers, $sortingProviders], [], $this->settings['chancenportal']['caching']['lifetimes']['searchResultsAction']);

        return $renderedResults;
    }

    /**
     * Ajax offer and provider search call
     */
    public function searchResultAjaxAction()
    {
        $postVars = $this->similiarSearch();

        $offset = !empty($postVars['offset']) ? (int)$postVars['offset'] : 0;
        $offset = !empty($this->requestArguments['offset']) ? (int)$this->requestArguments['offset'] : $offset;
        $limit = !empty($this->requestArguments['limit']) ? (int)$this->requestArguments['limit'] : 10;

        $offsetProvider = !empty($postVars['offset-provider']) ? (int)$postVars['offset-provider'] : 0;
        $offsetProvider = !empty($this->requestArguments['offset-provider']) ? (int)$this->requestArguments['offset-provider'] : $offsetProvider;
        $limitProvider = !empty($this->requestArguments['limit-provider']) ? (int)$this->requestArguments['limit-provider'] : 10;

        /** Cache rendered output */
        $cacheKey = 'searchResultAjaxAction_' . md5(serialize($postVars).'_offset-'.$offset.'_limit-'.$limit);
        $renderedResults = $this->cacheService->getFromCacheOrSet('chancenportal', $cacheKey, function($postVars, $offset, $limit, $offsetProvider, $limitProvider) {
            $this->view->assign('settings', $this->settings);
            $this->view->assign('postVars', $postVars);

            $this->view->assign('offers', $this->offerRepository->findByFields($postVars, true, $offset, $limit));
            $this->view->assign('offers-total', $this->offerRepository->findByFields($postVars, true)->count());
            $this->view->assign('offers-offset', $offset);
            $this->view->assign('offers-limit', $limit);

            $this->view->assign('providers', $this->providerRepository->findByFields($postVars, true, true, $offsetProvider, $limitProvider));
            $this->view->assign('providers-total', $this->providerRepository->findByFields($postVars, true, false)->count());
            $this->view->assign('providers-offset', $offsetProvider);
            $this->view->assign('providers-limit', $limitProvider);

            return $this->view->render();
        }, [$postVars, $offset, $limit, $offsetProvider, $limitProvider], [], $this->settings['chancenportal']['caching']['lifetimes']['searchResultAjaxAction']);

        return $renderedResults;
    }

    /**
     * @return mixed
     */
    protected function similiarSearch() {
        $postVars = GeneralUtility::_POST();
        $postVars = array_merge_recursive($postVars, $this->requestArguments);

        if (!empty($postVars['termOriginal'])) {
            $postVars['term'] = $postVars['termOriginal'];
        }

        if(!empty($postVars['term'])) {
            $similarTerms = $this->offerRepository->getSimilarSearchTerms($postVars['term'], $this->settings);
            $this->view->assign('similarTerms', $similarTerms);
            $postVars['termOriginal'] = $postVars['term'];
            $postVars['term'] = array_merge([$postVars['term']], $similarTerms);
        }

        return $postVars;
    }
}
