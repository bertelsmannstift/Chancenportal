<?php
namespace UI\UiProvider\Xclass\Backend\View;

/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 *
 * IMPORTANT NOTE
 *
 * This Xclass is used to implement a feature of Typo3 v.9.x, so
 * it may be removed in the future.
 *
 * https://docs.typo3.org/typo3cms/extensions/core/latest/Changelog/9.0/Feature-76910-PageLayoutViewAllowToDisableCopyTranslateButtons.html
 *
 ***/

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * PageLayoutView
 */
class PageLayoutView extends \TYPO3\CMS\Backend\View\PageLayoutView
{
    /**
     * Creates button which is used to create copies of records..
     *
     * @param array $defaultLanguageUids Numeric array with uids of tt_content elements in the default language
     * @param int $lP Sys language UID
     * @param int $colPos Column position
     * @return string "Copy languages" button, if available.
     */
    public function newLanguageButton($defaultLanguageUids, $lP, $colPos = 0)
    {
        $lP = (int)$lP;
        if (!$this->doEdit || !$lP) {
            return '';
        }
        $theNewButton = '';

        $localizationTsConfig = BackendUtility::getModTSconfig($this->id, 'mod.web_layout.localization');
        $allowCopy = isset($localizationTsConfig['properties']['enableCopy'])
            ? (int)$localizationTsConfig['properties']['enableCopy'] === 1
            : true;
        $allowTranslate = isset($localizationTsConfig['properties']['enableTranslate'])
            ? (int)$localizationTsConfig['properties']['enableTranslate'] === 1
            : true;

        if (!empty($this->languageHasTranslationsCache[$lP])) {
            if (isset($this->languageHasTranslationsCache[$lP]['hasStandAloneContent'])) {
                $allowTranslate = false;
            }
            if (isset($this->languageHasTranslationsCache[$lP]['hasTranslations'])) {
                $allowCopy = false;
            }
        }

        if (isset($this->contentElementCache[$lP][$colPos]) && is_array($this->contentElementCache[$lP][$colPos])) {
            foreach ($this->contentElementCache[$lP][$colPos] as $record) {
                $key = array_search($record['l10n_source'], $defaultLanguageUids);
                if ($key !== false) {
                    unset($defaultLanguageUids[$key]);
                }
            }
        }

        if (!empty($defaultLanguageUids)) {
            $theNewButton =
                '<input'
                . ' class="btn btn-default t3js-localize"'
                . ' type="button"'
                . ' disabled'
                . ' value="' . htmlspecialchars($this->getLanguageService()->getLL('newPageContent_translate')) . '"'
                . ' data-has-elements="' . (int)!empty($this->contentElementCache[$lP][$colPos]) . '"'
                . ' data-allow-copy="' . (int)$allowCopy . '"'
                . ' data-allow-translate="' . (int)$allowTranslate . '"'
                . ' data-table="tt_content"'
                . ' data-page-id="' . (int)GeneralUtility::_GP('id') . '"'
                . ' data-language-id="' . $lP . '"'
                . ' data-language-name="' . htmlspecialchars($this->tt_contentConfig['languageCols'][$lP]) . '"'
                . ' data-colpos-id="' . $colPos . '"'
                . ' data-colpos-name="' . BackendUtility::getProcessedValue('tt_content', 'colPos', $colPos) . '"'
                . '/>';
        }

        return '<div class="t3-page-lang-copyce">' . $theNewButton . '</div>';
    }
}
