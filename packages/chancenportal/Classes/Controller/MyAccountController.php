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

use Chancenportal\Chancenportal\Domain\Model\Date;
use Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup;
use Chancenportal\Chancenportal\Domain\Model\Offer;
use Chancenportal\Chancenportal\Domain\Model\Provider;
use Chancenportal\Chancenportal\Utility\MailUtility;
use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * FrontendUserController
 */
class MyAccountController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    private $typeToNames = [
        'Ohne Termin',
        'Konkrete Daten',
        'Zeitraum',
        'Täglich',
        'Wöchentlich',
    ];
    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     * @inject
     */
    protected $providerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\CarrierRepository
     * @inject
     */
    protected $carrierRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\DistrictRepository
     * @inject
     */
    protected $districtRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\TargetGroupRepository
     * @inject
     */
    protected $targetGroupRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\OfferRepository
     * @inject
     */
    protected $offerRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Utility\SelectUtility
     * @inject
     */
    protected $selectUtility = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\Session
     */
    protected $persistenceSession = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\LogRepository
     * @inject
     */
    protected $logRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $frontendUserGroupRepository = null;

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\Generic\Session $persistenceSession
     */
    public function injectPersistenceSession(\TYPO3\CMS\Extbase\Persistence\Generic\Session $persistenceSession)
    {
        $this->persistenceSession = $persistenceSession;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Mvc\RequestInterface $request
     * @param \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
     * @return void
     * @throws \Exception
     * @override \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
     */
    public function processRequest(
        \TYPO3\CMS\Extbase\Mvc\RequestInterface $request,
        \TYPO3\CMS\Extbase\Mvc\ResponseInterface $response
    ) {
        try {
            parent::processRequest($request, $response);
        } catch (\Exception $exception) {
            if (($exception instanceof \TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException) ||
                ($exception instanceof \TYPO3\CMS\Extbase\Property\Exception\InvalidSourceException)) {

                $GLOBALS['TSFE']->pageNotFoundAndExit('Page not found');
            }
            throw $exception;
        }
    }

    /**
     * Übersichtsseite
     */
    public function overviewPageAction()
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if ($isAdmin) {
            $constraints = [];
            $query = $this->providerRepository->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(false);
            $constraints[] = $query->logicalAnd([
                $query->equals('approved', 0)
            ]);
            $providers = $query->matching($query->logicalAnd($constraints))->execute();

            $constraints = [];
            $query = $this->offerRepository->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(false);
            $constraints[] = $query->logicalAnd([
                $query->equals('approved', 0)
            ]);
            $offers = $query->matching($query->logicalAnd($constraints))->execute();

            $constraints = [];
            $query = $this->frontendUserRepository->createQuery();
            $query->getQuerySettings()->setRespectStoragePage(false);
            $constraints[] = $query->logicalAnd([
                $query->equals('disable', 1)
            ]);
            $users = $query->matching($query->logicalAnd($constraints))->execute();

            $this->view->assign('users', count($users));
            $this->view->assign('offers', count($offers));
            $this->view->assign('providers', count($providers));
        }

        $this->view->assign('user', $currentUser);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeCompanyProfilePageAction()
    {
        if (($request = $this->request->getOriginalRequest())) {
            $propertyMappingConfiguration = $this->arguments->getArgument('provider')->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->allowCreationForSubProperty('labels.*');
            $propertyMappingConfiguration
                ->allowProperties('labels')
                ->forProperty('labels')
                ->allowAllProperties()
                ->forProperty('*')
                ->allowAllProperties();
        }
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeCompanyProfileSaveAction()
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('provider')->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->allowCreationForSubProperty('labels.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('labels.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
        $propertyMappingConfiguration
            ->allowProperties('labels')
            ->forProperty('labels')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties();
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeAdminCompanyProfileSaveAction()
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('provider')->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->allowCreationForSubProperty('labels.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
        $propertyMappingConfiguration
            ->allowProperties('labels')
            ->forProperty('labels')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties();
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeProviderPreviewAction()
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('provider')->getPropertyMappingConfiguration();

        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED,
            true);
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);

        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->allowCreationForSubProperty('labels.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
        $propertyMappingConfiguration
            ->allowProperties('labels')
            ->forProperty('labels')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties();
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    protected function initializeNewOfferPageAction()
    {
        if (($request = $this->request->getOriginalRequest())) {
            $propertyMappingConfiguration = $this->arguments->getArgument('offer')->getPropertyMappingConfiguration();

            $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
            $propertyMappingConfiguration->allowCreationForSubProperty('dates.*');

            $propertyMappingConfiguration
                ->allowProperties('dates')
                ->forProperty('dates')
                ->allowAllProperties()
                ->forProperty('*')
                ->allowAllProperties()
                ->forProperty('*')
                ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

            $propertyMappingConfiguration
                ->forProperty('startDate')
                ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

            $propertyMappingConfiguration
                ->forProperty('endDate')
                ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                    \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

            $propertyMappingConfiguration->allowCreationForSubProperty('targetGroups.*');

            $propertyMappingConfiguration
                ->allowProperties('targetGroups')
                ->forProperty('targetGroups')
                ->allowAllProperties()
                ->forProperty('*')
                ->allowAllProperties();
        }
    }

    protected function initializeNewOfferSaveAction()
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('offer')->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED,
            true);

        $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('dates.*');

        $propertyMappingConfiguration
            ->allowProperties('dates')
            ->forProperty('dates')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties()
            ->forProperty('*')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->forProperty('startDate')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->forProperty('endDate')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->allowCreationForSubProperty('targetGroups.*');
        $propertyMappingConfiguration
            ->allowProperties('targetGroups')
            ->forProperty('targetGroups')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties();
    }

    protected function initializeOfferPreviewAction()
    {
        $propertyMappingConfiguration = $this->arguments->getArgument('offer')->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED,
            true);
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter',
            \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);

        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->allowCreationForSubProperty('categories.*');
        $propertyMappingConfiguration->allowCreationForSubProperty('dates.*');

        $propertyMappingConfiguration
            ->allowProperties('dates')
            ->forProperty('dates')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties()
            ->forProperty('*')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->forProperty('startDate')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->forProperty('endDate')
            ->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter',
                \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');

        $propertyMappingConfiguration->allowCreationForSubProperty('targetGroups.*');
        $propertyMappingConfiguration
            ->allowProperties('targetGroups')
            ->forProperty('targetGroups')
            ->allowAllProperties()
            ->forProperty('*')
            ->allowAllProperties();
    }

    /**
     * @ignorevalidation $provider
     * @param Provider $provider
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function companyProfileSaveAction(Provider $provider)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $group = UserUtility::getOrganisationGroup(UserUtility::getCurrentUser());

        if ($provider->getOwnerGroup()->getUid() !== $group->getUid()) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Page not found.');
        }

        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if ($provider->isPreview()) {
            /**
             * We do not use redirect because of the base64 images the uri gets to long.
             * We also do not use forward because we need another page template not the my account page template from the current page.
             * Solution: We store the provider in the session, redirect to a action and forward the action to another action to get the provider object
             */
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'provider', $this->request->getArguments());
            $GLOBALS['TSFE']->fe_user->storeSessionData();
            $this->redirect('providerPreviewRedirect', null, null, null,
                $this->settings['chancenportal']['pageIds']['provider_preview']);
        } else {

            $provider->setReminderEmailSend(false);

            if ($provider->getActive() === false && $provider->getApproved() === false) {
                $provider->setActive(true);

                if ($isAdmin === false) {
                    $currentUser = UserUtility::getCurrentUser();

                    if (!$provider->getAuthor()) {
                        $provider->setAuthor($currentUser);
                    }

                    foreach (UserUtility::getAdmins() as $admin) {
                        MailUtility::sendTemplateEmail([$admin->getUsername()],
                            [$this->settings['chancenportal']['email']['sender']], [],
                            $this->settings['chancenportal']['email']['request_approval_admin_subject'], 'RequestApprovalAdmin.html',
                            ['provider' => $provider, 'user' => $admin, 'settings' => $this->settings]);
                    }

                    MailUtility::sendTemplateEmail([$currentUser->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['request_approval_subject'], 'RequestApproval.html',
                        ['provider' => $provider, 'user' => $currentUser, 'settings' => $this->settings]);
                }
            }

            if ($provider->getUid()) {
                $this->providerRepository->update($provider);
            } else {
                $this->providerRepository->add($provider);
            }

            $persistenceManager->persistAll();

            $this->redirect('companyProfilePage', null, null, ['provider' => $provider, 'saved' => true]);
        }
    }


    /**
     * @ignorevalidation $provider
     * @param Provider $provider
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function adminCompanyProfileSaveAction(Provider $provider)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        if ($provider->isPreview()) {
            /**
             * We do not use redirect because of the base64 images the uri gets to long.
             * We also do not use forward because we need another page template not the my account page template from the current page.
             * Solution: We store the provider in the session, redirect to a action and forward the action to another action to get the provider object
             */
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'provider', $this->request->getArguments());
            $GLOBALS['TSFE']->fe_user->storeSessionData();

            $this->redirect('providerPreviewRedirect', null, null, null,
                $this->settings['chancenportal']['pageIds']['provider_preview']);
        } else {

            $currentUser = UserUtility::getCurrentUser();
            $isAdmin = UserUtility::isAdmin($currentUser);

            if ($isAdmin && $provider->getApproved() === true && $provider->approvedChanged && $provider->getAuthor()) {
                MailUtility::sendTemplateEmail([$provider->getAuthor()->getUsername()],
                    [$this->settings['chancenportal']['email']['sender']], [],
                    $this->settings['chancenportal']['email']['provider_approved_subject'], 'Approved.html',
                    ['provider' => $provider, 'user' => $provider->getAuthor(), 'settings' => $this->settings]);
            }

            if ($provider->getUid()) {
                $this->providerRepository->update($provider);
            } else {
                $newGroup = new FrontendUserGroup();
                $newGroup->setTitle($provider->getName());
                $newGroup->setHidden(false);
                $this->frontendUserGroupRepository->add($newGroup);
                $provider->setCreator(UserUtility::getCurrentUser());
                $provider->setOwnerGroup($newGroup);
                $this->providerRepository->add($provider);
            }

            $persistenceManager->persistAll();
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'saved', true);

            $this->redirect('adminCompanyProfilePage', null, null, ['provider' => $provider], $this->settings['chancenportal']['pageIds']['provider_edit']);
        }
    }

    /**
     * @ignorevalidation $provider
     * @param Provider|null $provider
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function adminCompanyProfilePageAction(Provider $provider = null)
    {
        if ($provider === null) {
            $provider = new Provider();
        }

        $saved = $GLOBALS['TSFE']->fe_user->getKey('ses', 'saved');
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'saved', false);

        $this->view->assign('users', $this->selectUtility->getProviderUsersForSelect($provider));
        $this->view->assign('categories', $this->selectUtility->getCategoriesForSelect($provider, false));
        $this->view->assign('salutations', $this->selectUtility->getSalutationsJson($provider));
        $this->view->assign('contentImage', $this->getUploadedImageJson($provider->getContentImage()));
        $this->view->assign('logo', $this->getUploadedImageJson($provider->getLogo()));
        $this->view->assign('contactImage', $this->getUploadedImageJson($provider->getContactImage()));
        $this->view->assign('carrier', $this->carrierRepository->findAll());
        $this->view->assign('carrierItems', $this->selectUtility->getCarrierForSelect($provider));
        $this->view->assign('saved', $saved);
        $this->view->assign('provider', $provider);
    }

    /**
     * @ignorevalidation $provider
     * @param Provider $provider
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteProviderAction(Provider $provider)
    {
        $users = UserUtility::getUsersByProvider($provider);
        foreach ($users as $user) {
            $this->frontendUserRepository->remove($user);
        }
        $this->providerRepository->remove($provider);
        $this->redirect('providerPage', null, null, null, $this->settings['chancenportal']['pageIds']['provider_list']);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function providerPreviewRedirectAction()
    {
        $this->forward('providerPreview', null, null, $GLOBALS['TSFE']->fe_user->getKey('ses', 'provider'));
    }

    /**
     * @ignorevalidation $provider
     * @param Provider|null $provider
     */
    public function providerPreviewAction(Provider $provider)
    {
        $this->view->assign('provider', $provider);
    }

    /**
     * @ignorevalidation $provider
     * @param Provider|null $provider
     * @param bool $saved
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function companyProfilePageAction(Provider $provider = null, $saved = false)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $group = UserUtility::getOrganisationGroup(UserUtility::getCurrentUser());

        if (!$group) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Permission denied! User is not in a group.');
        } else {
            if ($provider === null) {
                $provider = $this->providerRepository->findOneByOwnerGroup($group);

                if ($provider === null) {
                    $provider = new Provider();
                    $provider->setOwnerGroup($group);
                    $this->providerRepository->add($provider);
                    $persistenceManager->persistAll();
                }
            }
        }

        if ($group && $provider->getOwnerGroup() && $provider->getOwnerGroup()->getUid() !== $group->getUid()) {
            $GLOBALS['TSFE']->pageNotFoundAndExit('Page not found.');
        }

        $this->view->assign('categories', $this->selectUtility->getCategoriesForSelect($provider, false));
        $this->view->assign('salutations', $this->selectUtility->getSalutationsJson($provider));
        $this->view->assign('contentImage', $this->getUploadedImageJson($provider->getContentImage()));
        $this->view->assign('logo', $this->getUploadedImageJson($provider->getLogo()));
        $this->view->assign('contactImage', $this->getUploadedImageJson($provider->getContactImage()));
        $this->view->assign('carrier', $this->carrierRepository->findAll());
        $this->view->assign('carrierItems', $this->selectUtility->getCarrierForSelect($provider));
        $this->view->assign('saved', $saved);
        $this->view->assign('provider', $provider);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function evaluationsAction()
    {
        $data = GeneralUtility::_GP('dates');
        $category = GeneralUtility::_GP('category');
        $categories = [];
        $offers = [];
        $terms = [];

        if ($data) {
            $query = $this->logRepository->createQuery();
            $constraints = [];

            if (isset($data[0]) && !empty($data[0])) {
                $startDate = \DateTime::createFromFormat('d.m.Y', $data[0]);
                if ($startDate) {
                    $constraints[] = $query->greaterThanOrEqual('date',
                        $startDate->modify('midnight')->format('Y-m-d'));
                }
            }
            if (isset($data[1]) && !empty($data[1])) {
                $endDate = \DateTime::createFromFormat('d.m.Y', $data[1]);
                if ($endDate) {
                    $constraints[] = $query->lessThanOrEqual('date',
                        $endDate->modify('midnight +1 day -1 second')->format('Y-m-d'));
                }
            }

            if (count($constraints)) {
                $query->matching($query->logicalAnd($constraints));
            }

            $logs = $query->execute();
            $offerResults = $this->offerRepository->findByDatesAndCategory($data[0], $data[1], $category);

        } else {
            $logs = $this->logRepository->findAll();
            $offerResults = $this->offerRepository->findAll();
        }

        foreach ($logs as $log) {
            $cat = $log->getCategory();
            $offer = $log->getOffer();
            $term = $log->getTerm();

            if ($cat) {
                if (!isset($categories[$cat->getUid()])) {
                    $categories[$cat->getUid()] = [
                        'name' => $cat->getName(),
                        'count' => 0
                    ];
                }
                $categories[$cat->getUid()]['count']++;
            }
            if ($offer) {
                if (!isset($offers[$offer->getUid()])) {
                    $offers[$offer->getUid()] = [
                        'name' => $offer->getName(),
                        'count' => 0
                    ];
                }
                $offers[$offer->getUid()]['count']++;
            }
            if (!empty($term)) {
                if (!isset($terms[$term])) {
                    $terms[$term] = [
                        'name' => $term,
                        'count' => 0
                    ];
                }
                $terms[$term]['count']++;
            }
        }

        $this->view->assign('categoriesDropdown', $this->selectUtility->getCategoriesForSelect(null, true, true, false, $category));
        $this->view->assign('categoriesForChart', $this->selectUtility->getCategoriesForSelect(null, false, true, false, $category));

        $this->view->assign('plz', $this->selectUtility->getPlzForSelect());
        $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect(null, true));
        $this->view->assign('categoryCount', count(array_values($categories)));
        $this->view->assign('categories', json_encode(array_values($categories)));
        $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect(null, false));
        $this->view->assign('offerCount', count(array_values($offers)));
        $this->view->assign('offers', json_encode(array_values($offers)));
        $this->view->assign('category', $category);
        $this->view->assign('terms', $terms);
        $this->view->assign('offerResults', $offerResults);
        $this->view->assign('startDate', $startDate ? $startDate->format('Y-m-d') : null);
        $this->view->assign('endDate', $endDate ? $endDate->format('Y-m-d') : null);
    }

    /**
     *
     */
    public function evaluationChartPlzAction()
    {
        $this->view->assign('offersByPlz', json_encode($this->getOffersByPlz()));
    }

    /**
     *
     */
    public function evaluationChartDistrictAction()
    {
        $this->view->assign('offersByDistrict', json_encode($this->getOffersByDistrict()));
    }

    /**
     *
     */
    public function evaluationChartTimeAction()
    {
        $now = new \DateTime();
        $this->view->assign('currentKw', 'KW ' . $now->format('W') . ' / ' . $now->format('Y'));
        $this->view->assign('offersByTime', json_encode($this->getOffersByTime()));
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    private function getKwFromDateRange(\DateTime $startDate, \DateTime $endDate)
    {
        $clone = clone $startDate;
        $kws = [];
        while ($endDate >= $clone) {
            $clone->modify('+1 day');
            $kw = $clone->format('W') . ' / ' . $clone->format('Y');
            if (!isset($kws[$kw])) {
                $kws[$kw] = $kw;
            }
        };
        return array_values($kws);
    }

    /**
     *
     */
    public function getOffersByTime()
    {
        $now = new \DateTime();
        $offers = $this->getOffersForChart();
        $data = [];
        foreach ($offers as $offer) {
            if ($offer->getDateType() > 0) {

                $offerKw = [];

                foreach ($offer->getDates() as $date) {
                    if (!$date->getStartDate()) {
                        continue;
                    }

                    $kw = $date->getStartDate()->format('W') . ' / ' . $date->getStartDate()->format('Y');

                    if ($offer->getDateType() === 1 || $offer->getDateType() === 2) {
                        if (!isset($offerKw[$kw])) {
                            $offerKw[$kw] = true;
                        }

                    } else {
                        if ($offer->getDateType() === 3 && $date->getStartDate() && $date->getEndDate()) {
                            $kws = $this->getKwFromDateRange($date->getStartDate(), $date->getEndDate());
                            foreach ($kws as $k) {
                                if (!isset($offerKw[$k])) {
                                    $offerKw[$k] = true;
                                }
                            }

                        } else {
                            if ($offer->getDateType() === 4 && $date->getActive() && $date->getEndDate()) {

                                $kws = $this->getKwFromDateRange($date->getStartDate(), $date->getEndDate());
                                foreach ($kws as $k) {
                                    if (!isset($offerKw[$k])) {
                                        $offerKw[$k] = true;
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($offerKw as $kw => $val) {
                    if (!isset($data[$kw])) {
                        $data[$kw] = 0;
                    }
                    $data[$kw]++;
                }
            }
        }

        $dataKeys = array_keys($data);
        $max = 0;
        foreach ($dataKeys as $dataKey) {
            $val = explode(' / ', $dataKey);
            $time = strtotime($val[1] . '-W' . $val[0] . '-1 UTC');
            if ($time > $max) {
                $max = $time;
            }
        }

        foreach ($offers as $offer) {
            if ($offer->getDateType() === 4) {
                $offerKw = [];
                foreach ($offer->getDates() as $date) {
                    if (!$date->getStartDate()) {
                        continue;
                    }
                    if ($date->getActive() && !$date->getEndDate()) {

                        if ($max > 0) {
                            $endDate = \DateTime::createFromFormat('U', $max);
                        } else {
                            $endDate = new \DateTime('midnight');
                        }

                        $kws = $this->getKwFromDateRange($date->getStartDate(), $endDate);

                        foreach ($kws as $k) {
                            if (!isset($offerKw[$k])) {
                                $offerKw[$k] = true;
                            }
                        }
                    }
                }

                foreach ($offerKw as $kw => $notUsed) {
                    if (!isset($data[$kw])) {
                        $data[$kw] = 0;
                    }
                    $data[$kw]++;
                }
            }
        }

        // Sort kw array
        uksort($data, function ($a, $b) {
            $aa = explode(' / ', $a);
            $bb = explode(' / ', $b);
            return intval($aa[1] . $aa[0]) > intval($bb[1] . $bb[0]) ? 1 : -1;
        });

        $dataChart = [];
        foreach ($data as $name => $val) {
            $dataChart[] = ["$name", $val, ($name === $now->format('W') . ' / ' . $now->format('Y') ? 'stroke-color: #f9b000; fill-color: #f9b000' : ''), $val];
        }

        return $dataChart;
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function getOffersForChart()
    {
        $params = [];
        $allowedCategories = !empty($_REQUEST['categories']) && is_array($_REQUEST['categories']) ? $_REQUEST['categories'] : [];
        $allowedTargetGroups = !empty($_REQUEST['targetGroups']) ? $_REQUEST['targetGroups'] : [];
        $districts = !empty($_REQUEST['districts']) ? $_REQUEST['districts'] : [];
        $zips = !empty($_REQUEST['zip']) ? $_REQUEST['zip'] : [];
        $accessibility = $_REQUEST['accessibility'] ?? null;
        $noCosts = $_REQUEST['noCosts'] ?? null;

        $query = $this->offerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        if (count($allowedTargetGroups)) {
            $params[] = $query->in('targetGroups.uid', $allowedTargetGroups);
        }

        if ($accessibility && $accessibility !== '1') {
            $params[] = $query->equals('accessibility', $accessibility);
        }

        if ($noCosts && $noCosts === '1') {
            $params[] = $query->equals('noCosts', 1);
        }

        if (count($zips)) {
            $params[] = $query->in('zip', $zips);
        }

        if (count($allowedCategories)) {
            $params[] = $query->in('categories.uid', $allowedCategories);
        }

        if (count($districts)) {
            $params[] = $query->in('district.uid', $districts);
        }

        if (count($params)) {
            $query = $query->matching($query->logicalAnd($params));
        }

        return $query->execute();
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getOffersByDistrict()
    {
        $offers = $this->getOffersForChart();

        foreach ($offers as $offer) {
            if ($offer->getDistrict()) {
                $name = $offer->getDistrict()->getName();
                if (!isset($data[$name])) {
                    $data[$name] = 0;
                }
                $data[$name]++;
            }
        }

        ksort($data);

        $dataChart = [];
        foreach ($data as $name => $val) {
            $dataChart[] = ["$name", $val, $val];
        }

        return $dataChart;
    }

    /**
     * @return array
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function getOffersByPlz()
    {
        $offers = $this->getOffersForChart();

        foreach ($offers as $offer) {
            if ($offer->getZip()) {
                if (!isset($data[$offer->getZip()])) {
                    $data[$offer->getZip()] = 0;
                }
                $data[$offer->getZip()]++;
            }
        }

        ksort($data);

        $dataChart = [];
        foreach ($data as $plz => $val) {
            $dataChart[] = ["$plz", $val, $val];
        }

        return $dataChart;
    }

    /**
     * @param mixed|null $image
     * @return string
     */
    private function getUploadedImageJson($image = null)
    {
        $images = [];
        if (get_class($image) === FileReference::class) {
            $images[] = [
                'uploaded' => true,
                'dataUrl' => $image->getUid(),
                'size' => null,
                'name' => $image->getOriginalResource()->getOriginalFile()->getName(),
                'id' => $image->getUid(),
            ];
        } elseif (get_class($image) === ObjectStorage::class) {
            foreach ($image as $img) {
                $images[] = [
                    'uploaded' => true,
                    'dataUrl' => $img->getUid(),
                    'size' => null,
                    'name' => $img->getOriginalResource()->getOriginalFile()->getName(),
                    'id' => $img->getUid(),
                ];
            }
        }
        return json_encode($images);
    }

    /**
     * @param $file
     * @return int
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function handleImport($file)
    {
        setlocale(LC_ALL, 'de_DE');
        $offers = [];
        $count = 0;

        shell_exec($this->settings['chancenportal']['xls_converter'] . ' ' . $file['tmp_name'] . ' ' . $file['tmp_name'] . ".csv 2>&1");

        if (($handle = fopen($file['tmp_name'] . '.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 99999, ",")) !== false) {

                $count++;
                if ($count < 3) {
                    continue;
                }

                if (!empty($data[0])) {
                    if (!isset($offers[$data[0]])) {
                        $offers[$data[0]] = [
                            'name' => $data[1],
                            'mainCategory' => $data[2],
                            'dates' => [],
                            'dateType' => $this->mapDateNameToType($data[3]),
                            'address' => $data[8],
                            'info' => $data[9],
                            'district' => $data[10],
                            'targetGroups' => explode(',', $data[11]),
                            'shortDescription' => $data[12],
                            'longDescription' => $data[13],
                            'speaker' => $data[14],
                            'format' => $data[15],
                            'youtube' => $data[16],
                            'conditionsOfParticipation' => $data[17],
                            'courseNumber' => $data[18],
                            'allowedParticipants' => $data[19],
                            'costs' => $data[20],
                            'noCosts' => trim(strtolower($data[21])) === 'ja' ? true : false,
                            'access' => trim(strtolower($data[22])) === 'offen' ? 2 : (trim(strtolower($data[22])) === 'mitgliedschaft erforderlich' ? 3 : 1),
                            'accessibility' => trim(strtolower($data[23])) === 'ja' ? 2 : (trim(strtolower($data[23])) === 'nein' ? 3 : 1),
                            'providerCooperation' => $data[24],
                            'contactSalutation' => trim(strtolower($data[25])) === 'herr' ? '1' : '0',
                            'contactName' => $data[26],
                            'contactJurisdiction' => $data[27],
                            'contactPhone' => $data[28],
                            'contactEmail' => $data[29]
                        ];
                    }

                    if ($offers[$data[0]]['dateType'] > 0) {

                        if ($offers[$data[0]]['dateType'] === 4) {

                            if (count($offers[$data[0]]['dates']) === 0) {
                                for ($i = 0; $i <= 6; $i++) {
                                    $offers[$data[0]]['dates'][$i] = [
                                        'active' => false,
                                        'startDate' => null,
                                        'endDate' => null,
                                        'startTime' => null,
                                        'endTime' => null
                                    ];
                                }
                            }

                            if (isset($data[4]) && !empty($data[4])) {

                                $day = intval(\DateTime::createFromFormat($this->settings['chancenportal']['xls_converter_date_format'], $data[4])->format('N'));

                                $offers[$data[0]]['dates'][$day - 1] = [
                                    'active' => true,
                                    'startDate' => $data[4],
                                    'endDate' => $data[6],
                                    'startTime' => $data[5],
                                    'endTime' => $data[7]
                                ];
                            }

                        } else {
                            $offers[$data[0]]['dates'][] = [
                                'startDate' => $data[4],
                                'startTime' => $data[5],
                                'endDate' => $data[6],
                                'endTime' => $data[7]
                            ];
                        }
                    }
                }
            }
            fclose($handle);
            unlink($file['tmp_name'] . '.csv');
        }

        foreach ($offers as $key => $offer) {
            if ($offer['dateType'] === 4) {
                $lastDate = null;
                $endDate = null;

                foreach ($offer['dates'] as $date) {
                    if ($date['startDate']) {

                        $dateObj = \DateTime::createFromFormat($this->settings['chancenportal']['xls_converter_date_format'], $date['startDate']);

                        if ($lastDate === null || ($dateObj && $dateObj < $lastDate)) {
                            $lastDate = $dateObj;

                            $endDate = \DateTime::createFromFormat($this->settings['chancenportal']['xls_converter_date_format'], $date['endDate']);
                        }
                    }
                }

                $offer['startDate'] = $lastDate;
                if ($endDate) {
                    $offer['endDate'] = $endDate;
                }
                $offers[$key] = $offer;
            }
        }

        $currentUser = UserUtility::getCurrentUser();
        $group = UserUtility::getOrganisationGroup($currentUser);
        $provider = $this->providerRepository->findOneByOwnerGroup($group);

        foreach ($offers as $data) {

            try {
                $offer = new Offer();

                $offer->setName($data['name']);

                $offer->setProvider($provider);
                $offer->setDateType($data['dateType']);

                if ($data['dateType'] > 0) {

                    if ($data['dateType'] === 4) {

                        $offer->setStartDate($data['startDate']);

                        $offer->setEndDate($data['endDate']);

                        $dates = new ObjectStorage();

                        foreach ($data['dates'] as $dateData) {
                            $date = new Date();

                            $startTime = !empty($dateData['startTime']) ? $dateData['startTime'] : null;
                            $endTime = !empty($dateData['endTime']) ? $dateData['endTime'] : null;

                            if ($startTime) {
                                $date->setStartTime(substr($startTime, 0, 5));
                            }

                            if ($endTime) {
                                $date->setEndTime(substr($endTime, 0, 5));
                            }

                            $date->setActive($dateData['active']);
                            $dates->attach($date);
                        }

                        $offer->setDates($dates);

                    } else {
                        foreach ($data['dates'] as $dateData) {
                            $date = new Date();
                            $endDate = empty($dateData['endDate']) ? $dateData['startDate'] : $dateData['endDate'];
                            $endTime = empty($dateData['endTime']) ? $dateData['startTime'] : $dateData['endTime'];

                            $date->setStartDate(\DateTime::createFromFormat($this->settings['chancenportal']['xls_converter_date_format'], $dateData['startDate'], new \DateTimeZone('UTC')));
                            $date->setEndDate(\DateTime::createFromFormat($this->settings['chancenportal']['xls_converter_date_format'], $endDate, new \DateTimeZone('UTC')));

                            $date->setStartTime(substr($dateData['startTime'], 0, 5));
                            $date->setEndTime(substr($endTime, 0, 5));
                            $offer->addDate($date);
                        }
                    }
                }

                $latLng = $this->getLatLng($data['address']);
                if ($latLng) {
                    $offer->setLat($latLng[0]);
                    $offer->setLng($latLng[1]);
                    $offer->setAddress($data['address']);
                }

                $cat = $this->categoryRepository->findOneByName($data['mainCategory']);
                if ($cat) {
                    $offer->addCategory($cat);

                    foreach ($data['subCategory'] as $subCat) {
                        $cat = $this->categoryRepository->findOneByName(trim($subCat));
                        if ($cat) {
                            $offer->addCategory($cat);
                        }
                    }
                }

                $offer->setInfo($data['info']);

                $district = $this->districtRepository->findOneByName($data['district']);
                if ($district) {
                    $offer->setDistrict($district);
                }

                foreach ($data['targetGroups'] as $group) {
                    $targetGroup = $this->targetGroupRepository->findOneByName(trim($group));
                    if ($targetGroup) {
                        $offer->addTargetGroup($targetGroup);
                    }
                }

                $offer->setCreator($currentUser);
                $offer->setLastEditor($currentUser);

                $offer->setShortDescription($data['shortDescription']);
                $offer->setLongDescription($data['longDescription']);
                $offer->setSpeaker($data['speaker']);
                $offer->setFormat($data['format']);
                $offer->setYoutube($data['youtube']);
                $offer->setConditionsOfParticipation($data['conditionsOfParticipation']);
                $offer->setCourseNumber($data['courseNumber']);
                $offer->setAllowedParticipants($data['allowedParticipants']);
                $offer->setCosts($data['costs']);
                $offer->setNoCosts($data['noCosts']);
                $offer->setAccess($data['access']);
                $offer->setAccessibility($data['accessibility']);
                $offer->setProviderCooperation($data['providerCooperation']);
                $offer->setContactName($data['contactName']);
                $offer->setContactJurisdiction($data['contactJurisdiction']);
                $offer->setContactPhone($data['contactPhone']);
                $offer->setContactEmail($data['contactEmail']);
                $offer->setActive(false);

                $this->offerRepository->add($offer);
            } catch (\Exception $e) {
                error_log('Import Error: ' . $e->getMessage());
            }
        }

        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $persistenceManager->persistAll();

        return count($offers);
    }

    /**
     * @param $type
     * @return mixed
     */
    private function mapDateTypeToName($type)
    {
        return utf8_decode($this->typeToNames[$type]);
    }

    /**
     * @param $name
     * @return int|null|string
     */
    private function mapDateNameToType($name)
    {
        $keys = array_flip($this->typeToNames);
        return $keys[$name];
    }

    /**
     * Export offers
     */
    public function exportOffersAction()
    {
        setlocale(LC_ALL, 'de_DE');
        $tmpfname = tempnam("/tmp", "export") . '.csv';
        $fp = fopen($tmpfname, 'w');

        $group = UserUtility::getOrganisationGroup(UserUtility::getCurrentUser());
        $provider = $this->providerRepository->findOneByOwnerGroup($group);
        $offers = $this->offerRepository->findByProvider($provider);

        fputcsv($fp, [
            "ID",
            "Name des Angebots*",
            "Angebotskategorie/n*",
            "Datumstyp",
            "Start-Datum*",
            "Uhrzeit",
            "End-Datum",
            "Uhrzeit",
            "Adresse (Wo findet das Angebot statt?)*",
            "Zusatzinformationen Angebotsort (z.B.Raum)",
            ($this->settings['chancenportal']['use_zip_filter'] === '1' ? "PLZ" : "Stadtteil*"),
            "Altersgruppe / Zielgruppe*",
            "Kurzbeschreibung / Teaser-Text (max. 200 Zeichen)*",
            "Langbeschreibung",
            "Referent/en, Berufsbezeichnung oder Qualifikation",
            "Format",
            "Video-URL (Youtube) einbinden",
            "Spezf. Teilnahmebedingungen (z.B. Anmeldung erforderlich max. 200 Zeichen)",
            "Kursnummer",
            "Max. Teilnehmeranzahl",
            "Kosten",
            "Kostenfrei",
            "Zugang (Offen / mit Mitgliedschaft)",
            "Barrierefrei",
            utf8_decode("Name mögl. Kooperationspartner"),
            "Anrede",
            "Vorname und Name",
            utf8_decode("Zuständigkeit"),
            "Telefon",
            "E-Mail",
            "URL Anbieter",
        ]);

        fputcsv($fp, [
            "Nummer fortlaufend",
            "Freitext",
            "Einfachauswahl",
            utf8_decode("Einfachauswahl (Ohne Termin, Konkrete Daten, Zeitraum, Täglich, Wöchentlich)"),
            "Datum",
            "Freitext (Uhrzeit)",
            "Datum",
            "Freitext (Uhrzeit)",
            "Freitext",
            "Freitext",
            "Freitext",
            "Mehrfachauswahl",
            "Freitext",
            "Freitext",
            "Freitext",
            "Freitext",
            "Freitext (URL)",
            "Freitext",
            "Freitext",
            "Freitext",
            "Freitext",
            "Einfachauswahl",
            "Einfachauswahl",
            "Einfachauswahl",
            "Freitext",
            "Freitext",
            "Freitext",
            "Freitext",
            "Freitext (Telefonnummer)",
            "Freitext (E-Mail)",
            "Freitext",
        ]);

        /**
         * @var Offer $offer
         */
        foreach ($offers as $offer) {

            $mainCat = $offer->getMainCategory();

            $categories = [];

            foreach ($offer->getCategories() as $cat) {
                if ($cat->getUid() !== $mainCat->getUid()) {
                    $categories[] = $cat->getName();
                }
            }

            $targetGroups = [];

            foreach ($offer->getTargetGroups() as $tg) {
                $targetGroups[] = $tg->getName();
            }

            $access = 'Keine Angabe';

            if ($offer->getAccess() === 2) {
                $access = 'Offen (ohne Mitgliedschaft)';
            } elseif ($offer->getAccess() === 3) {
                $access = 'Mitgliedschaft erforderlich';
            }

            $accessibility = 'Keine Angabe';

            if ($offer->getAccessibility() === 2) {
                $accessibility = 'Ja';
            } elseif ($offer->getAccessibility() === 3) {
                $accessibility = 'Nein';
            }

            $firstDate = null;

            if ($offer->getDates()->count()) {
                $firstDate = $offer->getDates()->current();
            }

            $row = [
                $offer->getUid(),
                utf8_decode($offer->getName()),
                $mainCat ? utf8_decode($mainCat->getName()) : '',
                $this->mapDateTypeToName($offer->getDateType()),
                $firstDate && $firstDate->getStartDate() ? $firstDate->getStartDate()->format($this->settings['chancenportal']['xls_converter_date_format']) : '',
                $firstDate && $firstDate->getStartDate() ? $firstDate->getStartTime() : '',
                $firstDate && $firstDate->getEndDate() ? $firstDate->getEndDate()->format($this->settings['chancenportal']['xls_converter_date_format']) : '',
                $firstDate ? $firstDate->getEndTime() : '',
                utf8_decode($offer->getAddress()),
                utf8_decode($offer->getInfo()),
                ($this->settings['chancenportal']['use_zip_filter'] === '1' ? $offer->getZip() : ($offer->getDistrict() ? utf8_decode($offer->getDistrict()->getName()) : '')),
                utf8_decode(implode(', ', $targetGroups)),
                utf8_decode($offer->getShortDescription()),
                utf8_decode(strip_tags($offer->getLongDescription())),
                utf8_decode($offer->getSpeaker()),
                utf8_decode($offer->getFormat()),
                $offer->getYoutube(),
                utf8_decode($offer->getConditionsOfParticipation()),
                $offer->getCourseNumber(),
                utf8_decode($offer->getAllowedParticipants()),
                utf8_decode($offer->getCosts()),
                $offer->getNoCosts() ? 'Ja' : 'Nein',
                $access,
                $accessibility,
                utf8_decode($offer->getProviderCooperation()),
                $offer->getContactSalutation() === 0 ? 'Frau' : 'Herr',
                utf8_decode($offer->getContactName()),
                utf8_decode($offer->getContactJurisdiction()),
                $offer->getContactPhone(),
                utf8_decode($offer->getContactEmail()),
                '',
            ];

            fputcsv($fp, $row);

            if ($offer->getDates()->count()) {

                foreach ($offer->getDates()->toArray() as $key => $date) {

                    if ((($offer->getDateType() === 4 && $date->getActive()) || $offer->getDateType() !== 4) && $date->getUid() !== $firstDate->getUid()) {

                        $row = [
                            $offer->getUid(),
                            '',
                            '',
                            '',
                            $date->getStartDate() ? $date->getStartDate()->format($this->settings['chancenportal']['xls_converter_date_format']) : '',
                            $date->getStartTime(),
                            $date->getEndDate() ? $date->getEndDate()->format($this->settings['chancenportal']['xls_converter_date_format']) : '',
                            $date->getEndTime(),
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                            '',
                        ];
                        fputcsv($fp, $row);
                    }
                }
            }
        }

        fclose($fp);

        $result = shell_exec($this->settings['chancenportal']['xls_converter'] . ' ' . $tmpfname . ' ' . $tmpfname . ".xls 2>&1");

        $headers = array(
            'Content-Type' => 'application/xls; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . date('d.m.Y') . '_Angebote.xls"',
            'Pragma' => 'no-cache',
        );

        foreach ($headers as $header => $data) {
            $this->response->setHeader($header, $data);
        }

        $this->response->sendHeaders();

        echo file_get_contents($tmpfname . '.xls');

        unlink($tmpfname);
        unlink($tmpfname . '.xls');
        die;
    }

    /**
     * @param $address
     * @return array|null
     */
    private function getLatLng($address)
    {
        $result = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $this->settings['chancenportal']['google_maps_api_key']));
        if (isset($result->results[0])) {
            return [$result->results[0]->geometry->location->lat, $result->results[0]->geometry->location->lng];
        }
        return null;
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function offerPageAction()
    {
        $file = $_FILES['import_file'];
        $imported = $GLOBALS['TSFE']->fe_user->getKey('ses', 'imported');

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'imported', null);
        $GLOBALS['TSFE']->fe_user->storeSessionData();

        if ($file) {
            $imported = $this->handleImport($file);
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'imported', $imported);
            $GLOBALS['TSFE']->fe_user->storeSessionData();
            $this->redirect('offerPage');
        }

        $user = UserUtility::getCurrentUser();
        $group = UserUtility::getOrganisationGroup($user);
        $provider = $this->providerRepository->findOneByOwnerGroup($group);

        $this->view->assign('offers', $this->offerRepository->findByProvider($provider));
        $this->view->assign('imported', $imported);
        $this->view->assign('user', $user);
    }

    /**
     * Anbieterseite
     */
    public function providerPageAction()
    {
        $query = $this->providerRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->setOrderings([
            'approved' => QueryInterface::ORDER_ASCENDING,
            'active' => QueryInterface::ORDER_ASCENDING,
        ]);

        $this->view->assign('providers', $query->execute());
    }

    /**
     * @ignorevalidation $offer
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     */
    public function offerPreviewAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);
        if ($isAdmin === true) {
            $creator = $offer->getCreator();
            $userProvider = UserUtility::getUserProvider($creator, $this->providerRepository->findAll());
            $offer->setProvider($userProvider);
        }

        $this->view->assign('offer', $offer);
    }

    /**
     * @ignorevalidation $offer
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteOfferAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if ($isAdmin && $offer->getCreator()) {
            MailUtility::sendTemplateEmail([$offer->getCreator()->getEmail()],
                [$this->settings['chancenportal']['email']['sender']], [],
                $this->settings['chancenportal']['email']['delete_offer_subject'], 'DeleteOffer.html',
                ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
        }

        $this->offerRepository->remove($offer);
        $this->redirect('offerPage', null, null, null, $this->settings['chancenportal']['pageIds']['offer_overview']);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function offerPreviewRedirectAction()
    {
        $sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'offer');
        unset($sessionData['action']);
        unset($sessionData['controller']);

        $this->forward('offerPreview', null, null, $sessionData);
    }

    /**
     * @ignorevalidation $offer
     * @param Offer|null $offer
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function newOfferSaveAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer = null)
    {
        if ($offer === null) {
            return $this->forward('newOfferPage');
        }

        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $currentUser = UserUtility::getCurrentUser();
        $group = UserUtility::getOrganisationGroup($currentUser);
        $isAdmin = UserUtility::isAdmin($currentUser);
        $data = GeneralUtility::_GP('tx_chancenportal_chancenportal');
        $provider = null;

        if ($isAdmin === false) {
            $provider = $this->providerRepository->findOneByOwnerGroup($group);
        }

        if ($isAdmin || $provider) {

            if (!$offer->getCreator()) {
                $offer->setCreator($currentUser);
            }

            $offer->setLastEditor($currentUser);

            if (!isset($data['offer']['targetGroups'])) {
                $offer->setTargetGroups(new ObjectStorage());
            }

            if (!isset($data['offer']['categories'])) {
                $offer->setCategories(new ObjectStorage());
            }

            if ($isAdmin === false) {
                $offer->setProvider($provider);
            } else {
                $creator = $offer->getCreator();
                $userProvider = UserUtility::getUserProvider($creator, $this->providerRepository->findAll());
                $offer->setProvider($userProvider);
            }

            if ($offer->isPreview()) {
                /**
                 * We do not use redirect because of the base64 images the uri gets to long.
                 * We also do not use forward because we need another page template not the my account page template from the current page.
                 * Solution: We store the provider in the session, redirect to a action and forward the action to another action to get the provider object
                 */
                $GLOBALS['TSFE']->fe_user->setKey('ses', 'offer', $this->request->getArguments());
                $GLOBALS['TSFE']->fe_user->storeSessionData();
                $this->redirect('offerPreviewRedirect', null, null, null,
                    $this->settings['chancenportal']['pageIds']['offer_preview']);
            } else {

                if ($isAdmin === false) {

                    if ($this->settings['chancenportal']['activate_offer_approval'] === '1' && $offer->getActive() === false && $offer->getApproved() === false) {
                        $offer->setActive(true);

                        foreach (UserUtility::getAdmins() as $admin) {
                            MailUtility::sendTemplateEmail([$admin->getUsername()],
                                [$this->settings['chancenportal']['email']['sender']], [],
                                $this->settings['chancenportal']['email']['request_offer_approval_admin_subject'], 'RequestOfferApprovalAdmin.html',
                                ['offer' => $offer, 'user' => $admin, 'settings' => $this->settings]);
                        }

                        MailUtility::sendTemplateEmail([$currentUser->getUsername()],
                            [$this->settings['chancenportal']['email']['sender']], [],
                            $this->settings['chancenportal']['email']['request_offer_approval_subject'], 'RequestOfferApproval.html',
                            ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);

                    } elseif ($this->settings['chancenportal']['activate_offer_approval'] === '0' && $offer->getActive() === true && $offer->isActiveBeforeUpdate() === false) {
                        foreach (UserUtility::getAdmins() as $admin) {
                            MailUtility::sendTemplateEmail([$admin->getUsername()], [$this->settings['chancenportal']['email']['sender']],
                                [], $this->settings['chancenportal']['email']['new_active_offer_subject'], 'NewActiveOffer.html', ['settings' => $this->settings, 'user' => $admin]);
                        }
                    }

                } elseif ($this->settings['chancenportal']['activate_offer_approval'] === '1' && $offer->getCreator() && $offer->getApproved() && $offer->approvedChanged) {

                    MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['request_offer_approval_subject'], 'ApprovedOffer.html',
                        ['offer' => $offer, 'user' => $offer->getCreator(), 'settings' => $this->settings]);
                }

                if ($offer->creatorChanged === false && $data['offer']['active'] === '1') {
                    $offer->setActive(true);
                } else {
                    if ($isAdmin && $offer->getCreator() && $offer->activeChanged) {
                        MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                            [$this->settings['chancenportal']['email']['sender']], [],
                            $this->settings['chancenportal']['email']['delete_offer_subject'], 'DeactivateOffer.html',
                            ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
                        $offer->setActive(false);
                    } elseif ($isAdmin === false && $offer->creatorChanged) {
                        MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                            [$this->settings['chancenportal']['email']['sender']], [],
                            $this->settings['chancenportal']['email']['creator_changed_subject'], 'CreatorChange.html',
                            ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
                        $offer->setActive(false);
                    }
                }

                $offer->setReminderEmailSend(false);

                if ($offer->getUid()) {
                    $this->offerRepository->update($offer);
                } else {
                    $this->offerRepository->add($offer);
                }

                $persistenceManager->persistAll();

                $this->redirect('newOfferPage', null, null, ['offer' => $offer, 'saved' => true],
                    $this->settings['chancenportal']['pageIds']['offer_edit']);
            }
        } else {
            throw new \Exception('Current user has no provider assignment! Please assign a provider to the current user.');
        }
    }

    /**
     * @param null $activeUser
     * @param null $userProvider
     * @return string
     */
    private function getProviderUserForSelect($activeUser = null, $currentUserProvider = null)
    {
        $organisations = [];
        $providers = $this->providerRepository->findAll();

        foreach ($providers as $provider) {
            if ($currentUserProvider && $currentUserProvider->getUid() !== $provider->getUid()) {
                continue;
            }

            $organisation = [
                'id' => $provider->getUid(),
                'title' => empty($provider->getName()) ? $provider->getOwnerGroup()->getTitle() : $provider->getName(),
                'items' => []
            ];

            $users = UserUtility::getUsersByProvider($provider);

            foreach ($users as $user) {
                $organisation['items'][] = [
                    'id' => $user->getUid(),
                    'title' => (empty($user->getName()) ? $user->getOwnerGroup()->getTitle() : $user->getName()),
                    'active' => $activeUser && $activeUser->getUid() === $user->getUid() ? true : false,
                ];
            }

            if (count($organisation['items'])) {
                usort($organisation['items'], function($a, $b) {
                    return strnatcasecmp($a['title'], $b['title']);
                });
                $organisations[] = $organisation;
            }
        }

        usort($organisations, function($a, $b) {
            return strnatcasecmp($a['title'], $b['title']);
        });

        return json_encode($organisations);
    }


    /**
     * @ignorevalidation $offer
     * @param Offer|null $offer
     * @param bool $saved
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function newOfferPageAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer = null, $saved = false)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        $dateTypes = [
            ["id" => 0, "title" => "Ohne Termin", "active" => !$offer || !$offer->getDateType()],
            ["id" => 1, "title" => "Konkrete Daten", "active" => $offer && $offer->getDateType() === 1],
            ["id" => 2, "title" => "Zeitraum", "active" => $offer && $offer->getDateType() === 2],
            ["id" => 3, "title" => "Täglich", "active" => $offer && $offer->getDateType() === 3],
            ["id" => 4, "title" => "Wöchentlich", "active" => $offer && $offer->getDateType() === 4],
        ];

        $activeUser = $offer && $offer->getCreator() ? $offer->getCreator() : $currentUser;

        $currentProvider = $isAdmin ? null : UserUtility::getUserProvider($currentUser,
            $this->providerRepository->findAll());

        $providers = $this->getProviderUserForSelect($activeUser, $currentProvider);

        $this->view->assign('providers', $providers);
        $this->view->assign('salutations', $this->selectUtility->getSalutationsJson($offer));
        $this->view->assign('images', $this->getUploadedImageJson($offer ? $offer->getImages() : null));
        $this->view->assign('contentImage', $this->getUploadedImageJson($offer ? $offer->getContentImage() : null));
        $this->view->assign('contactImage', $this->getUploadedImageJson($offer ? $offer->getContactImage() : null));
        $this->view->assign('categories', $this->selectUtility->getCategoriesForSelect($offer, false, false));
        $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect($offer));
        $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect($offer));
        $this->view->assign('dateTypes', json_encode($dateTypes));
        $this->view->assign('saved', $saved);
        $this->view->assign('offer', $offer);
    }
}
