<?php
namespace Chancenportal\Chancenportal\Domain\Model;

use Chancenportal\Chancenportal\Utility\ImageUtility;
use TYPO3\CMS\Core\Resource\FileReference;
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
 * Provider
 */
class Provider extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var bool
     */
    protected $preview = false;

    /**
     * @var string
     */
    protected $contentImageString = null;

    /**
     * @var string
     */
    protected $logoString = null;

    /**
     * @var string
     */
    protected $contactImageString = null;

    /**
     * @var \DateTime
     */
    protected $tstamp = null;

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * @var bool
     */
    public $approvedChanged = false;

    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * subline
     *
     * @var string
     */
    protected $subline = '';

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
     * numberOfEmployees
     *
     * @var int
     */
    protected $numberOfEmployees = 0;

    /**
     * participation
     *
     * @var int
     */
    protected $participation = 0;

    /**
     * contentImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $contentImage = null;

    /**
     * logo
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @cascade remove
     */
    protected $logo = null;

    /**
     * street
     *
     * @var string
     * @validate NotEmpty
     */
    protected $street = '';

    /**
     * city
     *
     * @var string
     * @validate NotEmpty
     */
    protected $city = '';

    /**
     * email
     *
     * @var string
     * @validate NotEmpty
     */
    protected $email = '';

    /**
     * website
     *
     * @var string
     */
    protected $website = '';

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
     * phone
     *
     * @var string
     */
    protected $phone = '';

    /**
     * phone2
     *
     * @var string
     */
    protected $phone2 = '';

    /**
     * openingHours
     *
     * @var string
     */
    protected $openingHours = '';

    /**
     * active
     *
     * @var bool
     */
    protected $active = false;

    /**
     * zip
     *
     * @var string
     */
    protected $zip = '';

    /**
     * address
     *
     * @var string
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
     * approved
     *
     * @var bool
     */
    protected $approved = false;

    /**
     * reminderEmailSend
     *
     * @var bool
     */
    protected $reminderEmailSend = false;

    /**
     * labels
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Label>
     * @lazy
     * @cascade remove
     */
    protected $labels = null;

    /**
     * offers
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Offer>
     * @lazy
     * @cascade remove
     */
    protected $offers = null;

    /**
     * ownerGroup
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup
     * @lazy
     * @cascade remove
     */
    protected $ownerGroup = null;

    /**
     * carrier
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\Carrier
     * @lazy
     */
    protected $carrier = null;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Category>
     * @lazy
     */
    protected $categories = null;

    /**
     * creator
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUser
     * @lazy
     */
    protected $creator = null;

    /**
     * author
     *
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUser
     * @lazy
     */
    protected $author = null;

    /**
     * contentImageCopyright
     *
     * @var string
     */
    protected $contentImageCopyright = '';

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
    public function getCityOnly()
    {
        return substr($this->city, strpos($this->city, ' '));
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
     * Returns the categories
     */
    public function getCategories()
    {
        return $this->categories;
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
        return $this->longDescription;
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
     * Returns the subline
     *
     * @return string subline
     */
    public function getSubline()
    {
        return $this->subline;
    }

    /**
     * Sets the subline
     *
     * @param string $subline
     * @return void
     */
    public function setSubline($subline)
    {
        $this->subline = $subline;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $setting = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $this->setPid($setting['chancenportal']['storagePids']['provider']);
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
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
        $this->contentImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->logo = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->contactImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->labels = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->offers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the numberOfEmployees
     *
     * @return int $numberOfEmployees
     */
    public function getNumberOfEmployees()
    {
        return $this->numberOfEmployees;
    }

    /**
     * Sets the numberOfEmployees
     *
     * @param int $numberOfEmployees
     * @return void
     */
    public function setNumberOfEmployees($numberOfEmployees)
    {
        $this->numberOfEmployees = $numberOfEmployees;
    }

    /**
     * Returns the participation
     *
     * @return int $participation
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * Sets the participation
     *
     * @param int $participation
     * @return void
     */
    public function setParticipation($participation)
    {
        $this->participation = $participation;
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
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the website
     *
     * @return string $website
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Sets the website
     *
     * @param string $website
     * @return void
     */
    public function setWebsite($website)
    {
        $this->website = $website;
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
     * Adds a Label
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Label $label
     * @return void
     */
    public function addLabel(\Chancenportal\Chancenportal\Domain\Model\Label $label)
    {
        $this->labels->attach($label);
    }

    /**
     * Removes a Label
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Label $labelToRemove The Label to be removed
     * @return void
     */
    public function removeLabel(\Chancenportal\Chancenportal\Domain\Model\Label $labelToRemove)
    {
        $this->labels->detach($labelToRemove);
    }

    /**
     * Returns the labels
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Label> $labels
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Sets the labels
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Label> $labels
     * @return void
     */
    public function setLabels(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $labels)
    {
        foreach ($labels as $label) {
            if (empty(trim($label->getName()))) {
                $labels->detach($label);
            }
        }
        $this->labels = $labels;
    }

    /**
     * Returns the carrier
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\Carrier $carrier
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param \Chancenportal\Chancenportal\Domain\Model\Carrier $carrier
     */
    public function setCarrier(\Chancenportal\Chancenportal\Domain\Model\Carrier $carrier = null)
    {
        $this->carrier = $carrier;
    }

    /**
     * Returns the ownerGroup
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup $ownerGroup
     */
    public function getOwnerGroup()
    {
        return $this->ownerGroup;
    }

    /**
     * Sets the ownerGroup
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup $ownerGroup
     * @return void
     */
    public function setOwnerGroup(\Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup $ownerGroup)
    {
        $this->ownerGroup = $ownerGroup;
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
     * @return bool
     */
    private function _isPreview()
    {
        $data = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_chancenportal_chancenportal');
        return boolval($data['provider']['preview']) || $data['action'] === 'providerPreviewRedirect';
    }

    /**
     * @return string
     */
    public function getLogoString()
    {
        return $this->logoString;
    }

    /**
     * @param string $logoString
     */
    public function setLogoString($logoString)
    {
        $logoString = json_decode($logoString);
        foreach ($logoString as $image) {
            if ($this->_isPreview()) {
                if ($image->deleted) {
                    $this->logoString = null;
                } else {
                    if (is_numeric($logoString) && $this->getLogo()) {
                        $this->logoString = (ImageUtility::isPng($this->getLogo()->getOriginalResource()->getContents()) ? 'data:image/png' : 'data:image/jpeg') . ';base64,' . base64_encode($this->getLogo()->getOriginalResource()->getContents());
                    } else {
                        $this->logoString = $image->dataUrl;
                    }
                }
            } else {
                if ($image->deleted === false && !is_numeric($image->dataUrl)) {
                    $ref = ImageUtility::handleBase64Image($this, $image->dataUrl, $image->name, 'offer/');
                    $this->logo->attach($ref);
                } elseif ($image->deleted) {
                    foreach ($this->logo as $img) {
                        if ($img->getUid() === $image->dataUrl) {
                            $this->deleteImage($img);
                            $this->logo->detach($img);
                        }
                    }
                }
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
                    if (is_numeric($image->dataUrl) && $this->getContactImage()) {
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
     * @return null|\TYPO3\CMS\Extbase\Domain\Model\FileReference
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
     * @return null|\TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getContactImage()
    {
        return $this->contactImage->count() ? $this->contactImage->current() : null;
    }

    /**
     * Sets the contactImage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $contactImage
     * @return void
     */
    public function setContactImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $contactImage)
    {
        $this->contactImage = $contactImage;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     * @return void
     */
    public function addLogo(\TYPO3\CMS\Extbase\Domain\Model\FileReference $logo)
    {
        $this->logo->attach($logo);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logoToRemove The FileReference to be removed
     * @return void
     */
    public function removeLogo(\TYPO3\CMS\Extbase\Domain\Model\FileReference $logoToRemove)
    {
        $this->logo->detach($logoToRemove);
    }

    /**
     * @return null|\TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getLogo()
    {
        return $this->logo->count() ? $this->logo->current() : null;
    }

    /**
     * Sets the logo
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $logo
     * @return void
     */
    public function setLogo(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return array
     */
    public function getActiveOffers()
    {
        $now = new \DateTime('midnight');
        $offers = [];
        foreach ($this->getOffers() as $offer) {
            if ($offer->getApproved() && $offer->getActive()) {
                if ($offer->getDateType() === 0) {
                    $offers[$offer->getUid()] = $offer;
                } else {
                    foreach ($offer->getDates() as $date) {
                        if ($date->getEndDate() >= $now) {
                            $offers[$offer->getUid()] = $offer;
                        }
                    }
                }
            }
        }
        return $offers;
    }

    /**
     * @return array
     */
    public function getInActiveOffers()
    {
        $now = new \DateTime('midnight');
        $offers = [];
        foreach ($this->getOffers() as $offer) {
            if ($offer->getApproved() && $offer->getActive()) {
                if ($offer->getDateType() !== 0) {
                    foreach ($offer->getDates() as $date) {
                        if ($date->getEndDate() && $date->getEndDate() < $now) {
                            $offers[$offer->getUid()] = $offer;
                        }
                    }
                }
            }
        }
        return $offers;
    }

    /**
     * Returns the phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the openingHours
     *
     * @return string $openingHours
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Sets the openingHours
     *
     * @param string $openingHours
     * @return void
     */
    public function setOpeningHours($openingHours)
    {
        $this->openingHours = $openingHours;
    }

    /**
     * Returns the phone2
     *
     * @return string $phone2
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Sets the phone2
     *
     * @param string $phone2
     * @return void
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
    }

    /**
     * Adds a Offer
     *
     * @ignorevalidation $offer
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offer
     * @return void
     */
    public function addOffer($offer)
    {
        $this->offers->attach($offer);
    }

    /**
     * Removes a Offer
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\Offer $offerToRemove The Offer to be removed
     * @return void
     */
    public function removeOffer($offerToRemove)
    {
        $this->offers->detach($offerToRemove);
    }

    /**
     * Returns the offers
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Offer> offers
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Sets the offers
     *
     * @ignorevalidation $offers
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Chancenportal\Chancenportal\Domain\Model\Offer> $offers
     * @return void
     */
    public function setOffers(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $offers)
    {
        $this->offers = $offers;
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
        $this->creator = $creator;
    }

    /**
     * Returns the author
     *
     * @return \Chancenportal\Chancenportal\Domain\Model\FrontendUser $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param \Chancenportal\Chancenportal\Domain\Model\FrontendUser $author
     * @return void
     */
    public function setAuthor(\Chancenportal\Chancenportal\Domain\Model\FrontendUser $author)
    {
        $this->author = $author;
    }

    /**
     * Returns the approved
     *
     * @return bool $approved
     */
    public function getApproved()
    {
        return $this->approved;
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
