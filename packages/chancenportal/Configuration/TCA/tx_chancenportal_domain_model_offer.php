<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer',
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
        'searchFields' => 'name,slug,address,lat,lng,info,short_description,long_description,speaker,youtube,conditions_of_participation,course_number,allowed_participants,costs,participate,donate,provider_cooperation,format,contact_name,contact_jurisdiction,contact_phone,contact_email,zip,city,street,images_copyright,content_image_copyright,opening_hours',
        'iconfile' => 'EXT:chancenportal/Resources/Public/Icons/tx_chancenportal_domain_model_offer.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, slug, address, lat, lng, info, short_description, long_description, speaker, images, youtube, conditions_of_participation, course_number, allowed_participants, costs, all_ages, access, accessibility, participate, donate, provider_cooperation, format, no_costs, contact_salutation, contact_name, contact_jurisdiction, contact_phone, contact_email, contact_image, active, content_image, active_date, zip, city, street, approved, date_type, start_date, end_date, reminder_email_send, images_copyright, content_image_copyright, participation, opening_hours, dates, target_groups, categories, district, creator, last_editor',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, slug, address, lat, lng, info, short_description, long_description, speaker, images, youtube, conditions_of_participation, course_number, allowed_participants, costs, all_ages, access, accessibility, participate, donate, provider_cooperation, format, no_costs, contact_salutation, contact_name, contact_jurisdiction, contact_phone, contact_email, contact_image, active, content_image, active_date, zip, city, street, approved, date_type, start_date, end_date, reminder_email_send, images_copyright, content_image_copyright, participation, opening_hours, dates, target_groups, categories, district, creator, last_editor, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_chancenportal_domain_model_offer',
                'foreign_table_where' => 'AND {#tx_chancenportal_domain_model_offer}.{#pid}=###CURRENT_PID### AND {#tx_chancenportal_domain_model_offer}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
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
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.slug',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'lat' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.lat',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'lng' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.lng',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'info' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.info',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'short_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.short_description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'long_description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.long_description',
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
        'speaker' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.speaker',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.images',
            'config' => 
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'images',
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
                    'maxitems' => 3
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'youtube' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.youtube',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'conditions_of_participation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.conditions_of_participation',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'course_number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.course_number',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'allowed_participants' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.allowed_participants',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'costs' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.costs',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'all_ages' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.all_ages',
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
        'access' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.access',
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
        'accessibility' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.accessibility',
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
        'participate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.participate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'donate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.donate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'provider_cooperation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.provider_cooperation',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'format' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.format',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'no_costs' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.no_costs',
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
        'contact_salutation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_salutation',
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
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_jurisdiction' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_jurisdiction',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.contact_image',
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
        'active' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.active',
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
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.content_image',
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
        'active_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.active_date',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'datetime',
                'default' => null,
            ],
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.zip',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.city',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.street',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'approved' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.approved',
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
        'date_type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.date_type',
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
        'start_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.start_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'end_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.end_date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'reminder_email_send' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.reminder_email_send',
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
        'images_copyright' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.images_copyright',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'content_image_copyright' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.content_image_copyright',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'participation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.participation',
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
        'opening_hours' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.opening_hours',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'dates' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.dates',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_chancenportal_domain_model_date',
                'foreign_field' => 'offer',
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
        'target_groups' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.target_groups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_chancenportal_domain_model_targetgroup',
                'MM' => 'tx_chancenportal_offer_targetgroup_mm',
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
        'categories' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_chancenportal_domain_model_category',
                'MM' => 'tx_chancenportal_offer_category_mm',
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
        'district' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.district',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_chancenportal_domain_model_district',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'creator' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.creator',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'last_editor' => [
            'exclude' => true,
            'label' => 'LLL:EXT:chancenportal/Resources/Private/Language/locallang_db.xlf:tx_chancenportal_domain_model_offer.last_editor',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    
        'provider' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
