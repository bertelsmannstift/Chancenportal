<?php

namespace Chancenportal\Chancenportal\ViewHelper;

class ExtractCityViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
{
    /**
     *
     */
    public function initialize()
    {

    }

    /**
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('address', 'string', 'Google maps address string.', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        $address = explode(',', $this->arguments['address']);
        if (count($address) > 2) {
            return trim($address[1]);
        } else {
            if (count($address) === 2) {
                return trim($address[0]);
            }
        }
        return $this->arguments['address'];
    }
}
