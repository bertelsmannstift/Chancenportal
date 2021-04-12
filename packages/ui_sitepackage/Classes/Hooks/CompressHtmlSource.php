<?php

namespace UI\UiSitepackage\Hooks;

use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use UI\UiSitepackage\Utility\GeneralUtility;

/**
 * Compress the wohle html output
 *
 * ### Usage
 * ```
 * // In ext_localconf.php
 * $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] = \UI\UiProvider\Hooks\CompressHtmlSource::class . '->contentPostProcOutput';
 * $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \UI\UiProvider\Hooks\CompressHtmlSource::class . '->contentPostProcAll';
 * ```
 */
class CompressHtmlSource extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{

    /**
     * Non-Cached
     *
     * @param array $params
     * @param TypoScriptFrontendController $that
     */
    public function contentPostProcOutput(&$params, &$that)
    {
        if (!$GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->compressHtml($params['pObj']->content);
    }

    /**
     * Cached
     *
     * @param array $params
     * @param TypoScriptFrontendController $that
     */
    public function contentPostProcAll(&$params, &$that)
    {
        if ($GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->compressHtml($params['pObj']->content);
    }

    /**
     * @param string $content
     */
    private function compressHtml(&$content)
    {
        $content = GeneralUtility::compressHtmlSource($content);
    }
}
