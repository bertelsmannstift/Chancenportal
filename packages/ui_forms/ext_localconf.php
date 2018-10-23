<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        /**
         * Xclass to extend Confirmation Finisher
         */
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Form\\Domain\\Finishers\\ConfirmationFinisher'] = array(
            'className' => 'UI\\UiForms\\Xclass\\Finishers\\ConfirmationFinisher'
        );
    }
);