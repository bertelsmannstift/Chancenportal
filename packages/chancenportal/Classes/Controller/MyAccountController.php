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
use TYPO3\CMS\Core\Database\ConnectionPool;
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
    )
    {
        try {
            date_default_timezone_set('UTC');
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

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $ts = $queryBuilder->from('tt_content')->select('tstamp')
            ->where(
                $queryBuilder->expr()->eq('uid', $this->settings['chancenportal']['terms_and_condition_element_id'])
            )
            ->execute()
            ->fetchColumn(0);
        $termsDate = new \DateTime("@{$ts}");

        if (GeneralUtility::_POST('accept') === '1') {
            $currentUser->setTermsAndConditionsDate($termsDate);
            $this->frontendUserRepository->update($currentUser);
        }

        $this->view->assign('showTerms', !$currentUser->getTermsAndConditionsDate() || $termsDate > $currentUser->getTermsAndConditionsDate());
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
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

            if ($isAdmin && $provider->getApproved() === true && $provider->approvedChanged && $provider->getAuthor() && $provider->getAuthor()->getDisable() === false) {
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
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

        $this->uriBuilder->reset()->setTargetPageUid($this->settings['chancenportal']['pageIds']['provider_list'])->setCreateAbsoluteUri(true);
        $this->response->setStatus(301);
        $this->response->setHeader('Location', (string)$this->uriBuilder->build());
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function providerPreviewRedirectAction()
    {
        $this->forward('providerPreview', null, null, $GLOBALS['TSFE']->fe_user->getKey('ses', 'provider'));
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
     * @param Provider|null $provider
     */
    public function providerPreviewAction(Provider $provider)
    {
        $this->view->assign('provider', $provider);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("provider")
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
        $logQueryConstraints = [];

        if ($data) {
            $query = $this->logRepository->createQuery();
            $constraints = [];

            if (isset($data[0]) && !empty($data[0])) {
                $startDate = \DateTime::createFromFormat('d.m.Y', $data[0]);
                if ($startDate) {
                    $startDateFormatted =  $startDate->modify('midnight')->format('Y-m-d');
                    $logQueryConstraints['date_start'] = $startDateFormatted;
                    $constraints[] = $query->greaterThanOrEqual('date', $startDateFormatted);
                }
            }
            if (isset($data[1]) && !empty($data[1])) {
                $endDate = \DateTime::createFromFormat('d.m.Y', $data[1]);
                if ($endDate) {
                    $endDateFormatted =  $endDate->modify('midnight +1 day -1 second')->format('Y-m-d');
                    $logQueryConstraints['end_date'] = $endDateFormatted;
                    $constraints[] = $query->lessThanOrEqual('date', $endDateFormatted);
                }
            }

            if (count($constraints)) {
                $query->matching($query->logicalAnd($constraints));
            }

            $offerResults = $this->offerRepository->findByDatesAndCategory($data[0], $data[1], $category);
        } else {
            $offerResults = $this->offerRepository->findAll();
        }

        $offers = $this->logRepository->getOfferLogs($logQueryConstraints);
        $categories = $this->logRepository->getCategoryLogs($logQueryConstraints);
        $terms = $this->logRepository->getTermLogs($logQueryConstraints);

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
        if (is_object($image) && get_class($image) === FileReference::class) {
            $images[] = [
                'uploaded' => true,
                'dataUrl' => $image->getUid(),
                'size' => null,
                'name' => $image->getOriginalResource()->getOriginalFile()->getName(),
                'id' => $image->getUid(),
            ];
        } elseif (is_object($image) && get_class($image) === ObjectStorage::class) {
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
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    private function handleImport($file)
    {
        setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu', 'de_DE.utf8');
        $offers = [];
        $count = 0;

        //shell_exec($this->settings['chancenportal']['xls_converter'] . ' ' . $file['tmp_name'] . ' ' . $file['tmp_name'] . ".csv 2>&1");

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file['tmp_name']);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $writer->save($file['tmp_name'] . '.csv');

        if (($handle = fopen($file['tmp_name'] . '.csv', "r")) !== false) {
            while (($data = fgetcsv($handle, 99999, ",")) !== false) {

                $count++;
                if ($count < 3) {
                    continue;
                }

                if (!empty($data[0])) {
                    if (!isset($offers[$data[0]])) {
                        $offers[$data[0]] = [
                            'name' => $this->cleanExcelImport($data[1], true),
                            'mainCategory' => $data[2],
                            'dates' => [],
                            'dateType' => $this->mapDateNameToType($data[3]),
                            'address' => $this->cleanExcelImport($data[8], true),
                            'info' => $this->cleanExcelImport($data[9], true),
                            'district' => $data[10],
                            'targetGroups' => explode(',', $data[11]),
                            'shortDescription' => $this->cleanExcelImport(substr($data[12], 0, 200)),
                            'longDescription' => $this->cleanExcelImport(nl2br($data[13])),
                            'speaker' => $data[14],
                            'format' => $data[15],
                            'youtube' => trim($data[16]),
                            'conditionsOfParticipation' => $this->cleanExcelImport($data[17]),
                            'courseNumber' => $data[18],
                            'allowedParticipants' => $data[19],
                            'costs' => $this->cleanExcelImport($data[20], true),
                            'noCosts' => trim(strtolower($data[21])) === 'ja' ? true : false,
                            'access' => trim(strtolower($data[22])) === 'offen' ? 2 : (trim(strtolower($data[22])) === 'mitgliedschaft erforderlich' ? 3 : 1),
                            'accessibility' => trim(strtolower($data[23])) === 'ja' ? 2 : (trim(strtolower($data[23])) === 'nein' ? 3 : 1),
                            'providerCooperation' => $this->cleanExcelImport($data[24], true),
                            'contactSalutation' => trim(strtolower($data[25])) === 'herr' ? '1' : '0',
                            'contactName' => $this->cleanExcelImport($data[26], true),
                            'contactJurisdiction' => $this->cleanExcelImport($data[27], true),
                            'contactPhone' => $this->cleanExcelImport($data[28], true),
                            'contactEmail' => $this->cleanExcelImport($data[29], true),
                            'participation' => trim(strtolower($data[31])) === 'ja' ? true : false,
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

                                $day = intval((new \DateTime('@' . strtotime($data[4])))->format('N'));

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
                        $dateObj = new \DateTime('@' . strtotime($date['startDate']));

                        if ($lastDate === null || ($dateObj && $dateObj < $lastDate)) {
                            $lastDate = $dateObj;

                            if(!empty($date['endDate']) && strtotime($date['endDate']) !== false) {
                                $endDate = new \DateTime('@' . strtotime($date['endDate']));
                            }
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
                        if ($data['startDate'] instanceof \DateTime) {
                            $offer->setStartDate($data['startDate']);
                        } elseif (is_string($data['startDate']) && !empty($data['startDate']) && strtotime($data['startDate']) !== false) {
                            $offer->setStartDate(new \DateTime('@' . strtotime($data['startDate'])));
                        }

                        if ($data['endDate'] instanceof \DateTime) {
                            $offer->setEndDate($data['endDate']);
                        } elseif (is_string($data['endDate']) && !empty($data['endDate']) && strtotime($data['endDate']) !== false) {
                            $offer->setEndDate(new \DateTime('@' . strtotime($data['endDate'])));
                        }

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

                            $date->setStartDate(new \DateTime('@' . strtotime($dateData['startDate'])));
                            $date->setEndDate(new \DateTime('@' . strtotime($endDate)));

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
                    $offer->setAddress($latLng[2]);
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
                $offer->setContactSalutation($data['contactSalutation']);
                $offer->setContactJurisdiction($data['contactJurisdiction']);
                $offer->setContactPhone($data['contactPhone']);
                $offer->setContactEmail($data['contactEmail']);
                $offer->setParticipation($data['participation']);
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

    private function cleanExcelImport($string, $removeLinebreaks = false)
    {
        if ($removeLinebreaks) {
            $string = str_replace('_x000D_', ' ', $string);
        } else {
            $string = str_replace('_x000D_', '<br/>', $string);
        }

        $string = str_replace('""', '"', $string);
        $string = str_replace('  ', ' ', $string);

        return trim($string);
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
        $tmpfname = tempnam(sys_get_temp_dir(), "export") . '.csv';
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
            ($this->settings['chancenportal']['use_zip_filter'] === '1' ? "PLZ/Stadtteil" : "Stadtteil*"),
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
            utf8_decode("Engagement möglich"),
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
            "Einfachauswahl",
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
                $offer->getParticipation() ? 'Ja' : 'Nein',
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

        //$result = shell_exec($this->settings['chancenportal']['xls_converter'] . ' ' . $tmpfname . ' ' . $tmpfname . ".xls 2>&1");

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $reader->setInputEncoding('CP1252');

        $spreadsheet = $reader->load($tmpfname);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tmpfname . '.xls');

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
        $key = !empty($this->settings['chancenportal']['google_maps_api_key_no_restrictions']) ? $this->settings['chancenportal']['google_maps_api_key_no_restrictions'] : $this->settings['chancenportal']['google_maps_api_key'];
        $result = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $key));

        if (isset($result->results[0])) {
            return [str_replace(',', '.', $result->results[0]->geometry->location->lat), str_replace(',', '.', $result->results[0]->geometry->location->lng), $result->results[0]->formatted_address];
        }
        return null;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("offer")
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function offerPreviewAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if ($isAdmin === true) {
            $creatorData = explode(':', $this->request->getArgument('creator'));
            if ($creatorData[0] === 'provider') {
                $offer->setProvider($this->providerRepository->findByUid($creatorData[1]));
                $offer->setCreator(null);
            } else if ($creatorData[0] === 'user') {
                $offer->setCreator($this->frontendUserRepository->findByUid($creatorData[1]));
                $offer->setProvider($offer->getCreator()->getProvider());
            }
        } else {
            $userProvider = UserUtility::getUserProvider($currentUser, $this->providerRepository->findAll());
            $offer->setProvider($userProvider);
        }

        $this->view->assign('offer', $offer);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("offer")
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteOfferAction(\Chancenportal\Chancenportal\Domain\Model\Offer $offer)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if ($isAdmin && $offer->getCreator() && $offer->getCreator()->getDisable() === false) {
            MailUtility::sendTemplateEmail([$offer->getCreator()->getEmail()],
                [$this->settings['chancenportal']['email']['sender']], [],
                $this->settings['chancenportal']['email']['delete_offer_subject'], 'DeleteOffer.html',
                ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
        }

        $this->offerRepository->remove($offer);

        $this->uriBuilder->reset()->setTargetPageUid($this->settings['chancenportal']['pageIds']['offer_overview'])->setCreateAbsoluteUri(true);
        $this->response->setStatus(301);
        $this->response->setHeader('Location', (string)$this->uriBuilder->build());
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
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("offer")
     * @param Offer|null $offer
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
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
        $creatorData = explode(':', $this->request->getArgument('creator'));
        $data = GeneralUtility::_GP('tx_chancenportal_chancenportal');

        $provider = null;

        if ($isAdmin === false) {
            $provider = $this->providerRepository->findOneByOwnerGroup($group);
        }

        if ($isAdmin || $provider) {
            $offerActiveState = $offer->getActive();

            if (!$offer->getCreator()) {
                $offer->setCreator($currentUser);
            }

            // Fix TYPO3 Bug
            $offer->setCosts($data['offer']['costs']);
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
                if ($creatorData[0] === 'provider') {
                    $offer->setProvider($this->providerRepository->findByUid($creatorData[1]));
                    $offer->setCreator(null);
                } else if ($creatorData[0] === 'user') {
                    $offer->setCreator($this->frontendUserRepository->findByUid($creatorData[1]));
                    $offer->setProvider($offer->getCreator()->getProvider());
                } else {
                    $creator = $offer->getCreator();
                    $userProvider = UserUtility::getUserProvider($creator, $this->providerRepository->findAll());
                    $offer->setProvider($userProvider);
                }
            }

            if ($offer->isSave()) {
                if ($offer->getUid()) {
                    $this->offerRepository->update($offer);
                } else {
                    $this->offerRepository->add($offer);
                }

                $persistenceManager->persistAll();

                $this->redirect('newOfferPage', null, null, ['offer' => $offer, 'saved' => true],
                    $this->settings['chancenportal']['pageIds']['offer_edit']);
            } else if ($offer->isPreview()) {
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

                } elseif ($this->settings['chancenportal']['activate_offer_approval'] === '1' && $offer->getCreator() && $offer->getApproved() && $offer->approvedChanged && $offer->getCreator()->getDisable() === false) {
                    MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['request_offer_approval_subject'], 'ApprovedOffer.html',
                        ['offer' => $offer, 'user' => $offer->getCreator(), 'settings' => $this->settings]);
                }

                /**
                 * Active state might have been changed by setCreator. If this is an admin, keep the submitted state.
                 */
                if($isAdmin) {
                    $offer->setActive($offerActiveState);
                }

                if ($offer->creatorChanged === false && $data['offer']['active'] === '1') {
                    $offer->setActive(true);
                } else {
                    if ($isAdmin && ($offer->getCreator() || $offer->getProvider()) && $offer->activeChanged && $data['offer']['active'] === '0') {
                        if ($offer->getCreator() && $offer->getCreator()->getDisable() === false) {
                            MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                                [$this->settings['chancenportal']['email']['sender']], [],
                                $this->settings['chancenportal']['email']['delete_offer_subject'], 'DeactivateOffer.html',
                                ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
                        }
                        $offer->setActive(false);
                    } elseif ($isAdmin === false && $offer->creatorChanged) {
                        if ($offer->getCreator() && $offer->getCreator()->getDisable() === false) {
                            MailUtility::sendTemplateEmail([$offer->getCreator()->getUsername()],
                                [$this->settings['chancenportal']['email']['sender']], [],
                                $this->settings['chancenportal']['email']['creator_changed_subject'], 'CreatorChange.html',
                                ['offer' => $offer, 'user' => $currentUser, 'settings' => $this->settings]);
                        }
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
     * @param Offer $offer
     * @param mixed $userProvider
     * @return string
     */
    private function getProviderUserForSelect($offer, $currentUserProvider = null)
    {
        $organisations = [];
        $currentUser = UserUtility::getCurrentUser();
        $providers = $this->providerRepository->findAll();
        $activeUser = $offer && $offer->getCreator() ? $offer->getCreator() : $currentUser;
        $userActive = null;

        foreach ($providers as $provider) {

            if ($currentUserProvider && $currentUserProvider->getUid() !== $provider->getUid()) {
                continue;
            }

            $users = UserUtility::getUsersByProvider($provider);

            $organisation = [
                'id' => 'provider:' . $provider->getUid(),
                'title' => empty($provider->getName()) ? $provider->getOwnerGroup()->getTitle() : $provider->getName(),
                'items' => []
            ];

            foreach ($users as $user) {
                $userActive = $activeUser && $activeUser->getUid() === $user->getUid() ? true : false;
                $organisation['items'][] = [
                    'id' => 'user:' . $user->getUid(),
                    'title' => (empty($user->getName()) ? $provider->getOwnerGroup()->getTitle() : $user->getName()),
                    'active' => $userActive,
                ];
            }

            $organisation['active'] = !$userActive && $offer && $offer->getProvider() && $provider && ($offer->getProvider()->getUid() === $provider->getUid() ? true : false);

            usort($organisation['items'], function ($a, $b) {
                return strnatcasecmp($a['title'], $b['title']);
            });
            $organisations[] = $organisation;
        }

        usort($organisations, function ($a, $b) {
            return strnatcasecmp($a['title'], $b['title']);
        });

        return json_encode($organisations);
    }


    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("offer")
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

        $addressTypes = [
            ["id" => 1, "title" => "Angebot mit Adresse", "active" => !$offer || !$offer->getAddressType() || $offer->getAddressType() === 1],
            ["id" => 2, "title" => "Angebot ohne Adresse (Z.B. Onlineangebot)", "active" => $offer && $offer->getAddressType() === 2]
        ];

        $currentProvider = $isAdmin ? null : UserUtility::getUserProvider($currentUser,
            $this->providerRepository->findAll());

        $providers = $this->getProviderUserForSelect($offer, $currentProvider);

        $categories = $this->selectUtility->getCategoriesForSelect($offer, false, false);
        $hasSubCategories = false;

        foreach (json_decode($categories, true) as $category) {
            if(!empty($category['items'])) {
                $hasSubCategories = true;
                break;
            }
        }

        $this->view->assign('providers', $providers);
        $this->view->assign('salutations', $this->selectUtility->getSalutationsJson($offer));
        $this->view->assign('images', $this->getUploadedImageJson($offer ? $offer->getImages() : null));
        $this->view->assign('contentImage', $this->getUploadedImageJson($offer ? $offer->getContentImage() : null));
        $this->view->assign('contactImage', $this->getUploadedImageJson($offer ? $offer->getContactImage() : null));
        $this->view->assign('categories', $categories);
        $this->view->assign('hasSubCategories', $hasSubCategories);
        $this->view->assign('districts', $this->selectUtility->getDistrictsForSelect($offer, false, true));
        $this->view->assign('targetGroups', $this->selectUtility->getTargetGroupsForSelect($offer));
        $this->view->assign('dateTypes', json_encode($dateTypes));
        $this->view->assign('addressTypes', json_encode($addressTypes));
        $this->view->assign('saved', $saved);
        $this->view->assign('offer', $offer);
        $this->view->assign('currentProvider', $currentProvider);
        $this->view->assign('currentProviderContactImage', $this->getUploadedImageJson($currentProvider ? $currentProvider->getContactImage() : null));
        $this->view->assign('currentProviderContactSalutation', $this->selectUtility->getSalutationsJson($currentProvider));
    }
}
