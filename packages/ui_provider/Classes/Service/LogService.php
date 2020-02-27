<?php
namespace UI\UiProvider\Service;

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

use TYPO3\CMS\Core\SingletonInterface;

/**
 * LogService
 */
class LogService implements SingletonInterface
{
    public function logToBELog($message, $extKey = '', $level = 0)
    {
        $GLOBALS['BE_USER']->writelog(4, 0, $level, 0, ($extKey ? '[' . $extKey . '] ' : '') . $message, []);
    }
}