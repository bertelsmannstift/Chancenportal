<?php

namespace Chancenportal\Chancenportal\Utility;

use Chancenportal\Chancenportal\Domain\Model\FrontendUser;
use Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup;
use Chancenportal\Chancenportal\Domain\Model\Provider;
use Chancenportal\Chancenportal\Domain\Repository\FrontendUserRepository;
use Chancenportal\Chancenportal\Domain\Repository\ProviderRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Saltedpasswords\Salt\SaltFactory;
use TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility;

/**
 * Class UserUtility
 * @codeCoverageIgnore
 */
class UserUtility extends AbstractUtility
{

    /**
     * Return current logged in fe_user
     *
     * @return FrontendUser|null
     */
    public static function getCurrentUser()
    {
        if (self::getPropertyFromUser() !== null) {
            /** @var FrontendUserRepository $userRepository */
            $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(FrontendUserRepository::class);
            return $userRepository->findByUid((int)self::getPropertyFromUser());
        }
        return null;
    }

    /**
     * Get property from current logged in Frontend FrontendUser
     *
     * @param string $propertyName
     * @return string|null
     */
    public static function getPropertyFromUser($propertyName = 'uid')
    {
        if (!empty(self::getTypoScriptFrontendController()->fe_user->user[$propertyName])) {
            return self::getTypoScriptFrontendController()->fe_user->user[$propertyName];
        }
        return null;
    }

    /**
     * Get Usergroups from current logged in user
     * @return array
     */
    public static function getCurrentUsergroupUids()
    {
        $currentLoggedInUser = self::getCurrentUser();
        $usergroupUids = [];
        if ($currentLoggedInUser !== null) {
            foreach ($currentLoggedInUser->getUsergroup() as $usergroup) {
                $usergroupUids[] = $usergroup->getUid();
            }
        }
        return $usergroupUids;
    }

