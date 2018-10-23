<?php

namespace Chancenportal\Chancenportal\ViewHelper;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class OfferFormaterViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
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
        $this->registerArgument('offer', 'object', 'Offer item', false);
        $this->registerArgument('date', 'object', 'Date item', false);
        $this->registerArgument('latest', 'boolean', 'Show latest date', false, false);
        $this->registerArgument('output', 'string', 'Offer field name', false);
        $this->registerArgument('long', 'boolean', 'Offer field name', false, true);
    }

    /**
     * @param null $latestDate
     * @param array $offerDates
     * @return string
     */
    public function outputConcreteData($latestDate = null, $offerDates = []) {
        $explicitDate = $this->arguments['date'];

        // Konkrete Daten
        if($latestDate && count($offerDates) > 1 && $this->arguments['latest'] === false && !$explicitDate && $this->arguments['output'] === 'date') {

            return 'Mehrere Termine, nächster ' . strftime("%a., %d.%m.%Y", $latestDate->getStartDate()->getTimestamp());
        } elseif($latestDate) {

            if($this->arguments['output'] === 'date') {
                return strftime("%a., %d.%m.%Y", $latestDate->getStartDate()->getTimestamp());
            } elseif($this->arguments['output'] === 'time' && count($offerDates) === 1) {
                return $latestDate->getStartTime() . ($latestDate->getStartTime() === $latestDate->getEndTime() ? '' : ' - ' . $latestDate->getEndTime());
            }
        }
    }

    /**
     * @param null $latestDate
     * @param array $offerDates
     * @return string
     */
    public function outputPeriod($latestDate = null, $offerDates = []) {
        $explicitDate = $this->arguments['date'];

        if(!$explicitDate && count($offerDates) > 1 && $this->arguments['latest'] === false && $latestDate) {

            if($this->arguments['output'] === 'date') {
                return 'Mehrere Termine, nächster ' . $latestDate->getStartDate()->format('d.m.Y') . ' - ' . $latestDate->getEndDate()->format('d.m.Y');
            }
        } elseif($latestDate) {
            if($this->arguments['output'] === 'date') {
                if($this->arguments['long']) {
                    return 'Vom ' . $latestDate->getStartDate()->format('d.m.Y') . "\nBeginn um: " . $latestDate->getStartTime() .  " Uhr\nBis " . $latestDate->getEndDate()->format('d.m.Y') . "\nEndet um: " . $latestDate->getEndTime() . ' Uhr';
                } else {
                    return $latestDate->getStartDate()->format('d.m.Y') . ' - ' . $latestDate->getEndDate()->format('d.m.Y');
                }
            } elseif($this->arguments['output'] === 'time') {
                return '';
            }
            return $latestDate->getStartDate()->format('d.m.Y') . ' - ' . $latestDate->getEndDate()->format('d.m.Y') . ' ' . $latestDate->getStartTime() . ($latestDate->getStartTime() === $latestDate->getEndTime() ? '' : ' - ' . $latestDate->getEndTime());
        }
    }

    /**
     * @param null $offer
     * @param null $latestDate
     * @param array $offerDates
     * @return string
     */
    public function outputEveryDay($offer = null, $latestDate = null, $offerDates = []) {
        $explicitDate = $this->arguments['date'];
        $now = new \DateTime('midnight');

        if(!$explicitDate && count($offerDates) > 1 && $this->arguments['latest'] === false) {
            if($this->arguments['output'] === 'date') {
                return 'Mehrere Termine, nächster ' . ($latestDate ? $latestDate->getStartDate()->format('d.m.Y') : $now->format('d.m.Y'));
            } elseif($this->arguments['output'] === 'time') {
                return $latestDate->getStartTime() . ($latestDate->getStartTime() === $latestDate->getEndTime() ? '' : ' - ' . $latestDate->getEndTime());
            }
        } elseif($explicitDate && $offerDates->count() > 0) {
            if($this->arguments['output'] === 'date') {
                return $explicitDate->getStartDate()->format('d.m.Y') .  ' - ' . $explicitDate->getEndDate()->format('d.m.Y') . ' täglich';
            } elseif($this->arguments['output'] === 'time') {
                return $explicitDate->getStartTime() . ($explicitDate->getStartTime() === $explicitDate->getEndTime() ? '' : ' - ' . $explicitDate->getEndTime());
            }
        } elseif($offerDates->count() > 0) {
            if($this->arguments['output'] === 'date') {
                $firstDate = $offer->getDates()->toArray()[0];
                return $firstDate->getStartDate()->format('d.m.Y') .  ' - ' . $firstDate->getEndDate()->format('d.m.Y') . ' täglich';
            } elseif($this->arguments['output'] === 'time' && count($offerDates) === 1) {
                $firstDate = $offer->getDates()->toArray()[0];
                return $firstDate->getStartTime() . ($firstDate->getStartTime() === $firstDate->getEndTime() ? '' : ' - ' . $firstDate->getEndTime());
            }
        }
    }

    /**
     * @param null $latestDate
     * @param array $activeWeekDates
     * @return string
     */
    public function outputWeekly($offer = null, $latestDate = null, $activeWeekDates = []) {
        $explicitDate = $this->arguments['date'];
        $now = new \DateTime('midnight');

        if($this->arguments['output'] === 'date' && !$explicitDate) {

            if(count($activeWeekDates) > 1) {
                $days = [];

                foreach($activeWeekDates as $day) {
                    if($day->getStartDate()) {
                        $days[] = strftime("%A", $day->getStartDate()->getTimestamp());
                    }
                }

                if($offer->getStartDate() > $now) {
                    return 'Ab ' . $offer->getStartDate()->format('d.m.Y') .  ' jeden ' . implode(', ', $days);
                }
                return 'Jeden ' . implode(', ', $days);
            }

            if(count($activeWeekDates) === 1 && $activeWeekDates[0]->getStartDate()) {
                if($offer->getStartDate() > $now) {
                    return 'Ab ' . $offer->getStartDate()->format('d.m.Y') .  ' jeden ' . strftime("%A", $activeWeekDates[0]->getStartDate()->getTimestamp());
                }
                return 'Jeden ' . strftime("%A", $activeWeekDates[0]->getStartDate()->getTimestamp());
            }

        } elseif($latestDate && $this->arguments['output'] === 'time' && count($activeWeekDates) === 1 && !$explicitDate) {

            return $latestDate->getStartTime() . ($latestDate->getStartTime() === $latestDate->getEndTime() ? '' : ($latestDate->getEndTime() ? ' - ' . $latestDate->getEndTime() : ''));

        } elseif($explicitDate && $explicitDate->getActive()) {

            if($this->arguments['output'] === 'date' && $explicitDate->getStartDate()) {
                return 'Jeden ' .  strftime("%A", $explicitDate->getStartDate()->getTimestamp());
            } elseif($explicitDate->getStartDate()) {
                return $explicitDate->getStartTime() . ($explicitDate->getStartTime() === $explicitDate->getEndTime() ? '' : ($explicitDate->getEndTime() ? ' - ' . $explicitDate->getEndTime() : ''));
            }
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        setlocale(LC_ALL, 'de_DE');

        $now = new \DateTime('midnight');
        $offer = $this->arguments['offer'];
        $explicitDate = $this->arguments['date'];
        $latestDate = null;
        $offerDates = new ObjectStorage();
        $activeWeekDates = [];

        if ($offer) {
            $offerDates = clone $offer->getDates();

            if($offer->getDateType() === 4) {

                foreach ($offerDates as $date) {
                    if($date->getActive() && (!$date->getEndDate() || $date->getEndDate() >= $now)) {
                        $activeWeekDates[] = $date;
                    }
                }
                foreach($activeWeekDates as $activeDate) {
                    if(!$latestDate || $activeDate->getStartDate() <= $latestDate->getStartDate()) {
                        $latestDate = $activeDate;
                    }
                }

            } else if($offer->getDateType() === 3) {

                foreach ($offerDates as $date) {
                    if ($date->getStartDate() <= $now && $date->getEndDate() >= $now) {
                        $newDate = clone $date;
                        $newDate->setStartDate($now);
                        $latestDate = $newDate;
                        break;
                    } elseif (!$latestDate || ($date->getStartDate() > $now && $latestDate < $date->getStartDate())) {
                        $latestDate = $date;
                    }
                }

            } else if($offer->getDateType() === 2) {

                foreach ($offerDates as $date) {
                    if (!$latestDate ||
                        (
                            $date->getStartDate() < $latestDate->getStartDate() &&
                            $date->getStartDate() >= $now
                        ) ||
                        (
                            $date->getStartDate() > $latestDate->getEndDate() &&
                            $latestDate->getEndDate() < $now
                        ) ||
                        (
                            $date->getEndDate() > $latestDate->getStartDate() &&
                            $date->getEndDate() <= $now
                        )
                    ) {
                        $latestDate = $date;
                    }
                }

            } elseif($offer->getDateType() === 1) {

                foreach ($offerDates as $date) {
                    if ($date->getStartDate() >= $now) {
                        if (!$latestDate || $latestDate > $date->getStartDate()) {
                            $latestDate = $date;
                        }
                    }
                }
            }
        }

        if($explicitDate) {
            $latestDate = $explicitDate;

            if($explicitDate->getOffer()) {
                $offer = $explicitDate->getOffer();
            }
        }

        try {
            if($offer->getDateType() === 1) {
                // Konkrete Daten
                return $this->outputConcreteData($latestDate, $offerDates);
            } else if($offer->getDateType() === 2) {
                // Zeitraum
                return $this->outputPeriod($latestDate, $offerDates);
            } else if($offer->getDateType() === 3) {
                // Täglich
                return $this->outputEveryDay($offer, $latestDate, $offerDates);
            } else if($offer->getDateType() === 4) {
                // Wöchentlich
                return $this->outputWeekly($offer, $latestDate, $activeWeekDates);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    /**
     * @param \DateTime $startDate
     * @return mixed
     */
    function getDayCountInMonth(\DateTime $startDate) {

        $dayNr = intval($startDate->format('w'));
        $firstDayOfMonth = clone $startDate;
        $firstDayOfMonth->modify('first day of this month midnight');
        $count = 0;

        while ($firstDayOfMonth <= $startDate) {
            if(intval($firstDayOfMonth->format('w')) === $dayNr) {
                $count++;
            }
            $firstDayOfMonth->modify('+1 day');
        }

        return $count >= 4 ? 'letzten ' : $count . '. ';
    }
}
