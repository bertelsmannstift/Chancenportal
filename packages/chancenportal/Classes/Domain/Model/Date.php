<?php
namespace Chancenportal\Chancenportal\Domain\Model;

use FluidTYPO3\Flux\Form\Field\DateTime;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

/***
 *
 * This file is part of the "Chancenportal" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 ***/
/**
 * Date
 */
class Date extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Offer
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $offer = null;

    /**
     * startDate
     *
     * @var \DateTime
     */
    protected $startDate = null;

    /**
     * startTime
     *
     * @var string
     */
    protected $startTime = null;

    /**
     * endDate
     *
     * @var \DateTime
     */
    protected $endDate = null;

    /**
     * endTime
     *
     * @var string
     */
    protected $endTime = null;

    /**
     * active
     *
     * @var bool
     */
    protected $active = 1;

    /**
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param Offer $offer
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Returns the startDate
     *
     * @return \DateTime $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime|null $startDate
     */
    public function setStartDate($startDate = null)
    {
        $this->startDate = $startDate;
    }

    /**
     * Returns the endDate
     *
     * @return \DateTime $endDate
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime|null $endDate
     */
    public function setEndDate($endDate = null)
    {
        $this->endDate = $endDate;
    }

    /**
     * Returns the startTime
     *
     * @return int $startTime
     */
    public function getStartTime()
    {
        return $this->startTime ? \DateTime::createFromFormat('U', $this->startTime)->format('H:i') : null;
    }

    /**
     * Returns the startTime
     *
     * @return int $startTime
     */
    public function getStartTimeObj()
    {
        return $this->startTime;
    }

    /**
     * @param string|null $startTime
     */
    public function setStartTime($startTime = null)
    {
        $this->startTime = $startTime ? \DateTime::createFromFormat('H:i', $startTime)->getTimestamp() - \DateTime::createFromFormat('H:i', '00:00')->getTimestamp() : null;
    }

    /**
     * Returns the endTime
     *
     * @return int $endTime
     */
    public function getEndTime()
    {
        return $this->endTime ? \DateTime::createFromFormat('U', $this->endTime)->format('H:i') : null;
    }

    /**
     * @param string|null $endTime
     */
    public function setEndTime($endTime = null)
    {
        $this->endTime = $endTime ? \DateTime::createFromFormat('H:i', $endTime)->getTimestamp() - \DateTime::createFromFormat('H:i', '00:00')->getTimestamp() : null;
    }

    /**
     * Returns the active
     *
     * @return bool active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the active
     *
     * @param int $active
     * @return void
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}
