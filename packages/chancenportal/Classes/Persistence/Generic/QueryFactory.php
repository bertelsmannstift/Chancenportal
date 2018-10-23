<?php
namespace Chancenportal\Chancenportal\Persistence\Generic;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

class QueryFactory extends \TYPO3\CMS\Extbase\Persistence\Generic\QueryFactory
{
    public function create($className)
    {
        $query = parent::create($className);
        if (is_a($className, FrontendUser::class, true)) {
            $querySettings = $query->getQuerySettings();
            $querySettings->setIgnoreEnableFields(true);
        }
        return $query;
    }
}
