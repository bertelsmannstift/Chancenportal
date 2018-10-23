<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        /**
         * Restrict CTypes (Select) according to definition in BELayout definitions (allowed = xyz)
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][\UI\UiProvider\Form\FormDataProvider\TcaCTypeItem::class] = [
            'depends' => [
                \TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems::class,
            ],
        ];

        /**
         * Add realurl configuration hook
         */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['ui_provider'] = \UI\UiProvider\Hooks\RealurlConfigurationHook::class . '->configure';
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['postProcessConfiguration']['ui_provider'] = \UI\UiProvider\Hooks\RealurlConfigurationHook::class . '->postProcessConfiguration';

        /**
         * Add Scheduler Task that deletes the RealUrl Autoconf file on demand
         */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\UI\UiProvider\Task\DeleteRealurlAutoconfTask::class] = array(
            'extension' => 'ui_provider',
            'title' => 'Delete RealUrl Autoconf file. (Only use this when you know what you are doing!)',
            'description' => 'Deletes RealUrl Autoconf so it can be automatically re-created.'
        );

        /**
         * Add Scheduler Task that resets RealUrl on demand
         */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\UI\UiProvider\Task\ResetRealurlTask::class] = array(
            'extension' => 'ui_provider',
            'title' => 'Completely Reset RealUrl! (Only use this when you know what you are doing!)',
            'description' => 'Deletes RealUrl Autoconf and truncates RealUrl tables in DB!'
        );

        /**
         * Add custom Query Result/Data Mapper to ease language handling in Extbase
         */
        $extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\Container\\Container');
        $extbaseObjectContainer->registerImplementation('TYPO3\CMS\Extbase\Persistence\QueryResultInterface', 'UI\UiProvider\Persistence\Storage\CustomQueryResult');
        unset($extbaseObjectContainer);

        /**
         * Xclass to provide a Typo3 v.9.x feature that allows to enable/disable localization modes (translate/copy)
         * https://docs.typo3.org/typo3cms/extensions/core/latest/Changelog/9.0/Feature-76910-PageLayoutViewAllowToDisableCopyTranslateButtons.html
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\View\\PageLayoutView'] = array(
            'className' => 'UI\\UiProvider\\Xclass\\Backend\\View\\PageLayoutView'
        );

        /**
         * This Xclass is used to enable fieldControls for single selects.
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\Form\\Element\\SelectSingleElement'] = array(
            'className' => 'UI\\UiProvider\\Xclass\\Backend\\Form\\Element\\SelectSingleElement'
        );

        /**
         * Xclass to extend File Object
         * Adds: Getter for MetaDataProperties
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Resource\\File'] = array(
            'className' => 'UI\\UiProvider\\Xclass\\Core\\Resource\\File'
        );

        /**
         * Xclass to extend Page Renderer
         * Adds: Method to replace meta data items. Used in Canonical tag ViewHelper
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Page\\PageRenderer'] = array(
            'className' => 'UI\\UiProvider\\Xclass\\Core\\Page\\PageRenderer'
        );

        /**
         * Xclass to fix an issue with workspaces previews
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\DataHandling\\DataHandler'] = array(
            'className' => 'UI\\UiProvider\\Xclass\\Core\\DataHandling\\DataHandler'
        );

        /**
         * Register ViewHelper Namespace
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['uandi'] = ['UI\\UiProvider\\ViewHelpers'];

        /**
         * Register Ajax Class
         */
        $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['ui_provider_version'] = 'EXT:ui_provider/Classes/Ajax/Version.php';
    }
);