<?php
namespace Chancenportal\Chancenportal\Domain\Model;


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
 * Log
 */
class Log extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * date
     *
     * @var \DateTime
     */
    protected $date = null;

    /**
     * term
     *
     * @var string
     */
    protected $term = '';

    /**
     * category
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\Category
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $category = null;

    /**
     * offer
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\Offer
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $offer = null;

    /**
     * Returns the date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns the term
     *
     * @return string $term
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * Sets the term
     *
     * @param string $term
     * @return void
     */
    public function setTerm($term)
    {
        $this->term = $term;
    }

    /**
     * Returns the category
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\Category $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the category
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $category
     * @return void
     */
    public function setCategory(\Chancenportal\Chancenportal\Domain\Model\Category $category)
    {
        $this->category = $category;
    }
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Returns the offer
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\Offer offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Sets the offer
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     * @return void
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }
}
