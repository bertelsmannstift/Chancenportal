<?php
namespace UI\UiProvider\Task;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

use \TYPO3\CMS\Scheduler\Task\AbstractTask;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DeleteRealurlAutoconfTask
 */
class DeleteRealurlAutoconfTask extends AbstractTask {
    public function __construct() {
        parent::__construct();
    }

    public function execute() {
        $file = GeneralUtility::getFileAbsFileName('typo3conf/realurl_autoconf.php');

        if(file_exists($file)) {
            unlink($file);
        }

        return true;
    }
}