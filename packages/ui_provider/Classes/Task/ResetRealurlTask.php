<?php
namespace UI\UiProvider\Task;

use \TYPO3\CMS\Scheduler\Task\AbstractTask;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class ResetRealurlTask extends AbstractTask {
    public function __construct() {
        parent::__construct();
    }

    public function execute() {
        $file = GeneralUtility::getFileAbsFileName('typo3conf/realurl_autoconf.php');

        if(file_exists($file)) {
            unlink($file);
        }

        $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery('tx_realurl_pathdata');
        $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery('tx_realurl_uniqalias');
        $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery('tx_realurl_uniqalias_cache_map');
        $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery('tx_realurl_urldata');

        return true;
    }
}