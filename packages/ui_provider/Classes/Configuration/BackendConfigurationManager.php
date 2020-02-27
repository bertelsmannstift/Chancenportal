<?php
namespace UI\UiProvider\Configuration;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

/**
 * Class BackendConfigurationManager
 * @package UI\UiProvider\Configuration
 *
 * Provides a function to set the protected property '$currentPageId' which, when set, allows to get the TypoScript
 * settings for a particular uid, taking the TypoScript settings of the template record into account.
 *
 * Usage
 * -----
 * $backendConfigurationManager = $this->objectManager->get(\UI\UiProvider\Configuration\BackendConfigurationManager::class);
 * $backendConfigurationManager->setConfiguration();
 * $backendConfigurationManager->setCurrentPageId(123);
 * $backendConfiguration = $backendConfigurationManager->getConfiguration();
 *
 * Used in
 * -------
 * - Used in the ui_search indexer to loop all siteroots and get their respective TypoScript settings.
 */
class BackendConfigurationManager extends \TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager
{
    public function setCurrentPageId($id)
    {
        $this->currentPageId = $id;
    }
}
