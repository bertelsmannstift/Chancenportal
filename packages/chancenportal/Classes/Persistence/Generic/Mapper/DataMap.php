<?php
declare(strict_types=1);
namespace Chancenportal\Chancenportal\Persistence\Generic\Mapper;

use Chancenportal\Chancenportal\Domain\Model\FrontendUser;
use Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap as DataMapExtbase;

/**
 * Disable tx_extbase_type='0' in where clause for femanager
 */
class DataMap extends DataMapExtbase
{
    /**
     * Disable record type for femanager
     *
     * @param string $recordType The record type
     * @return void
     */
    public function setRecordType($recordType)
    {
        parent::setRecordType($recordType);
    }
}
