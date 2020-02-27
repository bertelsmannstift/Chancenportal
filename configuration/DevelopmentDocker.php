<?php
/**
 * CLIENT.de
 * Development environment
 * SetEnv TYPO3_CONTEXT Development
 **/

$environmentConfiguration = array(
    'GFX' => array(
        'image_processing' => '1',
        'im' => '1',
        'im_path' => '/usr/bin/',
        'im_path_lzw' => '/usr/bin/',
        'im_version_5' => 'im6',
        'im_v5effects' => '1',
        'im_mask_temp_ext_gif' => '0',
        'colorspace' => 'sRGB',
    ),
    'SYS' => array(
        'displayErrors' => '1',
        'devIPmask' => '*',
        'errorHandlerErrors' => 30466,
        'exceptionalErrors' => 20480,
        'systemLogLevel' => '0',
        'systemLog' => 'file,../TYPO3_systemlog.log',
        'enable_errorDLOG' => '1',
        'enable_exceptionDLOG' => '1',
        'enableDeprecationLog' => 'file',
    ),
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$environmentConfiguration);