    /**
     * @return array
     */
    static function getAdminEMails()
    {
        $admins = [];
        $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(FrontendUserRepository::class);
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            if (UserUtility::isAdmin($user)) {
                $admins[$user->getUsername()] = $user->getUsername();
            }
        }
        return array_values($admins);
    }

    /**
     * @return array
     */
    static function getAdmins()
    {
        $admins = [];
        $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(FrontendUserRepository::class);
        $users = $userRepository->findAll();
        foreach ($users as $user) {
            if (UserUtility::isAdmin($user)) {
                $admins[$user->getUid()] = $user;
            }
        }
        return array_values($admins);
    }

    /**
     * @param Provider $provider
     * @return mixed
     */
    public static function getUsersByProvider(Provider $provider)
    {
        if (!$provider->getOwnerGroup()) {
            return [];
        }
        $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(FrontendUserRepository::class);
        $query = $userRepository->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $constraints = [];

        $constraints[] = $query->equals('usergroup.uid', $provider->getOwnerGroup()->getUid());
        $query->matching($query->logicalAnd($constraints));

        return $query->execute();
    }

    /**
     * Returns the permission group from a user
     *
     * @param FrontendUser $user
     * @return null|object
     */
    public static function getPermissionGroup(FrontendUser $user)
    {
        $permissions = self::getPermissions();
        foreach ($user->getUsergroup() as $usergroup) {
            if ($usergroup && isset($permissions[$usergroup->getUid()])) {
                return $usergroup;
            }
        }
        return null;
    }

    /**
     * Returns the organisation group from a user
     *
     * @param mixed $user
     * @return FrontendUserGroup|null
     */
    public static function getOrganisationGroup($user)
    {
        if ($user) {
            $permissions = self::getPermissions();
            foreach ($user->getUsergroup() as $usergroup) {
                // check all groups that are NOT a permission
                if ($usergroup && !isset($permissions[$usergroup->getUid()])) {
                    return $usergroup;
                }
            }
        }
        return null;
    }

    /**
     * @param $user
     * @param null $providers
     * @return null
     */
    public static function getUserProvider($user, $providers = null)
    {
        if ($providers === null) {
            $providerRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(ProviderRepository::class);
            $providers = $providerRepository->findAll();
        }

        $group = self::getOrganisationGroup($user);
        if ($group) {
            foreach ($providers as $provider) {
                if ($provider->getOwnerGroup() && $provider->getOwnerGroup()->getUid() === $group->getUid()) {
                    return $provider;
                }
            }
        }
        return null;
    }

    /**
     * @param FrontendUser $user
     * @return bool
     */
    public static function isPlanner(FrontendUser $user)
    {
        $permissions = array_flip(self::getPermissions());
        $usergroup = self::getPermissionGroup($user);
        return $usergroup && $usergroup->getUid() === $permissions['planner_group'];
    }

    /**
     * @param FrontendUser $user
     * @return bool
     */
    public static function isProvider(FrontendUser $user)
    {
        $permissions = array_flip(self::getPermissions());
        $usergroup = self::getPermissionGroup($user);
        return $usergroup && $usergroup->getUid() === $permissions['provider_group'];
    }

    /**
     * @param FrontendUser $user
     * @return bool
     */
    public static function isAdmin(FrontendUser $user)
    {
        $permissions = array_flip(self::getPermissions());
        $usergroup = self::getPermissionGroup($user);
        return $usergroup && $usergroup->getUid() === $permissions['admin_group'];
    }

    /**
     * @param FrontendUserGroup $usergroup
     * @param string $groupKey
     * @return bool
     */
    public static function isGroupOfType(FrontendUserGroup $usergroup, $groupKey = 'admin_group')
    {
        $permissions = array_flip(self::getPermissions());
        return $usergroup->getUid() === $permissions[$groupKey];
    }

    /**
     * Convert password to md5 or sha1 hash
     *
     * @param FrontendUser $user
     * @param string $method
     * @return void
     */
    public static function convertPassword(FrontendUser $user, $method)
    {
        if (array_key_exists('password', UserUtility::getDirtyPropertiesFromUser($user))) {
            self::hashPassword($user, $method);
        }
    }

    /**
     * Hash a password from $user->getPassword()
     *
     * @param FrontendUser $user
     * @param string $method "md5", "sha1" or "none"
     * @return void
     */
    public static function hashPassword(FrontendUser &$user, $method)
    {
        switch ($method) {
            case 'none':
                break;

            case 'md5':
                $user->setPassword(md5($user->getPassword()));
                break;

            case 'sha1':
                $user->setPassword(sha1($user->getPassword()));
                break;

            default:
                if (SaltedPasswordsUtility::isUsageEnabled('FE')) {
                    $objInstanceSaltedPw = SaltFactory::getSaltingInstance();
                    $user->setPassword($objInstanceSaltedPw->getHashedPassword($user->getPassword()));
                }
        }
    }

    /**
     * @param FrontendUser $user
     * @param null $storagePids
     * @throws \ReflectionException
     */
    public static function login(FrontendUser $user, $storagePids = null)
    {
        $tsfe = self::getTypoScriptFrontendController();
        $tsfe->fe_user->checkPid = false;
        $info = $tsfe->fe_user->getAuthInfoArray();

        $extraWhere = ' AND uid = ' . (int)$user->getUid();
        if (!empty($storagePids)) {
            $extraWhere = ' AND pid IN (' . self::getDatabaseConnection()->cleanIntList($storagePids) . ')';
        }

        $userArr = $tsfe->fe_user->fetchUserRecord($info['db_user'], $user->getUsername(), $extraWhere);
        $tsfe->fe_user->createUserSession($userArr);
        $tsfe->fe_user->user = $tsfe->fe_user->fetchUserSession();
        $GLOBALS['TSFE']->fe_user->forceSetCookie = true;
        $tsfe->fe_user->setAndSaveSessionData('ses', true);

        # https://forge.typo3.org/issues/62194
        # Create Session
        $reflection = new \ReflectionClass($GLOBALS['TSFE']->fe_user);
        $setSessionCookieMethod = $reflection->getMethod('setSessionCookie');
        $setSessionCookieMethod->setAccessible(true);
        $setSessionCookieMethod->invoke($GLOBALS['TSFE']->fe_user);
    }
}
