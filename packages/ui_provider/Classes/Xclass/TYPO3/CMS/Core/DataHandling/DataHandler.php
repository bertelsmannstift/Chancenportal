<?php
namespace UI\UiProvider\Xclass\TYPO3\CMS\Core\DataHandling;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 *
 * IMPORTANT NOTE
 *
 * This Xclass is used to fix a core bug related to workspaces previews
 * https://forge.typo3.org/issues/82462
 *
 * All modifications are marked with: "u+i Modification"
 *
 * TODO: Remove this Xclass after the fix is published
 *
 ***/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\SlugEnricher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Versioning\VersionState;

/**
 * PageLayoutView
 */
class DataHandler extends \TYPO3\CMS\Core\DataHandling\DataHandler
{
    /**
     * Fix shadowing of data in case we are editing an offline version of a live "New" placeholder record:
     *
     * @param string $table Table name
     * @param int $id Record uid
     */
    public function placeholderShadowing($table, $id)
    {
        if ($liveRec = BackendUtility::getLiveVersionOfRecord($table, $id, '*')) {
            if (VersionState::cast($liveRec['t3ver_state'])->indicatesPlaceholder()) {
                $justStoredRecord = BackendUtility::getRecord($table, $id);
                $newRecord = [];
                $shadowCols = $GLOBALS['TCA'][$table]['ctrl']['shadowColumnsForNewPlaceholders'];
                $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['languageField'];
                $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField'];
                if (isset($GLOBALS['TCA'][$table]['ctrl']['translationSource'])) {
                    $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['translationSource'];
                }
                $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['type'];
                $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['label'];

                /**
                 * u+i Modification
                 */
                if (!empty($GLOBALS['TCA'][$table]['ctrl']['enablecolumns']['disabled'])) {
                    $shadowCols .= ',' . $GLOBALS['TCA'][$table]['ctrl']['enablecolumns']['disabled'];
                }

                $shadowCols .= ',' . implode(',', GeneralUtility::makeInstance(SlugEnricher::class)->resolveSlugFieldNames($table));
                $shadowColumns = array_unique(GeneralUtility::trimExplode(',', $shadowCols, true));
                foreach ($shadowColumns as $fieldName) {
                    if ((string)$justStoredRecord[$fieldName] !== (string)$liveRec[$fieldName] && isset($GLOBALS['TCA'][$table]['columns'][$fieldName]) && $fieldName !== 'uid' && $fieldName !== 'pid') {
                        $newRecord[$fieldName] = $justStoredRecord[$fieldName];
                    }
                }
                if (!empty($newRecord)) {
                    if ($this->enableLogging) {
                        $this->log($table, $liveRec['uid'], 0, 0, 0, 'Shadowing done on fields <i>' . implode(',', array_keys($newRecord)) . '</i> in placeholder record ' . $table . ':' . $liveRec['uid'] . ' (offline version UID=' . $id . ')', -1, [], $this->eventPid($table, $liveRec['uid'], $liveRec['pid']));
                    }
                    $this->updateDB($table, $liveRec['uid'], $newRecord);
                }
            }
        }
    }
}
