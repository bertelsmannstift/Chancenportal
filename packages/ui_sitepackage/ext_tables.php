<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        /**
         * Default TypoScript
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ui_sitepackage', 'Configuration/TypoScript', 'u+i Sitepackage');

        /**
         * Custom BE Styles
         */
        $GLOBALS['TBE_STYLES']['skins']['ui_sitepackage'] = array (
            'name' => 'ui_sitepackage',
            'stylesheetDirectories' => array(
                'css' => 'EXT:ui_sitepackage/Resources/Public/assets_typo3_be/styles/'
            )
        );

    }
);