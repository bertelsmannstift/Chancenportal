<?php
namespace UI\UiProvider\ViewHelpers\Date;

class DiffViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $format
     * @return string
     */
    public function render($dateStart = null, $dateEnd = null, $format = '%a') {

        $dateStart = new \DateTime($dateStart);
        $dateEnd = new \DateTime($dateEnd);

        $diff = $dateEnd->diff($dateStart)->format("%a");

        return $diff;
    }
}
