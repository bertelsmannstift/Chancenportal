<?php
namespace UI\UiProvider\ViewHelpers\Record;

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

use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * Class GetViewHelper
 * @package UI\UiProvider\ViewHelpers\Record
 *
 * Returns single records from db tables
 *
 * Usage
 * -----
 * <html xmlns:uandi="http://typo3.org/ns/UI/UiProvider/ViewHelpers" data-namespace-typo3-fluid="true">
 *     <uandi:record.get table="pages" uid="1" />
 *     {uandi:record.get(table: 'pages', uid: 1)}
 *
 *     <uandi:record.get table="pages" uid="1" field="header" />
 *     {uandi:record.get(table: 'pages', uid: 1, field: 'header')}
 * </html>
 */
class GetViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        $this->registerArgument('table','string','',true);
        $this->registerArgument('uid','integer','',true,0);
        $this->registerArgument('field','string','',false,'*');
    }

    /**
     * @return array|null
     */
    public function render() {
        return BackendUtility::getRecordWSOL($this->arguments['table'], $this->arguments['uid'], $this->arguments['field']);
    }
}