<?php
namespace Chancenportal\Chancenportal\Domain\Model;

use Chancenportal\Chancenportal\Utility\ImageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
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
 * Offer
 */
class Offer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Repository\TargetGroupRepository
     * @inject
     */
    protected $targetGroupRepository = null;

    /**
     * @var bool
     */
    protected $preview = false;

    /**
     * @var \DateTime
     */
    protected $tstamp = null;

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * @var string
     */
    protected $contentImageString = null;

    /**
     * @var string
     */
    protected $contactImageString = null;

    /**
     * @var string
     */
    protected $imagesString = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $imagesPreview = null;

    /**
     * @var bool
     */
    public $creatorChanged = false;

    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Provider
     * @lazy
     */
    protected $provider = null;

    /**
     * @var bool|null
     */
    public $activeBeforeUpdate = null;

    /**
     * @var bool
     */
    public $approvedChanged = false;

    /**
     * @var bool
     */
    public $activeChanged = false;

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * address
     *
     * @var string
     * @validate NotEmpty
     */
    protected $address = '';

    /**
     * lat
     *
     * @var string
     */
    protected $lat = '';

    /**
     * lng
     *
     * @var string
     */
    protected $lng = '';

    /**
     * info
     *
     * @var string
     */
    protected $info = '';

    /**
     * shortDescription
     *
     * @var string
     * @validate NotEmpty
     */
    protected $shortDescription = '';

    /**
     * longDescription
     *
     * @var string
     */
    protected $longDescription = '';

    /**
     * speaker
     *
     * @var string
     */
    protected $speaker = '';

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $images = null;

    /**
     * youtube
     *
     * @var string
     */
    protected $youtube = '';

    /**
     * conditionsOfParticipation
     *
     * @var string
     */
    protected $conditionsOfParticipation = '';

    /**
     * courseNumber
     *
     * @var string
     */
    protected $courseNumber = '';

    /**
     * allowedParticipants
     *
     * @var string
     */
    protected $allowedParticipants = '';

    /**
     * costs
     *
     * @var string
     */
    protected $costs = '';

    /**
     * allAges
     *
     * @var bool
     */
    protected $allAges = false;

    /**
     * access
     *
     * @var int
     */
    protected $access = 0;

    /**
     * accessibility
     *
     * @var int
     */
    protected $accessibility = false;

    /**
     * participate
     *
     * @var string
     */
    protected $participate = '';

    /**
     * donate
     *
     * @var string
     */
    protected $donate = '';

    /**
     * providerCooperation
     *
     * @var string
     */
    protected $providerCooperation = '';

    /**
     * format
     *
     * @var string
     */
    protected $format = '';

    /**
     * noCosts
     *
     * @var bool
     */
    protected $noCosts = false;

    /**
     * contactSalutation
     *
     * @var int
     */
    protected $contactSalutation = 0;

    /**
     * contactName
     *
     * @var string
     */
    protected $contactName = '';

    /**
     * contactJurisdiction
     *
     * @var string
     */
    protected $contactJurisdiction = '';

    /**
     * contactPhone
     *
     * @var string
     */
    protected $contactPhone = '';

    /**
     * contactEmail
     *
     * @var string
     */
    protected $contactEmail = '';

    /**
     * contactImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $contactImage = null;

    /**
     * active
     *
     * @var bool
     */
    protected $active = false;

    /**
     * contentImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $contentImage = null;

    /**
     * activeDate
     *
     * @var \DateTime
     */
    protected $activeDate = null;

    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * street
     *
     * @var string
     */
    protected $street = '';

    /**
     * approved
     *
     * @var bool
     */
    protected $approved = false;

    /**
     * dateType
     *
     * @var int
     */
    protected $dateType = 0;

    /**
     * startDate
     *
     * @var \DateTime
     */
    protected $startDate = null;

    /**
     * endDate
     *
     * @var \DateTime
     */
    protected $endDate = null;

    /**
     * reminderEmailSend
     *
     * @var bool
     */
    protected $reminderEmailSend = false;

    /**
     * imagesCopyright
     *
     * @var string
     */
    protected $imagesCopyright = '';

    /**
     * contentImageCopyright
     *
     * @var string
     */
    protected $contentImageCopyright = '';

    /**
     * dates
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Date>
     * @lazy
     * @cascade remove
     */
    protected $dates = null;

    /**
     * targetGroups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\TargetGroup>
     * @lazy
     * @cascade remove
     */
    protected $targetGroups = null;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category>
     * @lazy
     * @cascade remove
     */
    protected $categories = null;

    /**
     * district
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\District
     * @lazy
     */
    protected $district = null;

    /**
     * creator
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUser
     * @lazy
     */
    protected $creator = null;

    /**
     * lastEditor
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUser
     * @lazy
     */
    protected $lastEditor = null;

    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * @param \DateTime $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return bool
     */
    public function isCreatorChanged()
    {
        return $this->creatorChanged;
    }

    /**
     * @param bool $creatorChanged
     */
    public function setCreatorChanged($creatorChanged)
    {
        $this->creatorChanged = $creatorChanged;
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param Provider $provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getTheme()
    {
        $mainCat = $this->getMainCategory();
        return $mainCat ? $mainCat->getUid() : null;
    }

    /**
     * @return ObjectStorage
     */
    public function getImagesPreview()
    {
        return $this->imagesPreview;
    }

    /**
     * @param ObjectStorage $imagesPreview
     */
    public function setImagesPreview($imagesPreview)
    {
        $this->imagesPreview = $imagesPreview;
    }

    /**
     * @return string
     */
    public function getImagesString()
    {
        return $this->imagesString;
    }

    /**
     * @param string $imagesString
     */
    public function setImagesString($imagesString)
    {
        $imagesString = json_decode($imagesString);
        $tmpStorage = new ObjectStorage();
        foreach ($imagesString as $image) {
            if ($this->_isPreview()) {
                if ($image->deleted === false && !is_numeric($image->dataUrl)) {
                    $tmpStorage->attach($image);
                } elseif (count($this->getImages()) && $image->deleted === false) {
                    $img = $this->getFileRefByUid($this->getImages(), $image->dataUrl);
                    $image->dataUrl = (ImageUtility::isPng($img->getOriginalResource()->getContents()) ? 'data:image/png' : 'data:image/jpeg') . ';base64,' . base64_encode($img->getOriginalResource()->getContents());
                    $tmpStorage->attach($image);
                }
            } else {
                if ($image->deleted === false && !is_numeric($image->dataUrl)) {
                    $ref = ImageUtility::handleBase64Image($this, $image->dataUrl, $image->name, 'offer/');
                    $this->images->attach($ref);
                } elseif ($image->deleted) {
                    foreach ($this->getImages() as $img) {
                        if ($img->getUid() === $image->dataUrl) {
                            $this->deleteImage($img);
                            $this->images->detach($img);
                        }
                    }
                }
            }
        }
        if ($this->_isPreview()) {
            $this->setImagesPreview($tmpStorage);
        }
    }

    /**
     * @param $images
     * @param $uid
     * @return mixed
     */
    private function getFileRefByUid($images, $uid)
    {
        foreach ($images as $img) {
            if ($img->getUid() === intval($uid)) {
                return $img;
            }
        }
    }

    /**
     * @return string
     */
    public function getContactImageString()
    {
        return $this->contactImageString;
    }

    /**
     * @param Date $date
     * @param Date $dateItem
     * @return \DateTime
     */
    private function addTimeToNextDate($date, Date $dateItem)
    {
        $time = $dateItem->getStartTimeObj();
        return $time ? $date->modify('+' . $time . ' seconds') : $date;
    }

    /**
     * @return \DateTime|null
     */
    public function getNextDate()
    {
        $now = new \DateTime('midnight');
        $latestDate = null;
        $latestDateObj = null;
        // täglich
        if ($this->getDateType() == 3) {
            foreach ($this->dates as $date) {
                if ($date->getStartDate() <= $now && $date->getEndDate() >= $now) {
                    $newDate = clone $date;
                    $newDate->setStartDate($now);
                    $latestDate = clone $newDate->getStartDate();
                    $latestDateObj = clone $newDate;
                    break;
                } elseif (!$latestDate || $date->getStartDate() > $now && $latestDate < $date->getStartDate()) {
                    $latestDate = clone $date->getStartDate();
                    $latestDateObj = clone $date;
                }
            }
            return $latestDate ? $this->addTimeToNextDate($latestDate, $latestDateObj) : $now;
        }
        // konkrete Daten / Zeitraum
        if ($this->getDateType() == 1) {
            foreach ($this->dates as $date) {
                if ($date->getStartDate() >= $now) {
                    if (!$latestDate || $latestDate > $date->getStartDate()) {
                        $latestDate = clone $date->getStartDate();
                        $latestDateObj = clone $date;
                    }
                }
            }
            return $latestDate ? $this->addTimeToNextDate($latestDate, $latestDateObj) : $now;
        }
        if ($this->getDateType() == 2) {
            foreach ($this->dates as $date) {
                if (!$latestDate || $date->getStartDate() < $latestDate && $date->getStartDate() >= $now || $date->getStartDate() > $latestDate && $latestDate < $now || $date->getEndDate() > $latestDate && $date->getEndDate() <= $now) {
                    $latestDate = clone $date->getStartDate();
                    $latestDateObj = clone $date;
                }
            }
            return $latestDate ? $this->addTimeToNextDate($latestDate, $latestDateObj) : $now;
        }
        // Wöchentlich
        if ($this->getDateType() == 4) {
            $result = $this->getNextDateFromWeekly();
        }
        return $now->modify('+10 years');
    }

    /**
     * @throws \Exception
     * @return \DateTime
     */
    private function getNextDateFromWeekly()
    {
        $now = new \DateTime('midnight');
        $firstDayThisWeek = (new \DateTime('midnight'))->modify('monday this week');
        $oldestDate = null;
        $weekdays = [];
        // get the oldest date and the supported weekdays
        foreach ($this->getDates() as $date) {
            if ($date->getActive() && $date->getStartDate()) {
                $day = intval($date->getStartDate()->format('N'));
                $weekdays[$day] = $date;
                if (!$oldestDate || $oldestDate->getStartDate() > $date->getStartDate()) {
                    $oldestDate = $date;
                }
            }
        }
        // sort weekdays
        ksort($weekdays);
        if (!$oldestDate) {
            return $now;
        }
        if ($oldestDate->getStartDate() < $now) {
            $nowWeekday = intval($now->format('N'));
            $cDate = null;
            // is the current weekday set the
            if (isset($weekdays[$nowWeekday])) {
                $firstDayThisWeek->modify('+' . ($nowWeekday - 1) . 'days');
                $now = $firstDayThisWeek;
                $cDate = $weekdays[$nowWeekday];
            } else {
                // check if there are weekdays that are greather than now
                foreach ($weekdays as $day => $date) {
                    $iterate = clone $firstDayThisWeek;
                    $iterate->modify('+' . ($day - 1) . 'days');
                    if ($iterate >= $now) {
                        $now = $iterate;
                        $cDate = $date;
                        break;
                    }
                }
                if ($cDate === null) {
                    // set the first day of $weekdays to the next date
                    foreach ($weekdays as $day => $date) {
                        $iterate = clone $firstDayThisWeek;
                        $iterate->modify('+' . ($day - 1) . 'days +1 week');
                        $now = $iterate;
                        $cDate = $date;
                        break;
                    }
                }
            }
            if ($cDate->getStartTimeObj()) {
                $now->modify('+' . $cDate->getStartTimeObj() . ' seconds');
            }
            return $cDate;
        }
        if ($oldestDate->getStartTimeObj()) {
            $oldestDate->getStartDate()->modify('+' . $oldestDate->getStartTimeObj() . ' seconds');
        }
        return $oldestDate->getStartDate();
    }

    /**
     * @param string $contactImageString
     */
    public function setContactImageString($contactImageString)
    {
        $contactImageString = json_decode($contactImageString);
        foreach ($contactImageString as $image) {
            if ($this->_isPreview()) {
                if ($image->deleted) {
                    $this->contactImageString = null;
                } else {
                    if (is_numeric($contactImageString) && $this->getContactImage()) {
                        $this->contactImageString = (ImageUtility::isPng($this->getContactImage()->getOriginalResource()->getContents()) ? 'data:image/png' : 'data:image/jpeg') . ';base64,' . base64_encode($this->getContactImage()->getOriginalResource()->getContents());
                    } else {
                        $this->contactImageString = $image->dataUrl;
                    }
                }
            } else {
                if ($image->deleted === false && !is_numeric($image->dataUrl)) {
                    $ref = ImageUtility::handleBase64Image($this, $image->dataUrl, $image->name, 'offer/');
                    $this->contactImage->attach($ref);
                } elseif ($image->deleted) {
                    foreach ($this->contactImage as $img) {
                        if ($img->getUid() === $image->dataUrl) {
                            $this->deleteImage($img);
                            $this->contactImage->detach($img);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getContentImageString()
    {
        return $this->contentImageString;
    }

    /**
     * @param $contentImageString
     * @return null
     */
    public function setContentImageString($contentImageString)
    {
        $contentImageString = json_decode($contentImageString);
        foreach ($contentImageString as $image) {
            if ($this->_isPreview()) {
                if ($image->deleted) {
                    $this->contentImageString = null;
                } else {
                    if (is_numeric($image->dataUrl) && $this->getContentImage()) {
                        $this->contentImageString = (ImageUtility::isPng($this->getContentImage()->getOriginalResource()->getContents()) ? 'data:image/png' : 'data:image/jpeg') . ';base64,' . base64_encode($this->getContentImage()->getOriginalResource()->getContents());
                    } else {
                        $this->contentImageString = $image->dataUrl;
                    }
                }
            } else {
                if ($image->deleted === false && !is_numeric($image->dataUrl)) {
                    $ref = ImageUtility::handleBase64Image($this, $image->dataUrl, $image->name, 'offer/');
                    $this->contentImage->attach($ref);
                } elseif ($image->deleted) {
                    foreach ($this->contentImage as $img) {
                        if ($img->getUid() === $image->dataUrl) {
                            $this->deleteImage($img);
                            $this->contentImage->detach($img);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    private function deleteImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        try {    $resourceFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
            $fileReferenceObject = $resourceFactory->getFileReferenceObject($image->getUid());
            $fileReferenceObject->getOriginalFile()->delete();
        } catch (\Exception $e) {    error_log($e->getMessage());
        }
    }

    /**
     * @return bool
     */
    private function _isPreview()
    {
        $data = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_chancenportal_chancenportal');
        return boolval($data['provider']['preview']) || $data['action'] === 'offerPreviewRedirect';
    }

    /**
     * __construct
     */
    public function __construct()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $setting = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $this->setPid($setting['chancenportal']['storagePids']['offer']);
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * @return bool
     */
    public function isPreview()
    {
        return $this->preview;
    }

    /**
     * @param bool $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->contactImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->contentImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->dates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->targetGroups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Adds a Date
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Date $date
     * @return void
     */
    public function addDate(\Chancenportal\Chancenportal\Domain\Model\Date $date)
    {
        $this->dates->attach($date);
    }

    /**
     * Removes a Date
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Date $dateToRemove The Date to be removed
     * @return void
     */
    public function removeDate(\Chancenportal\Chancenportal\Domain\Model\Date $dateToRemove)
    {
        $this->dates->detach($dateToRemove);
    }

    /**
     * Returns the dates
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Date> $dates
     */
    public function getDates()
    {
        if ($this->getDateType() !== 4) {
            $offerDates = $this->dates->toArray();
            usort($offerDates, function ($a, $b) {    return $a > $b;
                });
            $newStorage = new ObjectStorage();
            foreach ($offerDates as $offerDate) {
                $newStorage->attach($offerDate);
            }
            return $newStorage;
        }
        return $this->dates;
    }

    /**
     * Returns the dates
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Date> $dates
     */
    public function getActiveDates()
    {
        $now = new \DateTime('midnight');
        $dates = new ObjectStorage();
        foreach ($this->getDates() as $date) {
            if ($date->getStartDate() >= $now || $date->getEndDate() > $now) {
                $dates->attach($date);
            }
        }
        return $dates;
    }

    /**
     * @return null|object
     */
    public function getLatestDate()
    {
        $now = new \DateTime('midnight');
        $latestDate = null;
        foreach ($this->getDates() as $date) {
            if ($date->getStartDate() >= $now) {
                if (!$latestDate || $latestDate > $date->getStartDate()) {
                    $latestDate = $date;
                }
            }
        }
        return $latestDate;
    }

    /**
     * @param null $date
     * @return \DateTime|null
     */
    private function getStartOfWeekDate($date = null)
    {
        if ($date instanceof \DateTime) {
            $date = clone $date;
        } else {
            if (!$date) {
                $date = new \DateTime();
            } else {
                $date = new \DateTime($date);
            }
        }
        $date->setTime(0, 0, 0);
        if ($date->format('N') == 1) {
            // If the date is already a Monday, return it as-is
            return $date;
        } else {
            // Otherwise, return the date of the nearest Monday in the past
            // This includes Sunday in the previous week instead of it being the start of a new week
            return $date->modify('last monday');
        }
    }

    /**
     * Sets the dates
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Date> $dates
     * @return void
     */
    public function setDates(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $dates)
    {
        $dateType = intval($this->getDateType());
        if ($dateType === 1) {
            foreach ($dates as $date) {
                if (empty($date->getStartDate())) {
                    $dates->detach($date);
                } else {
                    $date->setEndDate($date->getStartDate());
                }
            }
        } else {
            if ($dateType === 4 && $this->getStartDate()) {
                $startDate = clone $this->getStartDate();
                $endDate = $this->getEndDate() ? clone $this->getEndDate() : null;
                $firstOfNextWeek = $this->getStartOfWeekDate($startDate)->modify('+7 days');
                $daysNextWeek = [];
                $count = 0;
                foreach ($dates as $date) {
                    $weekday = intval($startDate->format('N'));
                    $count++;
                    if ($weekday === $count) {
                        $date->setStartDate(clone $startDate);
                        if ($endDate) {
                            $date->setEndDate(clone $endDate);
                        } else {
                            $date->setEndDate(null);
                        }
                        $startDate->modify('+1 day');
                    } else {
                        $daysNextWeek[$count] = $date;
                    }
                }
                $count = 0;
                foreach ($dates as $date) {
                    $weekday = intval($firstOfNextWeek->format('N'));
                    $count++;
                    if (isset($daysNextWeek[$count]) && $weekday === $count) {
                        $firstOfNextWeek->modify('+1 day');
                        $date->setStartDate(clone $firstOfNextWeek);
                        if ($endDate) {
                            $date->setEndDate(clone $endDate);
                        }
                    }
                }
            } else {
                foreach ($dates as $date) {
                    if (empty($date->getStartDate())) {
                        $dates->detach($date);
                    }
                }
            }
        }
        $this->dates = $dates;
    }

    /**
     * Returns the address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the info
     *
     * @return string $info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Sets the info
     *
     * @param string $info
     * @return void
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * Returns the shortDescription
     *
     * @return string $shortDescription
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Sets the shortDescription
     *
     * @param string $shortDescription
     * @return void
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * Returns the longDescription
     *
     * @return string $longDescription
     */
    public function getLongDescription()
    {
        return strip_tags($this->longDescription, '<a><li><ol><ul><b><i><strong><div><br>');
    }

    /**
     * Sets the longDescription
     *
     * @param string $longDescription
     * @return void
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = strip_tags($longDescription, '<a><li><ol><ul><b><i><strong><div><br>');
    }

    /**
     * Returns the speaker
     *
     * @return string $speaker
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    /**
     * Sets the speaker
     *
     * @param string $speaker
     * @return void
     */
    public function setSpeaker($speaker)
    {
        $this->speaker = $speaker;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function addImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove The FileReference to be removed
     * @return void
     */
    public function removeImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove)
    {
        $this->images->detach($imageToRemove);
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Returns the youtube
     *
     * @return string $youtube
     */
    public function getYoutube()
    {
        if ($this->youtube) {
            preg_match('%(?:youtube(?:-nocookie)?\\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\\.be/)([^"&?/ ]{11})%i',
                $this->youtube, $match
            );
            $youtubeId = isset($match[1]) ? $match[1] : false;
            return $youtubeId ? 'https://www.youtube-nocookie.com/embed/' . $youtubeId . '?rel=0' : null;
        }
        return $this->youtube;
    }

    /**
     * Sets the youtube
     *
     * @param string $youtube
     * @return void
     */
    public function setYoutube($youtube)
    {
        $this->youtube = $youtube;
    }

    /**
     * Returns the conditionsOfParticipation
     *
     * @return string $conditionsOfParticipation
     */
    public function getConditionsOfParticipation()
    {
        return $this->conditionsOfParticipation;
    }

    /**
     * Sets the conditionsOfParticipation
     *
     * @param string $conditionsOfParticipation
     * @return void
     */
    public function setConditionsOfParticipation($conditionsOfParticipation)
    {
        $this->conditionsOfParticipation = $conditionsOfParticipation;
    }

    /**
     * Returns the courseNumber
     *
     * @return string $courseNumber
     */
    public function getCourseNumber()
    {
        return $this->courseNumber;
    }

    /**
     * Sets the courseNumber
     *
     * @param string $courseNumber
     * @return void
     */
    public function setCourseNumber($courseNumber)
    {
        $this->courseNumber = $courseNumber;
    }

    /**
     * Returns the allowedParticipants
     *
     * @return string $allowedParticipants
     */
    public function getAllowedParticipants()
    {
        return $this->allowedParticipants;
    }

    /**
     * Sets the allowedParticipants
     *
     * @param string $allowedParticipants
     * @return void
     */
    public function setAllowedParticipants($allowedParticipants)
    {
        $this->allowedParticipants = $allowedParticipants;
    }

    /**
     * Returns the costs
     *
     * @return string $costs
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * Sets the costs
     *
     * @param string $costs
     * @return void
     */
    public function setCosts($costs)
    {
        $this->costs = $costs;
    }

    /**
     * Returns the allAges
     *
     * @return bool $allAges
     */
    public function getAllAges()
    {
        return $this->allAges;
    }

    /**
     * Sets the allAges
     *
     * @param bool $allAges
     * @return void
     */
    public function setAllAges($allAges)
    {
        $this->allAges = $allAges;
    }

    /**
     * Returns the boolean state of allAges
     *
     * @return bool
     */
    public function isAllAges()
    {
        return $this->allAges;
    }

    /**
     * Returns the access
     *
     * @return int $access
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Sets the access
     *
     * @param int $access
     * @return void
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * Returns the boolean state of accessibility
     *
     * @return bool
     */
    public function isAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * Returns the participate
     *
     * @return string $participate
     */
    public function getParticipate()
    {
        return $this->participate;
    }

    /**
     * Sets the participate
     *
     * @param string $participate
     * @return void
     */
    public function setParticipate($participate)
    {
        $this->participate = $participate;
    }

    /**
     * Returns the donate
     *
     * @return string $donate
     */
    public function getDonate()
    {
        return $this->donate;
    }

    /**
     * Sets the donate
     *
     * @param string $donate
     * @return void
     */
    public function setDonate($donate)
    {
        $this->donate = $donate;
    }

    /**
     * Returns the providerCooperation
     *
     * @return string $providerCooperation
     */
    public function getProviderCooperation()
    {
        return $this->providerCooperation;
    }

    /**
     * Sets the providerCooperation
     *
     * @param string $providerCooperation
     * @return void
     */
    public function setProviderCooperation($providerCooperation)
    {
        $this->providerCooperation = $providerCooperation;
    }

    /**
     * Adds a Category
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\Chancenportal\Chancenportal\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\Chancenportal\Chancenportal\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function getMainCategory()
    {
        $mainCat = null;
        foreach ($this->categories as $cat) {
            if (!$mainCat && !$cat->getParent()) {
                $mainCat = $cat;
            } elseif (!$mainCat) {
                $mainCat = $cat->getParent();
            }
        }
        return $mainCat;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the lat
     *
     * @return string $lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Sets the lat
     *
     * @param string $lat
     * @return void
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Returns the lng
     *
     * @return string $lng
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Sets the lng
     *
     * @param string $lng
     * @return void
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * Returns the district
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\District $district
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Sets the district
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\District $district
     * @return void
     */
    public function setDistrict(\Chancenportal\Chancenportal\Domain\Model\District $district = null)
    {
        $this->district = $district;
    }

    /**
     * Returns the format
     *
     * @return string $format
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets the format
     *
     * @param string $format
     * @return void
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Returns the noCosts
     *
     * @return bool $noCosts
     */
    public function getNoCosts()
    {
        return $this->noCosts;
    }

    /**
     * Sets the noCosts
     *
     * @param bool $noCosts
     * @return void
     */
    public function setNoCosts($noCosts)
    {
        if ($noCosts) {
            $this->costs = null;
        }
        $this->noCosts = $noCosts;
    }

    /**
     * Returns the contactName
     *
     * @return string $contactName
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Sets the contactName
     *
     * @param string $contactName
     * @return void
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * Returns the contactJurisdiction
     *
     * @return string $contactJurisdiction
     */
    public function getContactJurisdiction()
    {
        return $this->contactJurisdiction;
    }

    /**
     * Sets the contactJurisdiction
     *
     * @param string $contactJurisdiction
     * @return void
     */
    public function setContactJurisdiction($contactJurisdiction)
    {
        $this->contactJurisdiction = $contactJurisdiction;
    }

    /**
     * Returns the contactPhone
     *
     * @return string $contactPhone
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    /**
     * Sets the contactPhone
     *
     * @param string $contactPhone
     * @return void
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }

    /**
     * Returns the contactEmail
     *
     * @return string $contactEmail
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Sets the contactEmail
     *
     * @param string $contactEmail
     * @return void
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * Returns the accessibility
     *
     * @return int accessibility
     */
    public function getAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * Sets the accessibility
     *
     * @param bool $accessibility
     * @return void
     */
    public function setAccessibility($accessibility)
    {
        $this->accessibility = $accessibility;
    }

    /**
     * Adds a TargetGroup
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\TargetGroup $targetGroup
     * @return void
     */
    public function addTargetGroup(\Chancenportal\Chancenportal\Domain\Model\TargetGroup $targetGroup)
    {
        $this->targetGroups->attach($targetGroup);
    }

    /**
     * Removes a TargetGroup
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\TargetGroup $targetGroupToRemove The TargetGroup to be removed
     * @return void
     */
    public function removeTargetGroup(\Chancenportal\Chancenportal\Domain\Model\TargetGroup $targetGroupToRemove)
    {
        $this->targetGroups->detach($targetGroupToRemove);
    }

    /**
     * Returns the targetGroups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\TargetGroup> targetGroups
     */
    public function getTargetGroups()
    {
        $uids = [];
        $return = new ObjectStorage();

        foreach($this->targetGroups as $targetGroup) {
            $uids[] = $targetGroup->getUid();
        }

        $sortedTargetGroups = $this->targetGroupRepository->findByUids($uids);

        foreach ($sortedTargetGroups as $targetGroup) {
            $return->attach($targetGroup);
        }

        return $return;
    }

    /**
     * Sets the targetGroups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\TargetGroup> $targetGroups
     * @return void
     */
    public function setTargetGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $targetGroups)
    {
        $this->targetGroups = $targetGroups;
    }

    /**
     * @return bool
     */
    public function isActiveBeforeUpdate()
    {
        return $this->activeBeforeUpdate;
    }

    /**
     * @param bool $activeBeforeUpdate
     */
    public function setActiveBeforeUpdate($activeBeforeUpdate)
    {
        $this->activeBeforeUpdate = $activeBeforeUpdate;
    }

    /**
     * Returns the active
     *
     * @return bool $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the active
     *
     * @param bool $active
     * @return void
     */
    public function setActive($active)
    {
        if ($this->activeBeforeUpdate === null) {
            $this->activeBeforeUpdate = $this->active;
        }
        if ($this->active !== $active) {
            $this->activeChanged = true;
        }
        if ($active === true) {
            $this->setActiveDate(new \DateTime());
        }
        $this->active = $active;
    }

    /**
     * Returns the boolean state of active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contactImage
     * @return void
     */
    public function addContactImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $contactImage)
    {
        $this->contactImage->attach($contactImage);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contactImageToRemove The FileReference to be removed
     * @return void
     */
    public function removeContactImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $contactImageToRemove)
    {
        $this->contactImage->detach($contactImageToRemove);
    }

    /**
     * @return null|object
     */
    public function getContactImage()
    {
        return $this->contactImage->count() ? $this->contactImage->current() : null;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $contactImage
     * @return null|object
     */
    public function setContactImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contactImage)
    {
        return $this->contactImage->count() ? $this->contactImage->current() : null;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentImage
     * @return void
     */
    public function addContentImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $contentImage)
    {
        $this->contentImage->attach($contentImage);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentImageToRemove The FileReference to be removed
     * @return void
     */
    public function removeContentImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $contentImageToRemove)
    {
        $this->contentImage->detach($contentImageToRemove);
    }

    /**
     * @return null|object
     */
    public function getContentImage()
    {
        return $this->contentImage->count() ? $this->contentImage->current() : null;
    }

    /**
     * Sets the contentImage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $contentImage
     * @return void
     */
    public function setContentImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contentImage)
    {
        $this->contentImage = $contentImage;
    }

    /**
     * Returns the creator
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\FrontendUser $creator
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Sets the creator
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\FrontendUser $creator
     * @return void
     */
    public function setCreator(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $creator)
    {
        if ($this->creator && $this->creator->getUid() !== $creator->getUid()) {
            $this->setActive(false);
            $this->creatorChanged = true;
        }
        $this->creator = $creator;
    }

    /**
     * Returns the lastEditor
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\FrontendUser $lastEditor
     */
    public function getLastEditor()
    {
        return $this->lastEditor;
    }

    /**
     * Sets the lastEditor
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\FrontendUser $lastEditor
     * @return void
     */
    public function setLastEditor(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $lastEditor)
    {
        $this->lastEditor = $lastEditor;
    }

    /**
     * Returns the contactSalutation
     *
     * @return int $contactSalutation
     */
    public function getContactSalutation()
    {
        return $this->contactSalutation;
    }

    /**
     * Sets the contactSalutation
     *
     * @param int $contactSalutation
     * @return void
     */
    public function setContactSalutation($contactSalutation)
    {
        $this->contactSalutation = $contactSalutation;
    }

    /**
     * Returns the activeDate
     *
     * @return \DateTime $activeDate
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * Sets the activeDate
     *
     * @param \DateTime $activeDate
     * @return void
     */
    public function setActiveDate(\DateTime $activeDate)
    {
        $this->activeDate = $activeDate;
    }

    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Returns the approved
     *
     * @return bool $approved
     */
    public function getApproved()
    {
        $configurationManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $offerApproval = $extbaseFrameworkConfiguration['config.']['tx_extbase.']['settings.']['chancenportal.']['activate_offer_approval'];
        // always approve offers if the typoscript function ist 0
        return $offerApproval === '1' ? $this->approved : true;
    }

    /**
     * Sets the approved
     *
     * @param bool $approved
     * @return void
     */
    public function setApproved($approved)
    {
        if ($this->approved === false && $approved === true) {
            $this->approvedChanged = true;
        }
        $this->approved = $approved;
    }

    /**
     * Returns the boolean state of approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * Returns the dateType
     *
     * @return int $dateType
     */
    public function getDateType()
    {
        return $this->dateType;
    }

    /**
     * Sets the dateType
     *
     * @param int $dateType
     * @return void
     */
    public function setDateType($dateType)
    {
        if ($dateType === 0) {
            $this->dates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        }
        $this->dateType = $dateType;
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
     * Sets the startDate
     *
     * @param \DateTime $startDate
     * @return void
     */
    public function setStartDate(\DateTime $startDate)
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
     * Sets the endDate
     *
     * @param \DateTime $endDate
     * @return void
     */
    public function setEndDate(\DateTime $endDate = null)
    {
        $this->endDate = $endDate;
    }

    /**
     * Returns the reminderEmailSend
     *
     * @return bool $reminderEmailSend
     */
    public function getReminderEmailSend()
    {
        return $this->reminderEmailSend;
    }

    /**
     * Sets the reminderEmailSend
     *
     * @param bool $reminderEmailSend
     * @return void
     */
    public function setReminderEmailSend($reminderEmailSend)
    {
        $this->reminderEmailSend = $reminderEmailSend;
    }

    /**
     * Returns the boolean state of reminderEmailSend
     *
     * @return bool
     */
    public function isReminderEmailSend()
    {
        return $this->reminderEmailSend;
    }

    /**
     * Returns the imagesCopyright
     *
     * @return string $imagesCopyright
     */
    public function getImagesCopyright()
    {
        return $this->imagesCopyright;
    }

    /**
     * Sets the imagesCopyright
     *
     * @param string $imagesCopyright
     * @return void
     */
    public function setImagesCopyright($imagesCopyright)
    {
        $this->imagesCopyright = $imagesCopyright;
    }

    /**
     * Returns the contentImageCopyright
     *
     * @return string $contentImageCopyright
     */
    public function getContentImageCopyright()
    {
        return $this->contentImageCopyright;
    }

    /**
     * Sets the contentImageCopyright
     *
     * @param string $contentImageCopyright
     * @return void
     */
    public function setContentImageCopyright($contentImageCopyright)
    {
        $this->contentImageCopyright = $contentImageCopyright;
    }
}
