<?php
namespace UI\UiProvider\Xclass\TYPO3\CMS\Core\Page;

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
 * PageRenderer
 */
class PageRenderer extends \TYPO3\CMS\Core\Page\PageRenderer
{
    /**
     * Replaces meta data
     *
     * @param string $pattern Pattern to match meta items
     * @param string $meta Meta data (complete metatag)
     *
     * @deprecated Deprecated in Version 9 of ui_provider. Will be removed in Version 10
     */
    public function replaceMetaTag($pattern = null, $meta)
    {
        if($pattern) {
            $matches = preg_grep($pattern, $this->metaTags);

            if(count($matches) > 0) {
                foreach($matches as $key => $match) {
                    $this->metaTags[$key] = $meta;
                }
            } else {
                $this->addMetaTag($meta);
            }
        }
    }
}
