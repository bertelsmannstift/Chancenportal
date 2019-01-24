<?php

namespace Chancenportal\Chancenportal\ViewHelper;

class SplitAddressViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
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
        $this->registerArgument('output', 'string', 'Google maps address string.', false);
    }

    /**
     * @return string
     */
    public function render()
    {
        $address = explode(', ', $this->arguments['address']);
        if (isset($this->arguments['output'])) {
            if ($this->arguments['output'] === 'street') {
                return $address[0];
            } elseif ($this->arguments['output'] === 'city') {
                $city = explode(' ', $address[1]);
                unset($city[0]);
                return implode(' ', $city);
            } elseif ($this->arguments['output'] === 'zip') {
                $city = explode(' ', $address[1]);
                return $city[0];
            }
        }
        return implode('<br/>', $address);
    }
}
