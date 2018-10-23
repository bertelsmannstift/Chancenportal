<?php
namespace UI\UiGrid\Xclass\Backend\View;

/***
 *
 * This file is part of the "u+i Grid" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * BackendLayoutView
 */
class BackendLayoutView extends \TYPO3\CMS\Backend\View\BackendLayoutView
{
    /**
     * Adds items to a colpos list
     *
     * This XCLASS function is used to keep Items with "colPos" 18181 in the $items array.
     * The default function would discard it, since 18181 is not defined in the BE Layout.
     *
     * @param int $pageId
     * @param array $items
     * @return array
     */
    protected function addColPosListLayoutItems($pageId, $items)
    {
        $layout = $this->getSelectedBackendLayout($pageId);
        if ($layout && $layout['__items']) {

            $protectedItems = [];
            foreach ($items as $item) {
                if(intval($item[1]) === 18181) {
                    $protectedItems[] = $item;
                }
            }

            $items = array_merge($protectedItems, $layout['__items']);
        }

        return $items;
    }
}
