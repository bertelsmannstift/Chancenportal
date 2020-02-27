<?php
namespace UI\UiProvider\ViewHelpers\Page\Header;

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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CanonicalTagViewHelper
 * @package UI\UiProvider\ViewHelpers\Page\Header
 * @deprecated Deprecated in Version 9 of ui_provider. Will be removed in Version 10
 *
 * Adds or replaces a canonical tag
 */
class CanonicalTagViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        $this->registerArgument('url', 'string', '', true);
    }

    /**
     * @param string $url
     * @return void
     */
    public function render() {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->replaceMetaTag("/.*rel=\"canonical\".*/", '<link rel="canonical" href="'.$this->arguments['url'].'" />');
    }
}