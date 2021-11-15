<?php
namespace UI\UiProvider\ViewHelpers\Form\Checkbox;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Henrik Ziegenhain <henrik@ziegenhain.me>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class FindActiveCheckboxesViewHelper
 * @package UI\UiProvider\ViewHelpers\Form\Checkbox
 *
 * Check which checkboxes of a group of checkboxes got checked by bitwise shifting
 * Remember: TYPO3 saves da decimal representation of checkbox values to database
 * Example: "5" means, that Checkboxes No. 1 and 3 got checked (1 + 4)
 *
 * Usage
 * -----
 * <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" xmlns:uandi="http://typo3.org/ns/UI/UiProvider/ViewHelpers" data-namespace-typo3-fluid="true">
 *     <f:for each="{uandi:form.checkbox.findActiveCheckboxes(value:data.tx_uice_checkboxes_options)}" as="cb">
 *         <f:switch expression="{cb}">
 *             <f:case value="1">Option 1</f:case>
 *             <f:case value="2">Option 2</f:case>
 *             <f:case value="3">Option 3</f:case>
 *         </f:switch>
 *     </f:for>
 * </html>
 */
class FindActiveCheckboxesViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('value', 'int', 'decimal value of active checkboxes', true);
        $this->registerArgument('index', 'int', 'Index of the Checkbox you want to check', false);
    }

    /**
     * @return array
     */
    public function render()
    {
        $checkboxValue = (int)$this->arguments['value'];
        $activeCheckboxes = [];
        for ($i=0; $i<10; $i++) {
            if (($checkboxValue >> $i) & 1) {
                /*
                 * Decide what kind of value you need, bit shift, item number or pow
                echo 'bit shift ' . $i . '<br>';
                echo 'pow ' . pow(2, $i) . '<br>';
                echo 'item #' . ($i+1) . '<br>';
                */
                $activeCheckboxes[] = $i+1;
            }
        }

        if(!empty($this->arguments['index'])) {
            return in_array($this->arguments['index'], $activeCheckboxes);
        }

        return $activeCheckboxes;
    }
}