<?php
namespace UI\UiProvider\Utility;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Routing\SiteMatcher;
use TYPO3\CMS\Core\Site\Entity\SiteInterface;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * GeneralUtility
 */
class GeneralUtility extends \TYPO3\CMS\Core\Utility\GeneralUtility
{
    /**
     * Get Image TCA Config with Custom Crop Variants
     *
     * @param string $fieldName
     * @param string $fileExtensions
     * @param int $minItems
     * @param int $maxItems
     * @param null $cropVariants
     * @return array
     *
     * Usage
     * -----
     * GeneralUtility::getImageFieldTCAConfig('field_name', 'svg', 0, 9999, [
     *      'desktop' => [
     *          '16_9' => 16 / 9,
     *          'NaN' => 0,
     *      ],
     *      'mobile' => [
     *          '4_3' => 4 / 3,
     *      ],
     * ]);
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

        $config = array_replace_recursive($config, [
            'appearance' => [
                'collapseAll' => '1',
                'expandSingle' => '1'
            ]
        ]);

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
                $title = LocalizationUtility::translate('LLL:EXT:ui_provider/Resources/Private/Language/locallang_ImageManipulation.xlf:cropVariants.' . $cropVariantKey);
                if(!$title) {
                    $title = ucfirst(strtolower($cropVariantKey));
                }

                $config['overrideChildTca']['columns']['crop']['config']['cropVariants'][$cropVariantKey] = [
                    'title' => $title,
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
                    $title = LocalizationUtility::translate('LLL:EXT:ui_provider/Resources/Private/Language/locallang_ImageManipulation.xlf:cropVariants.aspectRatios.' . $aspectRatioKey);
                    if(!$title) {
                        $title = str_replace('_', ':', $aspectRatioKey);
                    }

                    $config['overrideChildTca']['columns']['crop']['config']['cropVariants'][$cropVariantKey]['allowedAspectRatios'][$aspectRatioKey] = [
                        'title' => $title,
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
     *
     * Usage
     * -----
     * GeneralUtility::getPageLayout(123);
     */
    public static function getPageLayout($uid)
    {
        $pageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(PageRepository::class);
        $page = $pageRepository->getPage_noCheck($uid);

        if($page['backend_layout'] !== '') {
            return $page['backend_layout'];
        } else {
            $rootline = GeneralUtility::makeInstance(RootlineUtility::class, $uid)->get();

            foreach ($rootline as $rootlineItem) {
                if($rootlineItem['backend_layout_next_level'] !== '') {
                    return $rootlineItem['backend_layout_next_level'];
                }
            }
        }

        return '';
    }

    /**
     * Create a slug from string input. Uses the same methods the TYPO3 url slug generator uses.
     *
     * @param $title
     * @return string
     *
     * Usage
     * -----
     * GeneralUtility::createUrlSlug('Lorem ipsum dolor');
     */
    public static function createUrlSlug($title)
    {
        if(is_string($title)) {
            $slugHelper = GeneralUtility::makeInstance(SlugHelper::class, '', '', []);
            return str_replace('/', '', $slugHelper->sanitize($title));
        }

        return '';
    }

    /**
     * Get an array containing all subtree ids
     *
     * Use different getTreeList methods for FE and BE because FE method caches results in DB but does not work in BE-Mode.
     *
     * @param $uid
     * @param int $recursive
     * @return array
     */
    public static function getTreeUidArray($uid, $recursive = 255)
    {
        if (TYPO3_MODE === 'FE') {
            $contentObjectRenderer = self::makeInstance(ContentObjectRenderer::class);
            $ids = $contentObjectRenderer->getTreeList($uid, $recursive, 0);
        } else {
            $queryGenerator = self::makeInstance(QueryGenerator::class);
            $ids = $queryGenerator->getTreeList($uid, $recursive, 0, '');
        }

        return array_unique(array_merge((array) $uid, self::intExplode(',', $ids, true)));
    }

    /**
     * @param int $uid
     * @return SiteInterface|null
     */
    public static function getSiteByUid($uid = 0)
    {
        $matcher = GeneralUtility::makeInstance(SiteMatcher::class);

        try {
            $site = $matcher->matchByPageId((int)$uid);
        } catch (SiteNotFoundException $e) {
            $site = null;
        }
        return $site;
    }

    /**
     * @return SiteInterface|null
     */
    public static function getCurrentSite(): ?SiteInterface
    {

        if ($GLOBALS['TYPO3_REQUEST'] instanceof ServerRequestInterface) {
            return $GLOBALS['TYPO3_REQUEST']->getAttribute('site', null);
        }
        if (MathUtility::canBeInterpretedAsInteger($GLOBALS['TSFE']->id) && $GLOBALS['TSFE']->id > 0) {
            $matcher = GeneralUtility::makeInstance(SiteMatcher::class);
            try {
                $site = $matcher->matchByPageId((int)$GLOBALS['TSFE']->id);
            } catch (SiteNotFoundException $e) {
                $site = null;
            }
            return $site;
        }
        return null;
    }
}