<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        /**
         * Default PageTsConfig
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:ui_sitepackage/Configuration/PageTSconfig/" extensions="typoscript">');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:ui_sitepackage/Configuration/BackendLayouts/" extensions="typoscript">');

        /**
         * Register RTE preset config to use with CKEditor
         */
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['Default'] = 'EXT:ui_sitepackage/Configuration/RTE/Default.yaml';
    }
);