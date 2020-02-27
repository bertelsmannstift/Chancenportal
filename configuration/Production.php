<?php
/**
 * CLIENT.kundenpreview.de
 * Production/Stage environment
 * SetEnv TYPO3_CONTEXT Production/Stage
 **/

$environmentConfiguration = array(
    'GFX' => array(
        'image_processing' => '1',
        'im' => '1',
        'processor' => 'GraphicsMagick',
        'im_path' => '/usr/bin/',
        'im_path_lzw' => '/usr/bin/',
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
        'im_version_5' => 'im6',
        'im_v5effects' => '1',
        'im_mask_temp_ext_gif' => '0',
        'colorspace' => 'sRGB',
    ),

    'MAIL' => [
        'transport_sendmail_command' => '/usr/sbin/sendmail -t -i ',
        'transport' => 'smtp',
        'transport_mbox_file' => '',
        'defaultMailFromAddress' => '',
        'defaultMailFromName' => ''
    ],

    'SYS' => array(
        'displayErrors' => '0',
        'devIPmask' => '',
        'systemLogLevel' => '2',
        'systemLog' => 'file,../TYPO3_systemlog.log',
        'enable_errorDLOG' => '0',
        'enable_exceptionDLOG' => '0',
        'syslogErrorReporting' => E_ALL ^ E_NOTICE ^ E_WARNING,
        'belogErrorReporting' => '0',
        'enableDeprecationLog' => '',
    ),
);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$environmentConfiguration);
