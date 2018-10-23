<?php
namespace UI\UiProvider\Utility;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * GeneralUtility
 */
class GeneralUtility
{
    /**
     * Get Image TCA Config with Custom Crop Variants
     *
     * Sample Call:
     * \UI\UiProvider\Utility\GeneralUtility::getImageFieldTCAConfig('field_name', 'svg', 0, 9999, [
     *      'desktop' => [
     *          '16_9' => 16 / 9,
     *          'NaN' => 0,
     *      ],
     *      'mobile' => [
     *          '4_3' => 4 / 3,
     *      ],
     * ]);
     *
     * @param string $fieldName
     * @param string $fileExtensions
     * @param int $minItems
     * @param int $maxItems
     * @param null $cropVariants
     * @return array
     */
    public static function getImageFieldTCAConfig($fieldName = '', $fileExtensions = '', $minItems = 0, $maxItems = 9999, $cropVariants = null, $addButtonLabel = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference')
    {
        if(empty($fileExtensions)) {
            $fileExtensions = $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'];
        }

        /**
         * Get default Typo3 FileField config
         */
        $config = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            $fieldName,
            [
                'appearance' => [
                    'createNewRelationLinkTitle' => $addButtonLabel
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
                'minitems' => $minItems,
                'maxitems' => $maxItems,
            ],
            $fileExtensions
        );

        /**
         * Define custom CropVariants or disable ImageManipulation
         */
        if(is_array($cropVariants)) {
            $config['overrideChildTca']['types'] = $config['foreign_types'];
            $config['overrideChildTca']['columns']['crop']['config'] = [
                'type' => 'imageManipulation',
                'cropVariants' => []
            ];

            /**
             * Create CropVariants
             */
            foreach($cropVariants as $cropVariantKey => $cropVariant) {
                $config['overrideChildTca']['columns']['crop']['config']['cropVariants'][$cropVariantKey] = [
                    'title' => 'LLL:EXT:ui_provider/Resources/Private/Language/locallang_ImageManipulation.xlf:cropVariants.' . $cropVariantKey,
                    'allowedAspectRatios' => [],
                    'focusArea' => [
                        'x' => 1 / 3,
                        'y' => 1 / 3,
                        'width' => 1 / 3,
                        'height' => 1 / 3,
                    ],
                ];

                /**
                 * Add AspectRatios to CropVariant
                 */
                foreach($cropVariant as $aspectRatioKey => $aspectRatio) {
                    $config['overrideChildTca']['columns']['crop']['config']['cropVariants'][$cropVariantKey]['allowedAspectRatios'][$aspectRatioKey] = [
                        'title' => 'LLL:EXT:ui_provider/Resources/Private/Language/locallang_ImageManipulation.xlf:cropVariants.aspectRatios.' . $aspectRatioKey,
                        'value' => $aspectRatio
                    ];
                }

                $config['overrideChildTca']['columns']['crop']['config']['cropVariants'][$cropVariantKey]['selectedRatio'] = array_keys($cropVariant)[0];
            }
        } else {
            $config['overrideChildTca']['columns']['crop'] = null;
        }

        return $config;
    }

    /**
     * Gets the page layout (backend layout) for the given uid
     *
     * @param $uid
     * @return string
     */
    public static function getPageLayout($uid)
    {
        $pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PageRepository::class);
        $page = $pageRepository->getPage_noCheck($uid);

        /** Respect Versioning */
        if(isset($page['t3ver_state']) && $page['t3ver_state'] === 1) {
            $sql  = $GLOBALS['TYPO3_DB']->exec_SELECTquery("uid", "pages", "t3ver_oid = " . $uid . " AND t3ver_state = -1");
            if($data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sql)) {
                $page = $pageRepository->getPage_noCheck($data['uid']);
            }
        }

        if($page['backend_layout'] !== '') {
            return $page['backend_layout'];
        } else {
            $rootline = $pageRepository->getRootLine($uid);

            foreach ($rootline as $rootlineItem) {
                if($rootlineItem['backend_layout_next_level'] !== '') {
                    return $rootlineItem['backend_layout_next_level'];
                }
            }
        }

        return '';
    }

    /**
     * Create Url Slug from string. If possible, use realurl encoding.
     *
     * @param $title
     * @param string $spaceCharacter
     * @param bool $strToLower
     * @return string
     */
    public static function createUrlSlug($title, $spaceCharacter = '-', $strToLower = true)
    {
        if(ExtensionManagementUtility::isLoaded('realurl')) {
            $realurlConfigurationReader = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\DmitryDulepov\Realurl\Configuration\ConfigurationReader::class, 0);
            $realurlUtility = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\DmitryDulepov\Realurl\Utility::class, $realurlConfigurationReader);

            return $realurlUtility->convertToSafeString($title, $spaceCharacter, $strToLower);
        } else {
            $processedTitle = strip_tags($title);
            $processedTitle = preg_replace('/[ \t\x{00A0}\-+_]+/u', $spaceCharacter, $processedTitle);
            $processedTitle = preg_replace('/[^\p{L}0-9' . preg_quote($spaceCharacter) . ']/u', '', $processedTitle);
            $processedTitle = preg_replace('/' . preg_quote($spaceCharacter) . '{2,}/', $spaceCharacter, $processedTitle);
            $processedTitle = trim($processedTitle, $spaceCharacter);

            if($strToLower) {
                $processedTitle = strtolower($processedTitle);
            }

            return $processedTitle;
        }
    }
}