<?php
/**
 * Global TYPO3 configuration
 **/
$globalConfiguration = [
    'BE' => [
        'debug' => false,
        'explicitADmode' => 'explicitAllow',
        'loginSecurityLevel' => 'rsa',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'driver' => 'mysqli',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'extension_builder' => serialize([
                'enableRoundtrip' => '1',
                'backupExtension' => '0',
                'backupDir' => 'uploads/tx_extensionbuilder/backups',
            ]),
            'mask' => serialize([
                'json' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/mask.json',
                'content' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/',
                'preview' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Preview/',
                'backend' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Backend/',
            ]),
            'mask_export' => serialize([
                'maskConfiguration' => '0',
                'backendPreview' => '1',
                'contentElementIcons' => '1',
            ]),
            'backend' => serialize([
                'loginBackgroundImage' => 'typo3conf/ext/ui_sitepackage/Resources/Public/Backend/LoginBackground.jpg',
                'backendFavicon' => 'typo3conf/ext/ui_sitepackage/Resources/Public/Backend/favicon.ico',
                'backendLogo' => 'typo3conf/ext/ui_sitepackage/Resources/Public/Backend/TopBarLogo@2x.png',
            ]),
            'realurl' => serialize([
                'configFile' => 'typo3conf/realurl_conf.php',
                'enableAutoConf' => '1',
                'autoConfFormat' => '0',
                'segTitleFieldList' => '',
                'enableDevLog' => '0',
                'moduleIcon' => '0',
            ]),
        ],
    ],
    'FE' => [
        'debug' => false,
        'loginSecurityLevel' => 'rsa',
        'disableNoCacheParameter' => TRUE,
        'hidePagesIfNotTranslatedByDefault' => TRUE,
        'pageNotFoundOnCHashError' => true,
    ],
    'GFX' => [
        'jpg_quality' => '80',
        'processor' => 'ImageMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'sRGB',
        'processor_effects' => 1,
        'processor_enabled' => true,
        'processor_path' => '/usr/local/bin/',
        'processor_path_lzw' => '/usr/local/bin/',
    ],
    'MAIL' => [
        'transport' => 'mbox',
        'transport_mbox_file' => 'mbox.txt',
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'extbase_object' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
                    'groups' => [
                        'system',
                    ],
                    'options' => [
                        'defaultLifetime' => 0,
                    ],
                ],
            ],
        ],
        'devIPmask' => '',
        'displayErrors' => 0,
        'enableDeprecationLog' => false,
        'exceptionalErrors' => 20480,
        'isInitialDatabaseImportDone' => true,
        'isInitialInstallationInProgress' => false,
        //'sitename' => 'u+i Blueprint' . ' [' . $currentApplicationContext . ']',
        'sqlDebug' => 0,
        'systemLogLevel' => 2,
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$globalConfiguration);
