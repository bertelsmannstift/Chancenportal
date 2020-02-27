<?php
namespace UI\UiProvider\User;

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

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Conditions
 *
 * Collection of conditions for use in TCA displayCond
 *
 * @deprecated Deprecated in Version 9 of ui_provider. Will be removed in Version 10. Use UI\UiProvider\TCA\Conditions instead
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

        if($pageLayout === $conditionParameters['conditionParameters'][0] || $pageLayout === 'pagets__' . $conditionParameters['conditionParameters'][0]) {
            return true;
        }

        return false;
    }
}