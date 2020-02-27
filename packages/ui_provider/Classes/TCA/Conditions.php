<?php
namespace UI\UiProvider\TCA;

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

/**
 * Class Conditions
 * @package UI\UiProvider\TCA
 *
 * Collection of conditions for use in TCA displayCond
 */
class Conditions {

    /**
     * matchFileType condition for use in a TCA displayCond in sys_file_metadata
     *
     * @param array $conditionParameters
     * @return bool
     *
     * Usage
     * -----
     * 'displayCond' => 'USER:UI\\UiProvider\\TCA\\Conditions->matchFileType:4'
     *
     * Valid file types
     * ----------------
     *       1: Text
     *       2: Image
     *       3: Audio
     *       4: Video
     *       5: Application
     * default: Other
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
     * matchMimeType condition for use in a TCA displayCond in sys_file_metadata
     *
     * @param array $conditionParameters
     * @return bool*
     *
     * Usage
     * -----
     * 'displayCond' => 'USER:UI\\UiProvider\\TCA\\Conditions->matchMimeType:image/png'
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
     * matchPageType condition for use in a TCA displayCond in pages
     *
     * @param array $conditionParameters
     * @return bool
     *
     * Usage
     * -----
     * 'displayCond' => 'USER:UI\\UiProvider\\TCA\\Conditions->matchPageType:Homepage'
     */
    public function matchPageType(array $conditionParameters) {
        $pageLayout = \UI\UiProvider\Utility\GeneralUtility::getPageLayout($conditionParameters['record']['uid']);

        if($pageLayout === $conditionParameters['conditionParameters'][0] || $pageLayout === 'pagets__' . $conditionParameters['conditionParameters'][0]) {
            return true;
        }

        return false;
    }
}