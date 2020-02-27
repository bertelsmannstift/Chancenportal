<?php
namespace UI\UiProvider\Service;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class MetaTagService
 * @package UI\UiProvider\Service
 *
 * Helper service to quickly add/remove meta tags to/from rendered html output
 */
class MetaTagService implements SingletonInterface
{
    /**
     * @var object|MetaTagManagerRegistry
     */
    protected $metaTagManagerRegistry;

    public function __construct()
    {
        $this->metaTagManagerRegistry = GeneralUtility::makeInstance(MetaTagManagerRegistry::class);
    }

    /**
     * Add an array of meta tags to the rendered output. Overwrites tags set via page properties!
     *
     * @param array $tags
     *
     * Usage
     * -----
     * $metaTagService = GeneralUtility::makeInstance(ObjectManager::class)->get(MetaTagService::class);
     * $metaTagService->addMetaTags([
     *     'canonical' => 'https://www.uandi.com',
     *     'twitter:title' => 'Lorem ispum dolor',
     *     'twitter:description' => 'Lorem ispum dolor'
     * ]);
     */
    public function addMetaTags($tags = [])
    {
        foreach($tags as $name => $content) {
            if($name === 'canonical') {
                $GLOBALS['TSFE']->page['canonical_link'] = $content;
                continue;
            }

            $subProperties = [];
            if(is_array($content) && !empty($content['content'])) {
                $content = $content['content'];

                if(is_array($content['subProperties'])) {
                    $subProperties = $content['subProperties'];
                }
            }

            if(is_string($content)) {
                $metaTagManager = $this->metaTagManagerRegistry->getManagerForProperty($name);
                $metaTagManager->addProperty($name, $content, $subProperties);
            }
        }
    }

    /**
     * Remove the defined meta tags from the rendered output. Does not remove tags set via page properties!
     *
     * @param array $tags
     *
     * Usage
     * -----
     * $metaTagService = GeneralUtility::makeInstance(ObjectManager::class)->get(MetaTagService::class);
     * $metaTagService->removeMetaTags(['twitter:title', 'twitter:description']);
     */
    public function removeMetaTags($tags = [])
    {
        foreach($tags as $name) {
            if(is_string($name)) {
                $metaTagManager = $this->metaTagManagerRegistry->getManagerForProperty($name);
                $metaTagManager->removeProperty($name);
            }
        }
    }
}