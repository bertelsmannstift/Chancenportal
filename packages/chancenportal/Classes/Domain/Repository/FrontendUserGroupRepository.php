<?php
namespace Chancenportal\Chancenportal\Domain\Repository;

use Chancenportal\Chancenportal\Utility\UserUtility;
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
 * The repository for FrontendUserGroups
 */
class FrontendUserGroupRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {

        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return array
     */
    public function findAllByPermissions()
    {
        $groups = [];
        $permissions = UserUtility::getPermissions();
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(false);
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        foreach ($query->execute() as $group) {
            if (isset($permissions[$group->getUid()])) {
                $groups[] = $group;
            }
        }
        return $groups;
    }

    /**
     * @return array
     */
    public function findAllOrganisations()
    {
        $groups = [];
        $permissions = UserUtility::getPermissions();
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(false);
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        foreach ($query->execute() as $group) {
            if (!isset($permissions[$group->getUid()])) {
                $groups[] = $group;
            }
        }
        return $groups;
    }
}
