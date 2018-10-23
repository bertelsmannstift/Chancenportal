<?php
namespace UI\UiProvider\Hooks;

/***
 *
 * This file is part of the "u+i Sitepackage" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use UI\UiProvider\Configuration\BackendConfigurationManager;

class RealurlConfigurationHook
{
    public function configure($params, &$pObj)
    {
        /**
         * Get TypoScript configuration
         */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $backendConfigurationManager = $objectManager->get(BackendConfigurationManager::class);
        $backendConfiguration = $backendConfigurationManager->getConfiguration();

        /**
         * Is u+i RealUrl config present?
         */
        if(is_array($backendConfiguration['settings']['uandi']['realurl'])) {
            if(is_array($backendConfiguration['settings']['uandi']['realurl']['preVars'])) {
                unset($params['config']['preVars']);
            }

            $params['config'] = array_merge_recursive($params['config'], $backendConfiguration['settings']['uandi']['realurl']);
        }

        return $params['config'];
    }

    public function postProcessConfiguration($params, &$pObj)
    {
        /**
         * Get TypoScript configuration for foreign rootline and return pageId for foreign detail page
         */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $backendConfigurationManager = $objectManager->get(BackendConfigurationManager::class);

        /**
         * Get TypoScript configuration for each site and merge with global RealUrl config
         */
        foreach($params['config'] as $site => &$config) {
            $backendConfigurationManager->setConfiguration();
            $backendConfigurationManager->setCurrentPageId($config['pagePath']['rootpage_id']);
            $backendConfiguration = $backendConfigurationManager->getConfiguration();

            /**
             * Is u+i RealUrl config present?
             */
            if(is_array($backendConfiguration['settings']['uandi']['realurl'])) {
                if(is_array($backendConfiguration['settings']['uandi']['realurl']['preVars'])) {
                    unset($config['preVars']);
                }

                $config = array_replace_recursive($config, $backendConfiguration['settings']['uandi']['realurl']);
            }
        }

        $backendConfigurationManager->setConfiguration();
        $backendConfigurationManager->setCurrentPageId($GLOBALS["TSFE"]->id);
    }
}
