<?php

namespace Chancenportal\Chancenportal\ViewHelper;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FormConfigurationViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
{
    /** * Keep the parent from preparing the TagBuilder. * * @return void */
    public function initialize()
    {
    }

    /** * Initialize the arguments. * * @return void * @api */
    public function initializeArguments()
    {
        $this->registerArgument('property', 'string', 'Name of property (of the object bound to the form) to configure',
            true);
        $this->registerArgument('allowProperties', 'string',
            'List property names (comma separated) to map onto the property given in forProperty', true);
        $this->registerArgument('count', 'int', '', false, 1);
    }

    /** * Does not render anything, just tweaks configuration. * * @return string * @api */
    public function render()
    {
        $name = $this->arguments['property']; //$this->getName();
        $allowedPropertyNames = GeneralUtility::trimExplode(',',
            $this->arguments['allowProperties']);
        foreach ($allowedPropertyNames as $allowedPropertyName) {
            for ($i = 0; $i <= $this->arguments['count']; $i++) {
                $this->registerFieldNameForFormTokenGeneration($name . '[' . $allowedPropertyName . ']');
            }
        }
        return '';
    }
}
