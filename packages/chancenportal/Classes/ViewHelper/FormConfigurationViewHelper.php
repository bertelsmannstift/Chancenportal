<?php

namespace Chancenportal\Chancenportal\ViewHelper;

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
        $allowedPropertyNames = \TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(',',
            $this->arguments['allowProperties']);
        foreach ($allowedPropertyNames as $allowedPropertyName) {
            for ($i = 0; $i <= $this->arguments['count']; $i++) {
                $this->registerFieldNameForFormTokenGeneration($name . '[' . $allowedPropertyName . ']');
            }
        }
        return '';
    }
}
