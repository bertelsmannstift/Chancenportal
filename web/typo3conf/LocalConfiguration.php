<?php
return [
    'BE' => [
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => '$pbkdf2-sha256$25000$yEm0bWwhL.9okNLTrX2EMQ$cyk53bjddGZly.o98xeJE3NKFZoQaG4dA3.rIY.tj34',
        'loginSecurityLevel' => 'normal',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'db',
                'driver' => 'mysqli',
                'host' => 'db',
                'password' => 'db',
                'port' => '3306',
                'user' => 'db',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'backend' => 'a:6:{s:9:"loginLogo";s:0:"";s:19:"loginHighlightColor";s:0:"";s:20:"loginBackgroundImage";s:0:"";s:13:"loginFootnote";s:0:"";s:11:"backendLogo";s:0:"";s:14:"backendFavicon";s:0:"";}',
            'extension_builder' => 'a:3:{s:15:"enableRoundtrip";s:1:"1";s:15:"backupExtension";s:1:"1";s:9:"backupDir";s:35:"uploads/tx_extensionbuilder/backups";}',
            'extensionmanager' => 'a:2:{s:21:"automaticInstallation";s:1:"1";s:11:"offlineMode";s:1:"0";}',
            'flux' => 'a:3:{s:9:"debugMode";s:1:"0";s:7:"compact";s:1:"0";s:12:"handleErrors";s:1:"0";}',
            'mask' => 'a:9:{s:4:"json";s:71:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/mask.json";s:18:"backendlayout_pids";s:3:"0,1";s:7:"content";s:70:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/";s:7:"layouts";s:70:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Layouts/";s:8:"partials";s:71:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Partials/";s:7:"backend";s:88:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Templates/";s:15:"layouts_backend";s:86:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Layouts/";s:16:"partials_backend";s:87:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Partials/";s:7:"preview";s:85:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Images/";}',
            'scheduler' => 'a:2:{s:11:"maxLifetime";s:4:"1440";s:15:"showSampleTasks";s:1:"1";}',
            'vhs' => 'a:1:{s:20:"disableAssetHandling";s:1:"0";}',
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginBackgroundImage' => '',
            'loginFootnote' => '',
            'loginHighlightColor' => '',
            'loginLogo' => '',
        ],
        'extension_builder' => [
            'backupDir' => 'uploads/tx_extensionbuilder/backups',
            'backupExtension' => '1',
            'enableRoundtrip' => '1',
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
        'flux' => [
            'compact' => '0',
            'debugMode' => '0',
            'handleErrors' => '0',
        ],
        'mask' => [
            'backend' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Templates/',
            'backendlayout_pids' => '0,1',
            'content' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/',
            'json' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/mask.json',
            'layouts' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Layouts/',
            'layouts_backend' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Layouts/',
            'partials' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Partials/',
            'partials_backend' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Partials/',
            'preview' => 'typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/Backend/Images/',
        ],
        'scheduler' => [
            'maxLifetime' => '1440',
            'showSampleTasks' => '1',
        ],
        'vhs' => [
            'disableAssetHandling' => '0',
        ],
    ],
    'FE' => [
        'debug' => '',
        'loginSecurityLevel' => 'normal',
    ],
    'GFX' => [
        'jpg_quality' => 90,
        'processor' => 'ImageMagick',
        'processor_allowTemporaryMasksAsPng' => '',
        'processor_colorspace' => 'RGB',
        'processor_effects' => false,
        'processor_enabled' => '1',
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'MAIL' => [
        'transport' => 'mail',
        'transport_sendmail_command' => '',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => 'localhost:25',
        'transport_smtp_username' => '',
    ],
    'SYS' => [
        'devIPmask' => '127.0.0.1,::1',
        'displayErrors' => '1',
        'encryptionKey' => '2442f5bde9833f8f8a872191edff517a92d5261867a41e7d0d8a2da429220296d3031495fe932d5a88415adb490ee73c',
        'sitename' => 'Chancenportal',
        'systemLogLevel' => '0',
        'trustedHostsPattern' => '.*',
    ],
];
