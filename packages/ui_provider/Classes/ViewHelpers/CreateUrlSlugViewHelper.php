<?php
namespace UI\UiProvider\ViewHelpers;

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

/**
 * Class CreateUrlSlugViewHelper
 * @package UI\UiProvider\ViewHelpers
 *
 * Create a slug from string input. Uses the same methods the TYPO3 url slug generator uses.
 *
 * Usage
 * -----
 * <html xmlns:uandi="http://typo3.org/ns/UI/UiProvider/ViewHelpers" data-namespace-typo3-fluid="true">
 *     <uandi:createUrlSlug string="Lorem ipsum dolor" />
 *     {uandi:createUrlSlug(string: 'Lorem ipsum dolor')}
 * </html>
 */
class CreateUrlSlugViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', '');
    }

    /**
     * @return string
     */
    public function render() {
        if ($this->arguments['string'] === null) {
            $this->arguments['string'] = $this->renderChildren();
        }

        return \UI\UiProvider\Utility\GeneralUtility::createUrlSlug($this->arguments['string']);
    }
}
