<?php
namespace UI\UiProvider\ViewHelpers\Page\Header;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CanonicalTagViewHelper
 * @package UI\UiGmh\ViewHelpers\Page\Header
 *
 * Adds or replaces a canonical tag
 */
class CanonicalTagViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * @param string $url
     * @return void
     */
    public function render($url = null) {
        if($url) {
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->replaceMetaTag("/.*rel=\"canonical\".*/", '<link rel="canonical" href="'.$url.'" />');
        }
    }
}