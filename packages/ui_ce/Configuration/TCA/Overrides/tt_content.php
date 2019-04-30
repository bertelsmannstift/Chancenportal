<?php
$tempColumns = array (
  'tx_uice_addtohomescreen_description_android' => 
  array (
    'config' => 
    array (
      'enableRichtext' => '1',
      'richtextConfiguration' => 'default',
      'type' => 'text',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_addtohomescreen_description_android',
  ),
  'tx_uice_addtohomescreen_description_ios' => 
  array (
    'config' => 
    array (
      'enableRichtext' => '1',
      'richtextConfiguration' => 'default',
      'type' => 'text',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_addtohomescreen_description_ios',
  ),
  'tx_uice_addtohomescreen_headline' => 
  array (
    'config' => 
    array (
      'type' => 'input',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_addtohomescreen_headline',
  ),
  'tx_uice_kachel_teaser_cat' => 
  array (
    'config' => 
    array (
      'max' => '100',
      'type' => 'input',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_kachel_teaser_cat',
  ),
  'tx_uice_kachel_teaser_headline' => 
  array (
    'config' => 
    array (
      'max' => '100',
      'type' => 'input',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_kachel_teaser_headline',
  ),
  'tx_uice_kachel_teaser_img' => 
  array (
    'config' => 
    array (
      'type' => 'inline',
      'foreign_table' => 'sys_file_reference',
      'foreign_field' => 'uid_foreign',
      'foreign_sortby' => 'sorting_foreign',
      'foreign_table_field' => 'tablenames',
      'foreign_match_fields' => 
      array (
        'fieldname' => 'tx_uice_kachel_teaser_img',
      ),
      'foreign_label' => 'uid_local',
      'foreign_selector' => 'uid_local',
      'overrideChildTca' => 
      array (
        'columns' => 
        array (
          'uid_local' => 
          array (
            'config' => 
            array (
              'appearance' => 
              array (
                'elementBrowserType' => 'file',
                'elementBrowserAllowed' => 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg',
              ),
            ),
          ),
        ),
        'types' => 
        array (
          0 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          1 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          2 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          3 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          4 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          5 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
        ),
      ),
      'filter' => 
      array (
        0 => 
        array (
          'userFunc' => 'TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter->filterInlineChildren',
        ),
      ),
      'appearance' => 
      array (
        'useSortable' => '1',
        'headerThumbnail' => 
        array (
          'field' => 'uid_local',
          'width' => '45',
          'height' => '45c',
        ),
        'enabledControls' => 
        array (
          'info' => 'tx_uice_kachel_teaser_img',
          'new' => false,
          'dragdrop' => 'tx_uice_kachel_teaser_img',
          'sort' => false,
          'hide' => 'tx_uice_kachel_teaser_img',
          'delete' => 'tx_uice_kachel_teaser_img',
        ),
        'collapseAll' => '1',
        'fileUploadAllowed' => '1',
      ),
      'behaviour' => 
      array (
        'localizeChildrenAtParentLocalization' => 'tx_uice_kachel_teaser_img',
      ),
      'maxitems' => '1',
      'minitems' => '1',
    ),
    'exclude' => '1',
    'l10n_mode' => 'copy',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_kachel_teaser_img',
  ),
  'tx_uice_kachel_teaser_link' => 
  array (
    'config' => 
    array (
      'fieldControl' => 
      array (
        'linkPopup' => 
        array (
          'options' => 
          array (
            'title' => 'Link',
            'windowOpenParameters' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
          ),
        ),
      ),
      'renderType' => 'inputLink',
      'softref' => 'typolink',
      'type' => 'input',
      'wizards' => 
      array (
        'link' => 
        array (
          'icon' => 'actions-wizard-link',
        ),
      ),
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_kachel_teaser_link',
  ),
  'tx_uice_kachel_teaser_text' => 
  array (
    'config' => 
    array (
      'max' => '200',
      'type' => 'text',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_kachel_teaser_text',
  ),
  'tx_uice_text_btn_headline' => 
  array (
    'config' => 
    array (
      'type' => 'input',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_btn_headline',
  ),
  'tx_uice_text_btn_link' => 
  array (
    'config' => 
    array (
      'fieldControl' => 
      array (
        'linkPopup' => 
        array (
          'options' => 
          array (
            'title' => 'Link',
            'windowOpenParameters' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
          ),
        ),
      ),
      'renderType' => 'inputLink',
      'softref' => 'typolink',
      'type' => 'input',
      'wizards' => 
      array (
        'link' => 
        array (
          'icon' => 'actions-wizard-link',
        ),
      ),
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_btn_link',
  ),
  'tx_uice_text_btn_texfield' => 
  array (
    'config' => 
    array (
      'enableRichtext' => '1',
      'richtextConfiguration' => 'default',
      'type' => 'text',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_btn_texfield',
  ),
  'tx_uice_text_btn_text' => 
  array (
    'config' => 
    array (
      'type' => 'input',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_btn_text',
  ),
  'tx_uice_text_image_align' => 
  array (
    'config' => 
    array (
      'items' => 
      array (
        0 => 
        array (
          0 => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_image_align.I.0',
          1 => '0',
        ),
        1 => 
        array (
          0 => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_image_align.I.1',
          1 => '1',
        ),
      ),
      'renderType' => 'selectSingle',
      'type' => 'select',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_image_align',
  ),
  'tx_uice_text_image_image' => 
  array (
    'config' => 
    array (
      'type' => 'inline',
      'foreign_table' => 'sys_file_reference',
      'foreign_field' => 'uid_foreign',
      'foreign_sortby' => 'sorting_foreign',
      'foreign_table_field' => 'tablenames',
      'foreign_match_fields' => 
      array (
        'fieldname' => 'tx_uice_text_image_image',
      ),
      'foreign_label' => 'uid_local',
      'foreign_selector' => 'uid_local',
      'overrideChildTca' => 
      array (
        'columns' => 
        array (
          'uid_local' => 
          array (
            'config' => 
            array (
              'appearance' => 
              array (
                'elementBrowserType' => 'file',
                'elementBrowserAllowed' => 'jpg,jpeg,png',
              ),
            ),
          ),
        ),
        'types' => 
        array (
          0 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          1 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          2 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          3 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          4 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
          5 => 
          array (
            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
          ),
        ),
      ),
      'filter' => 
      array (
        0 => 
        array (
          'userFunc' => 'TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter->filterInlineChildren',
          'parameters' => 
          array (
            'allowedFileExtensions' => 'jpg,jpeg,png',
          ),
        ),
      ),
      'appearance' => 
      array (
        'useSortable' => '1',
        'headerThumbnail' => 
        array (
          'field' => 'uid_local',
          'width' => '45',
          'height' => '45c',
        ),
        'enabledControls' => 
        array (
          'info' => 'tx_uice_text_image_image',
          'new' => false,
          'dragdrop' => 'tx_uice_text_image_image',
          'sort' => false,
          'hide' => 'tx_uice_text_image_image',
          'delete' => 'tx_uice_text_image_image',
        ),
        'collapseAll' => '1',
        'expandSingle' => '1',
        'fileUploadAllowed' => '1',
      ),
      'behaviour' => 
      array (
        'localizeChildrenAtParentLocalization' => 'tx_uice_text_image_image',
      ),
      'maxitems' => '1',
      'minitems' => '1',
    ),
    'exclude' => '1',
    'l10n_mode' => 'exclude',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_image_image',
  ),
  'tx_uice_text_image_text' => 
  array (
    'config' => 
    array (
      'enableRichtext' => '1',
      'richtextConfiguration' => 'default',
      'type' => 'text',
    ),
    'exclude' => '1',
    'label' => 'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.tx_uice_text_image_text',
  ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.CType.div._uice_',
    '--div--',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.CType.uice_addtohomescreen',
    'uice_addtohomescreen',
    'tx_uice_addtohomescreen',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.CType.uice_kachel_teaser',
    'uice_kachel_teaser',
    'tx_uice_kachel_teaser',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.CType.uice_text_btn',
    'uice_text_btn',
    'tx_uice_text_btn',
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:ui_ce/Resources/Private/Language/locallang_db.xlf:tt_content.CType.uice_text_image',
    'uice_text_image',
    'tx_uice_text_image',
];
$tempTypes = array (
  'uice_addtohomescreen' => 
  array (
    'columnsOverrides' => 
    array (
      'bodytext' => 
      array (
        'config' => 
        array (
          'richtextConfiguration' => 'default',
          'enableRichtext' => 1,
        ),
      ),
    ),
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,tx_uice_addtohomescreen_headline,tx_uice_addtohomescreen_description_ios,tx_uice_addtohomescreen_description_android,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,--div--;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tabs.relation,tx_flux_parent,tx_flux_column,tx_flux_children;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tx_flux_children',
  ),
  'uice_kachel_teaser' => 
  array (
    'columnsOverrides' => 
    array (
      'bodytext' => 
      array (
        'config' => 
        array (
          'richtextConfiguration' => 'default',
          'enableRichtext' => 1,
        ),
      ),
    ),
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,tx_uice_kachel_teaser_cat,tx_uice_kachel_teaser_headline,tx_uice_kachel_teaser_text,tx_uice_kachel_teaser_img,tx_uice_kachel_teaser_link,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,--div--;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tabs.relation,tx_flux_parent,tx_flux_column,tx_flux_children;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tx_flux_children',
  ),
  'uice_text_btn' => 
  array (
    'columnsOverrides' => 
    array (
      'bodytext' => 
      array (
        'config' => 
        array (
          'richtextConfiguration' => 'default',
          'enableRichtext' => 1,
        ),
      ),
    ),
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,tx_uice_text_btn_headline,tx_uice_text_btn_texfield,tx_uice_text_btn_text,tx_uice_text_btn_link,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,--div--;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tabs.relation,tx_flux_parent,tx_flux_column,tx_flux_children;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tx_flux_children',
  ),
  'uice_text_image' => 
  array (
    'columnsOverrides' => 
    array (
      'bodytext' => 
      array (
        'config' => 
        array (
          'richtextConfiguration' => 'default',
          'enableRichtext' => 1,
        ),
      ),
    ),
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,tx_uice_text_image_text,tx_uice_text_image_image,tx_uice_text_image_align,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,--div--;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tabs.relation,tx_flux_parent,tx_flux_column,tx_flux_children;LLL:EXT:flux/Resources/Private/Language/locallang.xlf:tt_content.tx_flux_children',
  ),
);
$GLOBALS['TCA']['tt_content']['types'] += $tempTypes;
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ui_ce',
    'Configuration/TypoScript/',
    'ui_ce'
);
