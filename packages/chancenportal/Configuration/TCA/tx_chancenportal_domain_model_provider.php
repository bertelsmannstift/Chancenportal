<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,slug,subline,short_description,long_description,street,city,email,website,contact_name,contact_jurisdiction,contact_phone,contact_email,phone,phone2,opening_hours,zip,address,lat,lng,content_image_copyright',
        'iconfile' => 'EXT:chancenportal/Resources/Public/Icons/tx_chancenportal_domain_model_provider.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, slug, subline, short_description, long_description, number_of_employees, participation, content_image, logo, street, city, email, website, contact_salutation, contact_name, contact_jurisdiction, contact_phone, contact_email, contact_image, phone, phone2, opening_hours, active, zip, address, lat, lng, approved, reminder_email_send, content_image_copyright, labels, offers, owner_group, carrier, categories, creator, author',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, slug, subline, short_description, long_description, number_of_employees, participation, content_image, logo, street, city, email, website, contact_salutation, contact_name, contact_jurisdiction, contact_phone, contact_email, contact_image, phone, phone2, opening_hours, active, zip, address, lat, lng, approved, reminder_email_send, content_image_copyright, labels, offers, owner_group, carrier, categories, creator, author, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_chancenportal_domain_model_provider',
                'foreign_table_where' => 'AND {#tx_chancenportal_domain_model_provider}.{#pid}=###CURRENT_PID### AND {#tx_chancenportal_domain_model_provider}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.slug',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'subline' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.subline',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'short_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.short_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'long_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.long_description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'number_of_employees' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.number_of_employees',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'participation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.participation',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'content_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.content_image',
            'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'content_image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 2
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'logo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.logo',
            'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'logo',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 2
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'website' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.website',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_salutation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_salutation',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-- Label --', 0],
                ],
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'contact_name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_jurisdiction' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_jurisdiction',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.contact_image',
            'config' =>
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'contact_image',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ]
                    ],
                    'maxitems' => 2
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'phone2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.phone2',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'opening_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.opening_hours',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.active',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.zip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'lat' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.lat',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'lng' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.lng',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'approved' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.approved',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'reminder_email_send' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.reminder_email_send',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'content_image_copyright' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.content_image_copyright',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'labels' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.labels',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_chancenportal_domain_model_label',
                'foreign_field' => 'provider',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'offers' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.offers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_chancenportal_domain_model_offer',
                'foreign_field' => 'provider',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'owner_group' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.owner_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_groups',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'carrier' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.carrier',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_chancenportal_domain_model_carrier',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_chancenportal_domain_model_category',
                'MM' => 'tx_chancenportal_provider_category_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
            ],

        ],
        'creator' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.creator',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'author' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_provider.author',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

    ],
];
