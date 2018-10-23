<?php
namespace UI\UiProvider\Configuration;

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

/**
 * BackendConfigurationManager
 */
class BackendConfigurationManager extends \TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager
{
    public function setCurrentPageId($id)
    {
        $this->currentPageId = $id;
    }
}
