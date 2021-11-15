<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/**
 * Default PageTsConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="DIR:EXT:ui_ce_overrides/Configuration/PageTSconfig/" extensions="typoscript">');
