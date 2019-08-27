<?php
return [
    'BE' => [
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => '$pbkdf2-sha256$25000$QjyiDVFv1pa6r4kio1zvIA$svNa46NUWO7t38ZeEpoLKsvxBsagzcFx57uRSLy/fBU',
        'loginSecurityLevel' => 'rsa',
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
            'about' => 'a:0:{}',
            'chancenportal' => 'a:0:{}',
            'extensionmanager' => 'a:2:{s:21:"automaticInstallation";s:1:"1";s:11:"offlineMode";s:1:"0";}',
            'flux' => 'a:4:{s:9:"debugMode";s:1:"0";s:7:"compact";s:1:"0";s:17:"listNestedContent";s:1:"0";s:12:"handleErrors";s:1:"0";}',
            'mask' => 'a:9:{s:4:"json";s:71:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/mask.json";s:18:"backendlayout_pids";s:3:"0,1";s:7:"content";s:70:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Content/";s:7:"layouts";s:36:"fileadmin/templates/content/Layouts/";s:8:"partials";s:37:"fileadmin/templates/content/Partials/";s:7:"backend";s:70:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Backend/";s:15:"layouts_backend";s:36:"fileadmin/templates/backend/Layouts/";s:16:"partials_backend";s:37:"fileadmin/templates/backend/Partials/";s:7:"preview";s:70:"typo3conf/ext/ui_sitepackage/Resources/Private/Templates/Mask/Preview/";}',
            'mask_export' => 'a:3:{s:17:"maskConfiguration";s:1:"0";s:14:"backendPreview";s:1:"1";s:19:"contentElementIcons";s:1:"1";}',
            'pagenotfoundhandling' => 'a:21:{s:14:"default404Page";s:2:"25";s:19:"defaultTemplateFile";s:65:"EXT:pagenotfoundhandling/Resources/Private/Templates/default.html";s:22:"additional404GetParams";s:0:"";s:14:"default403Page";s:2:"22";s:22:"default403TemplateFile";s:0:"";s:22:"additional403GetParams";s:0:"";s:23:"absoluteReferencePrefix";s:0:"";s:19:"disableDomainConfig";s:1:"0";s:19:"preserveFeuserLogin";s:1:"0";s:16:"debugGetUrlError";s:1:"0";s:14:"requestTimeout";s:2:"10";s:16:"default403Header";s:1:"4";s:28:"passthroughContentTypeHeader";s:1:"0";s:23:"sendXForwardedForHeader";s:1:"0";s:17:"additionalHeaders";s:0:"";s:20:"digestAuthentication";s:0:"";s:14:"ignoreLanguage";s:1:"0";s:13:"forceLanguage";s:1:"0";s:13:"locallangFile";s:0:"";s:18:"defaultLanguageKey";s:7:"default";s:13:"languageParam";s:1:"L";}',
            'realurl' => 'a:6:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"1";s:14:"autoConfFormat";s:1:"0";s:17:"segTitleFieldList";s:0:"";s:12:"enableDevLog";s:1:"0";s:10:"moduleIcon";s:1:"0";}',
            'recycler' => 'a:0:{}',
            'rsaauth' => 'a:1:{s:18:"temporaryDirectory";s:0:"";}',
            'rte_ckeditor' => 'a:1:{s:15:"ckeditorVersion";s:1:"1";}',
            'saltedpasswords' => 'a:2:{s:3:"BE.";a:4:{s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\Pbkdf2Salt";s:11:"forceSalted";i:0;s:15:"onlyAuthService";i:0;s:12:"updatePasswd";i:1;}s:3:"FE.";a:5:{s:7:"enabled";i:1;s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\Pbkdf2Salt";s:11:"forceSalted";i:0;s:15:"onlyAuthService";i:0;s:12:"updatePasswd";i:1;}}',
            'scheduler' => 'a:4:{s:11:"maxLifetime";s:4:"1440";s:11:"enableBELog";s:1:"1";s:15:"showSampleTasks";s:1:"1";s:11:"useAtdaemon";s:1:"0";}',
            'ui_ce' => 'a:0:{}',
            'ui_ce_overrides' => 'a:0:{}',
            'ui_forms' => 'a:0:{}',
            'ui_grid' => 'a:0:{}',
            'ui_provider' => 'a:0:{}',
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
    'FE' => [
        'loginSecurityLevel' => 'rsa',
    ],
    'GFX' => [
        'jpg_quality' => 90,
    ],
    'SYS' => [
        'displayErrors' => 1,
        'encryptionKey' => '2442f5bde9833f8f8a872191edff517a92d5261867a41e7d0d8a2da429220296d3031495fe932d5a88415adb490ee73c',
        'isInitialDatabaseImportDone' => true,
        'isInitialInstallationInProgress' => false,
        'sitename' => 'Chancenportal',
    ],
];
