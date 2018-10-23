<?php
defined('TYPO3_MODE') || die('Access denied.');

/**
 * Allow more than 20 Subgroups
 */
$GLOBALS['TCA']['be_groups']['columns']['subgroup']['config']['maxitems'] = 9999;
