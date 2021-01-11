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

use Chancenportal\Chancenportal\Domain\Model\FrontendUser;
use Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup;
use Chancenportal\Chancenportal\Domain\Model\Provider;
use Chancenportal\Chancenportal\Utility\MailUtility;
use Chancenportal\Chancenportal\Utility\UserUtility;
use DmitryDulepov\Realurl\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;

/**
 * FrontendUserController
 */
class FrontendUserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $frontendUserGroupRepository = null;

    /**
     * providerRepository
     *
     * @var \Chancenportal\Chancenportal\Domain\Repository\ProviderRepository
     * @inject
     */
    protected $providerRepository = null;

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function initializeCreateAction()
    {
        if ($this->arguments->hasArgument('user')) {
            $this->arguments->getArgument('user')->getPropertyMappingConfiguration()->allowProperties('group');
            $this->arguments->getArgument('user')->getPropertyMappingConfiguration()->setTargetTypeForSubProperty('group',
                'string');
        }
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function loginAction()
    {
        $email = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('email');
        $password = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('password');
        $user = null;

        if (!empty($email) && !empty($password)) {
            $user = $this->frontendUserRepository->findFirstByEmailAndPassword($email, $password);
        }

        if ($user) {
            UserUtility::login($user);
            return '';
        }

        $this->view->assign('settings', $this->settings);
        $this->view->assign('error', true);
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function logoutPageAction()
    {
        if ($GLOBALS['TSFE']->fe_user) {
            $GLOBALS['TSFE']->fe_user->removeCookie($GLOBALS['TSFE']->fe_user->name);
            $GLOBALS['TSFE']->fe_user->removeSessionData();
        }

        $this->redirectToUri('/');
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function lostPasswordPageAction()
    {
        $currentUser = UserUtility::getCurrentUser();

        if ($currentUser) {
            $this->redirectToUri('/');
        }

        $send = false;
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $email = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('email');
        $hash = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('hash');

        if (!$email && $hash) {
            $user = $this->frontendUserRepository->findOneByPasswordResetHash($hash);

            $password = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('password');
            $passwordRepeat = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('password_repeat');

            if (strlen($password) > 6 && $password === $passwordRepeat) {

                $objInstanceSaltedPw = SaltFactory::getSaltingInstance();
                $user->setPasswordResetHash('');
                $user->setPassword($objInstanceSaltedPw->getHashedPassword($password));
                $this->frontendUserRepository->update($user);
                $persistenceManager->persistAll();
                $this->view->assign('done', true);

            } elseif ($user) {
                $this->view->assign('hash', $hash);
                $this->view->assign('user', $user);
            }
        } else {
            if ($email) {

                $user = $this->frontendUserRepository->findOneByUsername($email);

                if ($user) {
                    $hash = md5($user->getUid() . microtime(true) . $email);
                    $user->setPasswordResetHash($hash);
                    $this->frontendUserRepository->update($user);
                    $persistenceManager->persistAll();

                    $resetLink = $this->uriBuilder->reset()
                        ->setTargetPageUid($GLOBALS['TSFE']->id)
                        ->setCreateAbsoluteUri(true)
                        ->setArguments(['hash' => $hash])
                        ->build();

                    $send = true;
                    MailUtility::sendTemplateEmail([$email], [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['lost_password_subject'], 'LostPass.html',
                        ['resetLink' => $resetLink, 'user' => $user, 'settings' => $this->settings]);
                }
            }
        }
        $this->view->assign('send', $send);
    }

    /**
     * Login page
     */
    public function loginPageAction()
    {
        // nothing to do here
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("user")
     * @param FrontendUser $user
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function loginAsAction(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $user) {

        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);

        if($isAdmin) {
            UserUtility::login($user);
        }

        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder
            ->setTargetPageUid($this->settings['chancenportal']['pageIds']['overview'])
            ->build();

        $this->redirectToUri($uri, 0, 301);
    }

    /**
     * @validate $user \Chancenportal\Chancenportal\Domain\Validator\UserValidator
     * @validate $user \Chancenportal\Chancenportal\Domain\Validator\GroupValidator
     * @param FrontendUser $user
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function createAction(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $user)
    {
        $userCheck = $this->frontendUserRepository->findOneByUsername($user->getUsername());
        if ($userCheck) {
            $this->redirect('registerPage', null, null, ['registerDone' => false, 'error' => true]);
        }

        $data = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_chancenportal_chancenportal');

        $registry = GeneralUtility::makeInstance(\Chancenportal\Chancenportal\Domain\Registry::class);

        $optinKey = md5(uniqid(microtime()));
        $registry->set('chancenportalUserOptin', $optinKey, [
            'expires' => time() + 60*60*24,
            'user' => $user,
            'data' => $data
        ]);

        MailUtility::sendTemplateEmail([$user->getUsername()], [$this->settings['chancenportal']['email']['sender']],
            [], $this->settings['chancenportal']['email']['new_user_subject'], 'Optin.html', ['settings' => $this->settings, 'optinKey' => $optinKey]);

        $this->redirect('registerPage', null, null, ['optinSent' => true]);
    }

    /**
     * @param $user
     * @param $data
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    private function createUserAfterOptin($user, $data) {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        if (!isset($data['user']['companyGroup']) && !empty($data['user']['company'])) {
            $newGroup = new FrontendUserGroup();
            $newGroup->setTitle($data['user']['company']);
            $newGroup->setHidden(false);
            $this->frontendUserGroupRepository->add($newGroup);
            $persistenceManager->persistAll();
            $user->addUsergroup($newGroup);

            $newProvider = new Provider();
            $newProvider->setName($data['user']['company']);
            $newProvider->setOwnerGroup($newGroup);
            $newProvider->setCreator($user);
            $newProvider->setApproved(false);
            $newProvider->setActive(false);
            $newProvider->setAuthor($user);
            $this->providerRepository->add($newProvider);
            $persistenceManager->persistAll();
        }

        $user->setTermsAndConditionsDate(new \DateTime());
        // After registration disable the user first
        $user->setDisable(true);

        $this->frontendUserRepository->add($user);
        $persistenceManager->persistAll();

        $adminEmails = UserUtility::getAdminEMails();

        if(count($adminEmails)) {
            MailUtility::sendTemplateEmail($adminEmails, [$this->settings['chancenportal']['email']['sender']],
                [], $this->settings['chancenportal']['email']['new_user_reg_subject'], 'NewUser.html', ['settings' => $this->settings]);
        }

        MailUtility::sendTemplateEmail([$user->getUsername()], [$this->settings['chancenportal']['email']['sender']],
            [], $this->settings['chancenportal']['email']['new_user_subject'], 'Register.html', ['settings' => $this->settings]);
    }

    /**
     * @param bool $registerDone
     * @param bool $error
     * @param bool $optinSent
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function registerPageAction($registerDone = false, $error = false, $optinSent = false)
    {
        $arguments = $this->request->getArguments();
        if(!empty($arguments['key'])) {
            $registry = GeneralUtility::makeInstance(\Chancenportal\Chancenportal\Domain\Registry::class);

            $this->view->assign('optinReceived', true);

            $optinUser = $registry->get('chancenportalUserOptin', $arguments['key']);

            if($optinUser && $optinUser['expires'] <= (time() + 60*60*24)) {
                $this->createUserAfterOptin($optinUser['user'], $optinUser['data']);

                $registry->remove('chancenportalUserOptin', $arguments['key']);

                $this->redirect('registerPage', null, null, ['registerDone' => true]);
            } else {
                $this->view->assign('optinError', 'Der Link ist nicht mehr gültig.');
            }
        }

        $providers = $this->getProviderForSelect($this->providerRepository->findAll());
        $this->view->assign('providers', $providers);
        $this->view->assign('error', $error);
        $this->view->assign('registerDone', $registerDone);
        $this->view->assign('optinSent', $optinSent);
        $this->view->assign('user', new FrontendUser());
    }

    /**
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function userManagementPageAction()
    {
        $group = UserUtility::getPermissionGroup(UserUtility::getCurrentUser());

        $users = [];

        if ($group && $group->getUid() == $this->settings['chancenportal']['permissions']['admin_group']) {
            $users = [];
            $data = $this->frontendUserRepository->findAll();
            foreach($data as $item) {
                if(!UserUtility::isAdmin($item)) {
                    $users[] = $item;
                }
            }
        } else {
            if ($group && $group->getUid() == $this->settings['chancenportal']['permissions']['provider_group']) {
                $users = $this->frontendUserRepository->findAllByUserGroup(UserUtility::getCurrentUser(),
                    array_flip($this->settings['chancenportal']['permissions']));
            }
        }

        usort($users, function($a, $b){
            return intval($a->getDisable()) < intval($b->getDisable());
        });

        $this->view->assign('users', $users);
    }

    /**
     * @param bool $saved
     */
    public function myDataPageAction($saved = false)
    {
        $this->view->assign('currentUser', UserUtility::getCurrentUser());
        $this->view->assign('saved', $saved);
        $this->view->assign('user', UserUtility::getCurrentUser());
    }

    /**
     * @validate $user \Chancenportal\Chancenportal\Domain\Validator\UserValidator
     * @param FrontendUser $user
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function myDataSaveAction(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $user)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $this->frontendUserRepository->update($user);
        $persistenceManager->persistAll();
        $this->redirect('myDataPage', null, null, ['saved' => true]);
    }

    /**
     * @validate $user \Chancenportal\Chancenportal\Domain\Validator\AdminUserValidator
     * @validate $user \Chancenportal\Chancenportal\Domain\Validator\GroupValidator
     * @param FrontendUser $user |null
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function userEditSaveAction(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $user = null)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $data = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_chancenportal_chancenportal');

        if(!$user || !$user->getUid()) {
            $userCheck = $this->frontendUserRepository->findOneByUsername($user->getUsername());

            if(!!$userCheck) {
                $this->redirect('userEditPage', null, null, ['user' => null, 'saved' => false, 'error' => true]);
                return;
            }
        }

        $currentUser = UserUtility::getCurrentUser();
        $isAdmin = UserUtility::isAdmin($currentUser);
        $isProvider = UserUtility::isProvider($currentUser);

        $this->checkEditPermission($user);

        if ($isProvider === false && !empty($data['user']['company']) && empty($data['user']['companyGroup'])) {
            $permissionGroup = $this->frontendUserGroupRepository->findByUid($data['user']['group']);

            // New provider and group
            $newGroup = new FrontendUserGroup();
            $newGroup->setTitle($data['user']['company']);
            $newGroup->setHidden(false);
            $this->frontendUserGroupRepository->add($newGroup);
            $persistenceManager->persistAll();

            $user->setUsergroup(new ObjectStorage());
            $user->addUsergroup($newGroup);
            $user->addUsergroup($permissionGroup);

            $newProvider = new Provider();
            $newProvider->setName($data['user']['company']);
            $newProvider->setOwnerGroup($newGroup);
            $newProvider->setCreator($currentUser);
            $newProvider->setApproved(true);
            $newProvider->setActive(false);
            $newProvider->setAuthor($user);
            $this->providerRepository->add($newProvider);
            $persistenceManager->persistAll();

        } elseif ($isProvider === false && !empty($data['user']['companyGroup'])) {
            // Provider exists
            $permissionGroup = $this->frontendUserGroupRepository->findByUid($data['user']['group']);
            $group = $this->frontendUserGroupRepository->findByUid($data['user']['companyGroup']);
            $user->setUsergroup(new ObjectStorage());
            $user->addUsergroup($group);
            $user->addUsergroup($permissionGroup);
            $persistenceManager->persistAll();

        } elseif($isProvider) {
            // Provider created a new user
            $currentUserGroup = UserUtility::getOrganisationGroup($currentUser);
            $currentUserPermissionGroup = UserUtility::getPermissionGroup($currentUser);
            $user->setUsergroup(new ObjectStorage());
            $user->addUsergroup($currentUserGroup);
            $user->addUsergroup($currentUserPermissionGroup);
        }

        $user->setTermsAndConditionsDate(new \DateTime());

        if($isAdmin || $isProvider) {
            if ($user->getUid()) {
                $this->frontendUserRepository->update($user);
            } else {
                $user->setConfirmationSend(true);
                $this->frontendUserRepository->add($user);

                if($isAdmin) {
                    MailUtility::sendTemplateEmail([$user->getUsername()],
                        [$this->settings['chancenportal']['email']['sender']], [],
                        $this->settings['chancenportal']['email']['admin_new_user_added_subject'], 'AddUser.html', ['password' => $data['password'], 'user' => $user, 'settings' => $this->settings]);
                }
            }
        }

        if ($data['user']['disable'] === '1') {
            if ($user->getConfirmationSend() === false) {
                $user->setConfirmationSend(true);
                MailUtility::sendTemplateEmail([$user->getUsername()],
                    [$this->settings['chancenportal']['email']['sender']], [],
                    $this->settings['chancenportal']['email']['confirm_subject'], 'Confirm.html', ['user' => $user, 'settings' => $this->settings]);
            }
        }

        if ($data['user']['disable'] === '1') {
            $user->setDisable(false);
        } else {
            $user->setDisable(true);
        }
        $persistenceManager->persistAll();

        $this->redirect('userEditPage', null, null, ['user' => $user, 'saved' => true, 'error' => false]);
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("user")
     * @param FrontendUser $user
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteUserAction(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $user)
    {
        $this->frontendUserRepository->remove($user);
        $this->redirect('userManagementPage');
    }

    /**
     * @param FrontendUser|null $user
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    private function checkEditPermission(FrontendUser $user = null)
    {
        $currentUser = UserUtility::getCurrentUser();
        $isProvider = UserUtility::isProvider($currentUser);
        $isAdmin = UserUtility::isAdmin($currentUser);
        $overviewUrl = $this->uriBuilder->reset()->setTargetPageUid($this->settings['chancenportal']['pageIds']['useroverview'])->setCreateAbsoluteUri(true)->build();

        if ($user && $isProvider) {
            $userGroup = UserUtility::getOrganisationGroup($user);
            $currentUserGroup = UserUtility::getOrganisationGroup($currentUser);

            if ($userGroup && $currentUserGroup && $userGroup->getUid() !== $currentUserGroup->getUid()) {
                $this->redirectToUri($overviewUrl);
            }
        }

        if (!$isAdmin && !$isProvider) {
            $this->redirectToUri($overviewUrl);
        }
    }

    /**
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("user")
     * @param FrontendUser|null $user
     * @param bool $saved
     * @param bool $error
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function userEditPageAction(
        \Chancenportal\Chancenportal\Domain\Model\FrontendUser $user = null,
        $saved = false,
        $error = false
    ) {
        $this->checkEditPermission($user);

        $groups = $this->getPermissionGroupsForSelect($user);
        $organisations = $this->getOrganisationGroupsForSelect($user);
        $this->view->assign('currentUser', UserUtility::getCurrentUser());
        $this->view->assign('error', $error);
        $this->view->assign('user', $user ? $user : new FrontendUser());
        $this->view->assign('saved', $saved);
        $this->view->assign('companyGroups', json_encode($organisations));
        $this->view->assign('groups', json_encode($groups));
    }

    /**
     * @param $user
     * @return array
     */
    private function getOrganisationGroupsForSelect($user)
    {
        $providers = $this->providerRepository->findAll();

        if ($user) {
            $userOrganisation = UserUtility::getOrganisationGroup($user);
        } else {
            $userOrganisation = null;
        }

        foreach ($providers as $provider) {
            $providerOwnerGroup = $provider->getOwnerGroup();

            if($providerOwnerGroup->getUid() && !empty($provider->getName())) {
                $organisations[] = [
                    'id' => $providerOwnerGroup->getUid(),
                    'title' => $provider->getName(),
                    'active' => $userOrganisation && $userOrganisation->getUid() === $providerOwnerGroup->getUid(),
                ];
            }
        }

        usort($organisations, function($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        });

        array_unshift($organisations,
            [
                'id' => '',
                'title' => 'Organisation anlegen',
                'active' => !$userOrganisation,
            ]
        );

        return $organisations;
    }

    /**
     * @param $provider
     * @return array
     */
    private function getProviderForSelect($providers)
    {
        foreach ($providers as $provider) {
            if($provider->getOwnerGroup()) {
                $ownerGroup = $provider->getOwnerGroup();

                if($ownerGroup->getUid()) {
                    $organisations[] = [
                        'id' => $ownerGroup->getUid(),
                        'title' => empty($provider->getName()) ? $ownerGroup->getTitle() : $provider->getName(),
                        'active' => false,
                    ];
                }
            }
        }

        usort($organisations, function($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        });

        array_unshift($organisations, [
            'id' => '',
            'title' => 'Neue Organisation',
            'active' => true
        ]);

        return json_encode($organisations);
    }

    /**
     * @param $user
     * @return array
     */
    private function getPermissionGroupsForSelect($user)
    {
        $userPermissionGroup = null;
        if ($user) {
            $userPermissionGroup = UserUtility::getPermissionGroup($user);
        }

        $groups = $this->frontendUserGroupRepository->findAllByPermissions();
        $jsonGroups = [];

        foreach ($groups as $group) {
            $active = false;

            if(UserUtility::isGroupOfType($group, 'admin_group')) {
                continue;
            }

            if (is_object($userPermissionGroup)) {
                $active = $userPermissionGroup->getUid() === $group->getUid();
            } else {
                if ($userPermissionGroup === null) {
                    $active = true;
                    $userPermissionGroup = true;
                }
            }

            $jsonGroups[] = [
                'id' => $group->getUid(),
                'title' => $group->getTitle(),
                'active' => $active,
            ];
        }
        return $jsonGroups;
    }
}
