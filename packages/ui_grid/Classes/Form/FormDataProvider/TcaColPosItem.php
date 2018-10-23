<?php
namespace UI\UiGrid\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TcaColPosItem implements FormDataProviderInterface
{
    /**
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        if($result['tableName'] === 'tt_content') {
            if (!is_array($result['processedTca']['columns']['colPos']['config']['items'])) {
                $result['processedTca']['columns']['colPos']['config']['items'] = [];
            }
            array_unshift(
                $result['processedTca']['columns']['colPos']['config']['items'],
                [
                    'LLL:EXT:ui_grid/Resources/Private/Language/locallang_db.xlf:tt_content.colPos.nestedContentColPos',
                    $result['databaseRow']['colPos'],
                ]
            );
        }

        return $result;
    }
}
