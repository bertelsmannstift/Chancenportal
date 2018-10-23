<?php
/***
 *
 * This file is part of the "u+i Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

/**
 * Namespace
 */
namespace UI\UiProvider\Form\FormDataProvider;

/**
 * Aliases
 */
use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

/**
 * Class TcaCTypeItem
 * @package UI\UiProvider\Form\FormDataProvider
 */
class TcaCTypeItem implements FormDataProviderInterface
{
    protected $beLayoutPrefix = 'pagets__';

    /**
     * Adds only entries to the CType select that are allowed for the used backend_layout/colPos
     *
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if(empty($result['inlineParentTableName']) || empty($result['inlineParentFieldName'])) {
            $beLayout   = substr(\UI\UiProvider\Utility\GeneralUtility::getPageLayout($result['parentPageRow']['uid']), strlen($this->beLayoutPrefix));
            $colPos     = $result['databaseRow']['colPos'][0];

            if(!empty($result['pageTsConfig']['mod.']['web_layout.']['BackendLayouts.'][$beLayout.'.']['config.']['backend_layout.'])) {
                $allowedCTypes = $this->getAllowedItems($colPos, $result['pageTsConfig']['mod.']['web_layout.']['BackendLayouts.'][$beLayout.'.']['config.']['backend_layout.']);

                if(is_string($allowedCTypes)) {
                    $allowedCTypes = explode(',', $allowedCTypes);

                    $result['processedTca']['columns']['CType']['config']['items'] = array_filter(
                        $result['processedTca']['columns']['CType']['config']['items'],
                        function ($item) use($allowedCTypes) {
                            return in_array($item[1], $allowedCTypes);
                        }
                    );
                }
            }
        }

        return $result;
    }

    /**
     * @param int $colPos
     * @param $beLayoutConfig
     * @return string|null
     */
    private function getAllowedItems($colPos = 0, $beLayoutConfig)
    {
        foreach($beLayoutConfig['rows.'] as $row) {
            foreach($row['columns.'] as $column) {
                if((string) $column['colPos'] === (string) $colPos && !is_null($column['allowed'])) {
                    return str_replace(' ', '', $column['allowed']);
                }
            }
        }

        return null;
    }
}
