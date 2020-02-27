<?php
namespace UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate;

/***
 *
 * This file is part of the "u+i | Provider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Sebastian Swan <seswan@uandi.com>, www.uandi.com
 *
 ***/

/**
 * Class TcaAggregate
 * @package UI\UiProvider\Xclass\IchHabRecht\MaskExport\Aggregate
 *
 * Adds 'mask_export' to the array of system tables. Otherwise sql/tca would be generated
 * for that table which is not necessary.
 *
 * TODO: Add this as a pull request for mask_export
 */
class TcaAggregate extends \IchHabRecht\MaskExport\Aggregate\TcaAggregate
{
    /**
     * @var array
     */
    protected $systemTables = [
        'pages' => 'pages',
        'tt_content' => 'tt_content',
        'sys_file_reference' => 'sys_file_reference',
        'mask_export' => 'mask_export'
    ];
}