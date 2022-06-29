<?php

namespace Chancenportal\Chancenportal\Domain\Repository;

use Chancenportal\Chancenportal\Domain\Model\FrontendUser;
use Chancenportal\Chancenportal\Utility\UserUtility;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
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
 * The repository for FrontendUsers
 */
class FrontendUserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);
        $querySettings->setIgnoreEnableFields(true);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Overload Find by UID to also get hidden records
     *
     * @param int $uid fe_users UID
     * @return User
     */
    public function findByUid($uid)
    {
        $query = $this->createQuery();
        $this->ignoreEnableFieldsAndStoragePage($query);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $and = [$query->equals('uid', $uid)];

        /** @var User $user */
        $user = $query->matching($query->logicalAnd($and))->execute()->getFirst();
        return $user;
    }

    /**
     * Overload Find by UID to also get hidden records
     *
     * @param $username
     * @return User
     */
    public function findOneByUsername($username)
    {
        $query = $this->createQuery();
        $this->ignoreEnableFieldsAndStoragePage($query);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $and = [$query->equals('username', $username)];

        /** @var User $user */
        $user = $query->matching($query->logicalAnd($and))->execute()->getFirst();
        return $user;
    }

    /**
     * @param QueryInterface $query
     * @param bool $ignoreEnableFields
     */
    protected function ignoreEnableFieldsAndStoragePage(QueryInterface $query, $ignoreEnableFields = true)
    {
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIgnoreEnableFields($ignoreEnableFields);
    }

    /**
     * @param FrontendUser $user
     * @param $filterOut
     * @return object
     * @throws InvalidQueryException
     */
    public function findAllByUserGroup(FrontendUser $user, $filterOut = [])
    {
        $query = $this->createQuery();
        $this->ignoreEnableFieldsAndStoragePage($query);
        $groups = [];

        /**
         * Filter out non provider groups
         */
        foreach ($user->getUsergroup() as $group) {
            if (!isset($filterOut[$group->getUid()])) {
                $groups[] = $group->getUid();
            }
        }
        $and[] = $query->in('usergroup', $groups);
        $query->matching($query->logicalAnd($and));
        $query->setOrderings([
            'disable' => QueryInterface::ORDER_DESCENDING,
            'username' => QueryInterface::ORDER_ASCENDING
        ]);
        return $query->execute();
    }

    /**
     * @return array
     * @throws InvalidQueryException
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findAllNonAdmins()
    {
        $users = [];
        $usergroups = [];
        $providers = [];

        $queryBuilderUsers = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $queryBuilderUsers->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $queryBuilderUsers
            ->select('*')
            ->from('fe_users', 'users')
            ->addOrderBy('disable', 'DESC')
            ->addOrderBy('name', 'ASC');

        $queryBuilderGroups = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');
        $queryBuilderGroups
            ->select('*')
            ->from('fe_groups', 'groups');

        $queryBuilderProviders = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_chancenportal_domain_model_provider');
        $queryBuilderProviders
            ->select('*')
            ->from('tx_chancenportal_domain_model_provider', 'providers');

        $statement = $queryBuilderGroups->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $_usergroups = $statement->fetchAll();

            foreach ($_usergroups as $usergroup) {
                $usergroups[$usergroup['uid']] = $usergroup;
            }
        }

        $statement = $queryBuilderProviders->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $providers = $statement->fetchAll();
        }

        $statement = $queryBuilderUsers->execute();
        if ($statement instanceof \Doctrine\DBAL\Driver\Statement) {
            $_users = $statement->fetchAll();
            $permissions = array_flip(UserUtility::getPermissions());

            foreach ($_users as $user) {
                $userUsergroups = GeneralUtility::trimExplode(',', $user['usergroup']);

                if (in_array((string)$permissions['admin_group'], $userUsergroups)) {
                    continue;
                }

                foreach ($userUsergroups as $userUsergroupUid) {
                    if (empty($user['group']) && in_array($userUsergroupUid, $permissions)) {
                        $user['group'] = $usergroups[$userUsergroupUid];
                    }
                    if (empty($user['companyGroup']) && !in_array($userUsergroupUid, $permissions)) {
                        $user['companyGroup'] = $usergroups[$userUsergroupUid];
                    }
                }

                if (!empty($user['companyGroup']['uid'])) {
                    foreach ($providers as $provider) {
                        if ($provider['owner_group'] === $user['companyGroup']['uid']) {
                            $user['provider'] = $provider;
                            break;
                        }
                    }
                }

                $users[] = $user;
            }
        }

        return $users;
    }

    /**
     * @param string $mail
     * @param string $pass
     * @return object
     */
    public function findFirstByEmailAndPassword(string $mail, string $pass)
    {
        $hashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        $query = $this->createQuery();
        $this->ignoreEnableFieldsAndStoragePage($query, false);
        $and[] = $query->equals('username', $mail);
        $query->matching($query->logicalAnd($and));
        $query->setOrderings(['uid' => QueryInterface::ORDER_DESCENDING]);
        $user = $query->execute()->getFirst();
        if ($user) {
            $hashInstance = $hashFactory->get($user->getPassword(), 'FE');
            if ($user && $hashInstance->checkPassword($pass, $user->getPassword())) {
                return $user;
            }
        }
        return null;
    }

    /**
     * Removes an object from this repository.
     *
     * @param object|int $object The object to remove
     * @throws IllegalObjectTypeException
     */
    public function remove($object)
    {
        if (is_int($object)) {
            $object = $this->findByUid($object);
        }

        if (!$object instanceof $this->objectType) {
            throw new IllegalObjectTypeException('The object given to remove() was not of the type (' . $this->objectType . ') this repository manages.', 1248363336);
        }

        $this->persistenceManager->remove($object);
    }
}
