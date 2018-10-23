<?php
defined('TYPO3_MODE') || die('Access denied.');


call_user_func(
    function ($extKey) {
        /**
         * Add custom TCA columns
         */
        $columns = [

            /**
             * Add Site Title
             */
            $extKey.'_site_logo' => [
                'displayCond' => 'USER:Chancenportal\\Chancenportal\\User\\TcaConditions->matchPageType',
                'exclude' => true,
                'label' => 'LLL:EXT:'.$extKey.'/Resources/Private/Language/locallang_db.xlf:pages.'.$extKey.'_site_logo',
                'config' =>
                    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                        $extKey.'_site_logo',
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
                                \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                    'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                                ]
                            ],
                            'maxitems' => 1
                        ],
                        $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
                    ),
            ],
        ];
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $columns);

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
            'pages',
            '--div--;LLL:EXT:'.$extKey.'/Resources/Private/Language/locallang_db.xlf:pages.tabs.'.$extKey.'_settings,
                '.$extKey.'_site_logo
            ',
            '1',
            'after:--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial'
        );
    },
    'ui_sitepackage'
);
