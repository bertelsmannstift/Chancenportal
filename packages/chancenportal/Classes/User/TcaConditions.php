<?php
namespace Chancenportal\Chancenportal\User;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Conditions
 *
 * Collection of conditions for use in TCA displayCond
 *
 */
class TcaConditions {

    /**
     * matchFileType
     *
     * For use in a TCA displayCond in sys_file_metadata
     *
     * Valid file types are:
     *
     *       1: Text
     *       2: Image
     *       3: Audio
     *       4: Video
     *       5: Application
     * default: Other
     *
     * @param array $conditionParameters
     * @return bool
     */
    public function matchFileType(array $conditionParameters) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file');

        $queryBuilder->select('type')
            ->from('sys_file')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($conditionParameters['record']['file'][0], Connection::PARAM_INT))
            );

        if($file = $queryBuilder->execute()->fetch()) {
            if((int)$file['type'] === (int)$conditionParameters['conditionParameters'][0]) {
                return true;
            }
        }

        return false;
    }

    /**
     * matchMimeType
     *
     * For use in a TCA displayCond in sys_file_metadata
     *
     * @param array $conditionParameters
     * @return bool
     */
    public function matchMimeType(array $conditionParameters) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file');

        $queryBuilder->select('mime_type')
            ->from('sys_file')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($conditionParameters['record']['file'][0], Connection::PARAM_STR))
            );

        if($file = $queryBuilder->execute()->fetch()) {
            if((string)$file['mime_type'] === (string)$conditionParameters['conditionParameters'][0]) {
                return true;
            }
        }

        return false;
    }

    /**
     * matchPageType
     *
     * For use in a TCA displayCond in pages
     *
     * @param array $conditionParameters
     * @return bool
     */
    public function matchPageType(array $conditionParameters) {
        $pageLayout = \UI\UiProvider\Utility\GeneralUtility::getPageLayout($conditionParameters['record']['uid']);

        if(!isset($conditionParameters['conditionParameters'][0]) && $conditionParameters['record']['is_siteroot'] === 1) {
            return true;
        } if(isset($conditionParameters['conditionParameters'][0]) && $pageLayout === $conditionParameters['conditionParameters'][0] || $pageLayout === 'pagets__' . $conditionParameters['conditionParameters'][0]) {
            return true;
        }

        return false;
    }
}