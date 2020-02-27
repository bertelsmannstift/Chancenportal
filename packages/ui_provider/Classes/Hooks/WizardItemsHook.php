<?php
namespace UI\UiProvider\Hooks;
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

use TYPO3\CMS\Backend\Wizard\NewContentElementWizardHookInterface;

/**
 * Class WizardItemsHook
 * @package UI\UiCeOverrides\Hooks
 */
class WizardItemsHook implements NewContentElementWizardHookInterface {

    /**
     * Order items in each wizard group (tab) by title
     *
     * @param $wizardItems
     * @param $parentObject
     */
	public function manipulateWizardItems(&$wizardItems, &$parentObject) {
	    $groups = [];
	    $currentGroup = null;
	    $previousGroup = '__none__';
	    foreach($wizardItems as $wizardItemKey => $wizardItem) {
            if(strpos($wizardItemKey, $previousGroup) !== 0) {
                if(!empty($currentGroup)) {
                    array_multisort(array_column($currentGroup['items'], 'title'), SORT_ASC, $currentGroup['items']);
                    $groups[] = $currentGroup;
                }

                $currentGroup = [
                    'key' => $wizardItemKey,
                    'header' => $wizardItem['header'],
                    'items' => []
                ];

                $previousGroup = $wizardItemKey;
            } else {
                $currentGroup['items'][] = [
                    'key' => $wizardItemKey,
                    'title' => $wizardItem['title'],
                    'item' => $wizardItem
                ];
            }
        }

        if(!empty($currentGroup)) {
            array_multisort(array_column($currentGroup['items'], 'title'), SORT_ASC, $currentGroup['items']);
            $groups[] = $currentGroup;
        }

        $wizardItems = [];
	    foreach($groups as $group) {
            $wizardItems[$group['key']] = ['header' => $group['header']];

            foreach($group['items'] as $item) {
                $wizardItems[$item['key']] = $item['item'];
            }
        }
	}
}