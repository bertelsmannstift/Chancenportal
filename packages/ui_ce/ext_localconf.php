<?php
// Register content element icons
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'tx_uice_addtohomescreen',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'mobile-phone',
    ]
);
$iconRegistry->registerIcon(
    'tx_uice_kachel_teaser',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'image',
    ]
);
$iconRegistry->registerIcon(
    'tx_uice_text_btn',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'align-justify',
    ]
);
$iconRegistry->registerIcon(
    'tx_uice_text_image',
    \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
    [
        'name' => 'address-card-o',
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ui_ce/Configuration/PageTSconfig/NewContentElementWizard.ts">'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ui_ce/Configuration/PageTSconfig/BackendPreview.ts">'
);
// Add backend preview hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['ui_ce'] = 
    UICE\UiCe\Hooks\PageLayoutViewDrawItem::class;
