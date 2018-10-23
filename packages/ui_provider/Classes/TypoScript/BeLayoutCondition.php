<?php
namespace UI\UiProvider\TypoScript;

/**
 * BeLayoutCondition condition
 *
 * Used for Conditions in BeLayout Definitions.
 * Based on the tx_mask function "user_mask_beLayout"
 *
 */
class BeLayoutCondition extends \TYPO3\CMS\Core\Configuration\TypoScript\ConditionMatching\AbstractCondition {

    /**
     * Evaluate condition
     *
     * @param array $conditionParameters
     * @return bool
     */
    public function matchCondition(array $conditionParameters) {
        $layout = isset($conditionParameters[0]) ? $conditionParameters[0] : '';

        // get current page uid:
        if (is_array($_REQUEST["data"]["pages"])) { // after saving page
            $uid = intval(key($_REQUEST["data"]["pages"]));
        } elseif (is_array($_REQUEST["data"]["pages_language_overlay"])) {
            $po_uid = key($_REQUEST["data"]["pages_language_overlay"]);
            if ($_REQUEST["data"]["pages_language_overlay"][$po_uid]["pid"]) { // after saving a new pages_language_overlay
                $uid = $_REQUEST["data"]["pages_language_overlay"][$po_uid]["pid"];
            } else { // after saving an existing pages_language_overlay
                $po_uid = intval($po_uid);
                $sql = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                    "pid", "pages_language_overlay", "uid = " . $po_uid
                );
                $data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sql);
                $uid = $data["pid"];
            }
        } elseif ($GLOBALS["SOBE"]->editconf["pages"]) { // after opening pages
            $uid = intval(key($GLOBALS["SOBE"]->editconf["pages"]));
        } elseif ($GLOBALS["SOBE"]->viewId) { // after opening or creating pages_language_overlay
            $uid = $GLOBALS["SOBE"]->viewId;
        } else {
            if ($GLOBALS["_SERVER"]["HTTP_REFERER"] != "") {
                $url = $GLOBALS["_SERVER"]["HTTP_REFERER"];
                $queryString = parse_url($url, PHP_URL_QUERY);
                $result = array();
                parse_str($queryString, $result);
                if ($result["id"]) {
                    $uid = (int) $result["id"];
                }
            }
        }

        if ($uid) {
            $sql = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                "uid, t3ver_state, backend_layout, backend_layout_next_level", "pages", "uid = " . $uid
            );
            $data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sql);

            /** Respect Versioning */
            if(isset($data['t3ver_state']) && $data['t3ver_state'] === '1') {
                $sql = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                    "uid, t3ver_state, backend_layout, backend_layout_next_level", "pages", "t3ver_oid = " . $uid . " AND t3ver_state = -1"
                );
                $data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($sql);
            }

            $backend_layout = $data["backend_layout"];
            $backend_layout_next_level = $data["backend_layout_next_level"];

            if ($backend_layout !== "") { // If backend_layout is set on current page
                if (in_array($backend_layout, [$layout, "pagets__" . $layout])) { // Check backend_layout of current page
                    return true;
                } else {
                    return false;
                }
            } elseif ($backend_layout_next_level !== "") { // If backend_layout_next_level is set on current page
                if (in_array($backend_layout_next_level, [$layout, "pagets__" . $layout])) { // Check backend_layout_next_level of current page
                    return true;
                } else {
                    return false;
                }
            } else { // If backend_layout and backend_layout_next_level is not set on current page, check backend_layout_next_level on rootline
                $sysPage = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
                $rootline = $sysPage->getRootLine($uid, '', TRUE);
                foreach ($rootline as $page) {
                    if (in_array($page["backend_layout_next_level"], [$layout, "pagets__" . $layout])) {
                        return true;
                    }
                }
                return false;
            }
        } else {
            return false;
        }
    }
}