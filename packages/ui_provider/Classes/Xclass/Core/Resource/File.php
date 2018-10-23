<?php
namespace UI\UiProvider\Xclass\Core\Resource;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * File
 */
class File extends \TYPO3\CMS\Core\Resource\File
{
    /**
     * Returns the MetaData
     *
     * @return array
     */
    public function getMetaDataProperties()
    {
        return $this->_getMetaData();
    }
}
