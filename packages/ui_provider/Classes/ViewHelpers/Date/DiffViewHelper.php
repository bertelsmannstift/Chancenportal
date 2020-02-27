<?php
namespace UI\UiProvider\ViewHelpers\Date;

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

/**
 * Class DiffViewHelper
 * @package UI\UiProvider\ViewHelpers\Date
 *
 * Get the difference between two dates and return them in the given format
 *
 * Usage
 * -----
 * {uandi:date.diff(dateStart: '2019-01-01', dateEnd: '2019-02-01', '%a')}
 * <uandi:date.diff dateStart="2019-01-01" dateEnd="2019-02-01" '%a' />
 *
 * See https://www.php.net/manual/en/dateinterval.format.php for options for the format parameter
 */
class DiffViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        $this->registerArgument('dateStart', 'string', '', true);
        $this->registerArgument('dateEnd', 'string', '', true);
        $this->registerArgument('format', 'string', '', false, '%a');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function render() {
        $dateStart = new \DateTime($this->arguments['dateStart']);
        $dateEnd = new \DateTime($this->arguments['dateEnd']);

        $diff = $dateEnd->diff($dateStart)->format($this->arguments['format']);

        return $diff;
    }
}
