<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        /**
         * Allow more than 20 Subgroups
         */
        $GLOBALS['TCA']['be_groups']['columns']['subgroup']['config']['maxitems'] = 9999;

    },
    'ui_provider'
);
