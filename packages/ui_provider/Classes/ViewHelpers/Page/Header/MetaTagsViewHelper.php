<?php
namespace UI\UiProvider\ViewHelpers\Page\Header;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use UI\UiProvider\Service\MetaTagService;

/**
 * Class MetaTagsViewHelper
 * @package UI\UiProvider\ViewHelpers\Page\Header
 *
 * Add an array of meta tags to the rendered output. Overwrites tags set via page properties!
 *
 * Usage
 * -----
 * <html xmlns:uandi="http://typo3.org/ns/UI/UiProvider/ViewHelpers" data-namespace-typo3-fluid="true">
 *     <uandi:page.header.metaTags tags="{
 *         'canonical': 'https://www.uandi.com',
 *         'twitter:title': 'Lorem ispum dolor',
 *         'twitter:description': 'Lorem ispum dolor'
 *     }" />
 * </html>
 */
class MetaTagsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Arguments initialization
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('tags', 'array', 'Array of meta tags to be added');
    }

    /**
     * Render method
     *
     * @return void
     */
    public function render()
    {
        if(is_array($this->arguments['tags'])) {
            $metaTagService = GeneralUtility::makeInstance(ObjectManager::class)->get(MetaTagService::class);
            $metaTagService->addMetaTags($this->arguments['tags']);
        }
    }
}