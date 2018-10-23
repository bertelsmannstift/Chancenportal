<?php
namespace UI\UiProvider\ViewHelpers;

class CreateUrlSlugViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $string
     * @return string
     */
    public function render($string = null) {
        if ($string === null) {
            $string = $this->renderChildren();
        }

        return \UI\UiProvider\Utility\GeneralUtility::createUrlSlug($string);
    }
}
