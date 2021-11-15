<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/***************
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ui_ce_overrides', 'Configuration/TypoScript', 'u+i Content Elements (Overrides)');
