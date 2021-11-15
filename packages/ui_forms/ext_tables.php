<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/**
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('ui_forms', 'Configuration/TypoScript', 'u+i Forms');
