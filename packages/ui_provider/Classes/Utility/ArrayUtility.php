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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ArrayUtility
 * @package UI\UiProvider\Utility
 */
class ArrayUtility extends \TYPO3\CMS\Core\Utility\ArrayUtility
{
    /**
     * Reorder associative array items
     *
     * @param $array
     * @param $key
     * @param $position
     * @return array
     *
     * Used in ext_localconf.php to move custom BE-Module menu entries
     *
     * Usage
     * -----
     * // Move the $array item with the key 'lorem' after the item with the key 'item'
     * ArrayUtility::moveAssocArrayKey($array, 'lorem', 'after:ipsum');
     *
     * // Move the $array item with the key 'lorem' before the item with the key 'item'
     * ArrayUtility::moveAssocArrayKey($array, 'lorem', 'before:ipsum');
     *
     * // Move the $array item with the key 'lorem' to the front of the $array
     * ArrayUtility::moveAssocArrayKey($array, 'lorem', 'top');
     *
     * // Move the $array item with the key 'lorem' to the end of the $array
     * ArrayUtility::moveAssocArrayKey($array, 'lorem', 'bottom');
     */
    public static function moveAssocArrayKey($array, $key, $position)
    {
        if(!isset($array[$key])) {
            return $array;
        }

        list($place, $modRef) = GeneralUtility::trimExplode(':', $position, true);

        if($modRef && !isset($array[$modRef])) {
            return $array;
        }

        $return = [];
        $value = $array[$key];
        unset($array[$key]);

        switch ($place) {
            case 'before':
                foreach($array as $itemKey => $itemValue) {
                    if($itemKey === $modRef) {
                        $return[$key] = $value;
                    }
                    $return[$itemKey] = $itemValue;
                }
                break;
            case 'after':
                foreach($array as $itemKey => $itemValue) {
                    $return[$itemKey] = $itemValue;
                    if($itemKey === $modRef) {
                        $return[$key] = $value;
                    }
                }
                break;
            case 'top':
                $return[$key] = $value;
                $return += $array;
                break;
            case 'bottom':
            default:
                $return = $array;
                $return[$key] = $value;
        }

        return $return;
    }
}