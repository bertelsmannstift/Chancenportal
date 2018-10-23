<?php
namespace UI\UiProvider\ViewHelpers\Record;

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Class GetViewHelper.
 *
 * Returns single records from db tables
 *
 * @package UI\UiProvider\ViewHelpers\Record
 */
class GetViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'table',
            'string',
            '',
            true
        );
        $this->registerArgument(
            'uid',
            'integer',
            '',
            true,
            0
        );
        $this->registerArgument(
            'field',
            'string',
            '',
            false,
            '*'
        );
    }

    /**
     * @return array|null
     */
    public function render() {
        return BackendUtility::getRecordWSOL($this->arguments['table'], $this->arguments['uid'], $this->arguments['field']);
    }
}