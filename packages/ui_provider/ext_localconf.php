<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        $versionNumberUtility = \TYPO3\CMS\Core\Utility\VersionNumberUtility::class;

        /**
         * Default PageTsConfig
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:ui_provider/Configuration/PageTSconfig/" extensions="typoscript">');

        /**
         * Register RTE preset config to use with CKEditor
         */
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['UI'] = 'EXT:ui_provider/Configuration/RTE/UI.yaml';

        /**
         * Add WizardItems Hook
         *
         * Sorts CE Wizard items by title (Default is by key)
         */
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms']['db_new_content_el']['wizardItemsHook']['ui_provider'] = UI\UiProvider\Hooks\WizardItemsHook::class;

        /**
         * Register ViewHelper Namespace globally. No need to register namespace in fluid templates
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['uandi'] = ['UI\\UiProvider\\ViewHelpers'];

        /**
         * Disable Deprecation Logs in Production Context
         */
        if(!\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isDevelopment()) {
            $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][\TYPO3\CMS\Core\Log\LogLevel::NOTICE] = [];
        }

        /**
         * Register Ajax Class
         * TODO: Still needed? Add further description
         */
        $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['ui_provider_version'] = 'EXT:ui_provider/Classes/Ajax/Version.php';

        /**
         * Xclass to extend File Object
         * Adds: Getter for MetaDataProperties
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Resource\File::class] = array(
            'className' => \UI\UiProvider\Xclass\TYPO3\CMS\Core\Resource\File::class
        );

        /**
         * Xclass to extend Page Renderer
         * Adds: Method to replace meta data items. Used in Canonical tag ViewHelper
         *
         * @deprecated Deprecated in Version 9 of ui_provider. Will be removed in Version 10
         */
        if($versionNumberUtility::convertVersionNumberToInteger($versionNumberUtility::getNumericTypo3Version()) < $versionNumberUtility::convertVersionNumberToInteger('10')) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\Page\PageRenderer::class] = array(
                'className' => \UI\UiProvider\Xclass\TYPO3\CMS\Core\Page\PageRenderer::class
            );
        }

        /**
         * Xclass to fix an issue with workspaces previews.
         * See https://forge.typo3.org/issues/82462 for further details
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Core\DataHandling\DataHandler::class] = array(
            'className' => \UI\UiProvider\Xclass\TYPO3\CMS\Core\DataHandling\DataHandler::class
        );

        /**
         * Xclasses to allow splitting of mask.json file
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\MASK\Mask\Domain\Repository\StorageRepository::class] = [
            'className' => \UI\UiProvider\Xclass\MASK\Mask\Domain\Repository\StorageRepository::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\IchHabRecht\MaskExport\Aggregate\ExtensionConfigurationAggregate::class] = [
            'className' => \UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate\ExtensionConfigurationAggregate::class
        ];
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\IchHabRecht\MaskExport\Aggregate\TcaAggregate::class] = [
            'className' => \UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate\TcaAggregate::class
        ];

        /**
         * Xclass to adjust file paths for Layouts and Templates. These are "Namespaced" in the u+i Blueprint Naming scheme!
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\EBT\ExtensionBuilder\Domain\Repository\ExtensionRepository::class] = [
            'className' => \UI\UiProvider\Xclass\EBT\ExtensionBuilder\Domain\Repository\ExtensionRepository::class
        ];
    }
);