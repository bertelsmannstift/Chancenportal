<?php
namespace UI\UiProvider\Utility;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

/**
 * ExtensionManagementUtility
 */
class ExtensionManagementUtility
{

    public static function removeFromAllTCAtypes($table = '', $field = '', $typeList = '')
    {
        if(!empty($table) && !empty($field) && isset($GLOBALS['TCA'][$table])) {
            foreach($GLOBALS['TCA'][$table]['types'] as $type => $definition) {
                if(empty($typeList) || in_array($type, explode(',', $typeList))) {
                    $GLOBALS['TCA'][$table]['types'][$type]['showitem'] = preg_replace(
                        '/[, ]+'.preg_quote($field, '/').'/',
                        '',
                        $GLOBALS['TCA'][$table]['types'][$type]['showitem']
                    );
                }
            }
        }
    }
}