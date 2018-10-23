<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class OfferTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Offer
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\Offer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAddressReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAddress()
        );
    }

    /**
     * @test
     */
    public function setAddressForStringSetsAddress()
    {
        $this->subject->setAddress('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'address',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLatReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLat()
        );
    }

    /**
     * @test
     */
    public function setLatForStringSetsLat()
    {
        $this->subject->setLat('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lat',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLngReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLng()
        );
    }

    /**
     * @test
     */
    public function setLngForStringSetsLng()
    {
        $this->subject->setLng('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'lng',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInfoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getInfo()
        );
    }

    /**
     * @test
     */
    public function setInfoForStringSetsInfo()
    {
        $this->subject->setInfo('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'info',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getShortDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getShortDescription()
        );
    }

    /**
     * @test
     */
    public function setShortDescriptionForStringSetsShortDescription()
    {
        $this->subject->setShortDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'shortDescription',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLongDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLongDescription()
        );
    }

    /**
     * @test
     */
    public function setLongDescriptionForStringSetsLongDescription()
    {
        $this->subject->setLongDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'longDescription',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSpeakerReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSpeaker()
        );
    }

    /**
     * @test
     */
    public function setSpeakerForStringSetsSpeaker()
    {
        $this->subject->setSpeaker('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'speaker',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImagesReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getImages()
        );
    }

    /**
     * @test
     */
    public function setImagesForFileReferenceSetsImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneImages = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneImages->attach($image);
        $this->subject->setImages($objectStorageHoldingExactlyOneImages);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneImages,
            'images',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addImageToObjectStorageHoldingImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($image));
        $this->inject($this->subject, 'images', $imagesObjectStorageMock);

        $this->subject->addImage($image);
    }

    /**
     * @test
     */
    public function removeImageFromObjectStorageHoldingImages()
    {
        $image = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $imagesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $imagesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($image));
        $this->inject($this->subject, 'images', $imagesObjectStorageMock);

        $this->subject->removeImage($image);
    }

    /**
     * @test
     */
    public function getYoutubeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getYoutube()
        );
    }

    /**
     * @test
     */
    public function setYoutubeForStringSetsYoutube()
    {
        $this->subject->setYoutube('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'youtube',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConditionsOfParticipationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getConditionsOfParticipation()
        );
    }

    /**
     * @test
     */
    public function setConditionsOfParticipationForStringSetsConditionsOfParticipation()
    {
        $this->subject->setConditionsOfParticipation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'conditionsOfParticipation',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCourseNumberReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCourseNumber()
        );
    }

    /**
     * @test
     */
    public function setCourseNumberForStringSetsCourseNumber()
    {
        $this->subject->setCourseNumber('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'courseNumber',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAllowedParticipantsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAllowedParticipants()
        );
    }

    /**
     * @test
     */
    public function setAllowedParticipantsForStringSetsAllowedParticipants()
    {
        $this->subject->setAllowedParticipants('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'allowedParticipants',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCostsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCosts()
        );
    }

    /**
     * @test
     */
    public function setCostsForStringSetsCosts()
    {
        $this->subject->setCosts('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'costs',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAllAgesReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getAllAges()
        );
    }

    /**
     * @test
     */
    public function setAllAgesForBoolSetsAllAges()
    {
        $this->subject->setAllAges(true);

        self::assertAttributeEquals(
            true,
            'allAges',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAccessReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getAccess()
        );
    }

    /**
     * @test
     */
    public function setAccessForIntSetsAccess()
    {
        $this->subject->setAccess(12);

        self::assertAttributeEquals(
            12,
            'access',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAccessibilityReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getAccessibility()
        );
    }

    /**
     * @test
     */
    public function setAccessibilityForIntSetsAccessibility()
    {
        $this->subject->setAccessibility(12);

        self::assertAttributeEquals(
            12,
            'accessibility',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getParticipateReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getParticipate()
        );
    }

    /**
     * @test
     */
    public function setParticipateForStringSetsParticipate()
    {
        $this->subject->setParticipate('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'participate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDonateReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDonate()
        );
    }

    /**
     * @test
     */
    public function setDonateForStringSetsDonate()
    {
        $this->subject->setDonate('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'donate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getProviderCooperationReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getProviderCooperation()
        );
    }

    /**
     * @test
     */
    public function setProviderCooperationForStringSetsProviderCooperation()
    {
        $this->subject->setProviderCooperation('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'providerCooperation',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFormatReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFormat()
        );
    }

    /**
     * @test
     */
    public function setFormatForStringSetsFormat()
    {
        $this->subject->setFormat('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'format',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNoCostsReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getNoCosts()
        );
    }

    /**
     * @test
     */
    public function setNoCostsForBoolSetsNoCosts()
    {
        $this->subject->setNoCosts(true);

        self::assertAttributeEquals(
            true,
            'noCosts',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactSalutationReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getContactSalutation()
        );
    }

    /**
     * @test
     */
    public function setContactSalutationForIntSetsContactSalutation()
    {
        $this->subject->setContactSalutation(12);

        self::assertAttributeEquals(
            12,
            'contactSalutation',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContactName()
        );
    }

    /**
     * @test
     */
    public function setContactNameForStringSetsContactName()
    {
        $this->subject->setContactName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contactName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactJurisdictionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContactJurisdiction()
        );
    }

    /**
     * @test
     */
    public function setContactJurisdictionForStringSetsContactJurisdiction()
    {
        $this->subject->setContactJurisdiction('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contactJurisdiction',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactPhoneReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContactPhone()
        );
    }

    /**
     * @test
     */
    public function setContactPhoneForStringSetsContactPhone()
    {
        $this->subject->setContactPhone('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contactPhone',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContactEmail()
        );
    }

    /**
     * @test
     */
    public function setContactEmailForStringSetsContactEmail()
    {
        $this->subject->setContactEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contactEmail',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContactImageReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getContactImage()
        );
    }

    /**
     * @test
     */
    public function setContactImageForFileReferenceSetsContactImage()
    {
        $contactImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneContactImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneContactImage->attach($contactImage);
        $this->subject->setContactImage($objectStorageHoldingExactlyOneContactImage);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneContactImage,
            'contactImage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addContactImageToObjectStorageHoldingContactImage()
    {
        $contactImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $contactImageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contactImageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($contactImage));
        $this->inject($this->subject, 'contactImage', $contactImageObjectStorageMock);

        $this->subject->addContactImage($contactImage);
    }

    /**
     * @test
     */
    public function removeContactImageFromObjectStorageHoldingContactImage()
    {
        $contactImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $contactImageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contactImageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($contactImage));
        $this->inject($this->subject, 'contactImage', $contactImageObjectStorageMock);

        $this->subject->removeContactImage($contactImage);
    }

    /**
     * @test
     */
    public function getActiveReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getActive()
        );
    }

    /**
     * @test
     */
    public function setActiveForBoolSetsActive()
    {
        $this->subject->setActive(true);

        self::assertAttributeEquals(
            true,
            'active',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getContentImageReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getContentImage()
        );
    }

    /**
     * @test
     */
    public function setContentImageForFileReferenceSetsContentImage()
    {
        $contentImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneContentImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneContentImage->attach($contentImage);
        $this->subject->setContentImage($objectStorageHoldingExactlyOneContentImage);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneContentImage,
            'contentImage',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addContentImageToObjectStorageHoldingContentImage()
    {
        $contentImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $contentImageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contentImageObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($contentImage));
        $this->inject($this->subject, 'contentImage', $contentImageObjectStorageMock);

        $this->subject->addContentImage($contentImage);
    }

    /**
     * @test
     */
    public function removeContentImageFromObjectStorageHoldingContentImage()
    {
        $contentImage = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $contentImageObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contentImageObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($contentImage));
        $this->inject($this->subject, 'contentImage', $contentImageObjectStorageMock);

        $this->subject->removeContentImage($contentImage);
    }

    /**
     * @test
     */
    public function getActiveDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getActiveDate()
        );
    }

    /**
     * @test
     */
    public function setActiveDateForDateTimeSetsActiveDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setActiveDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'activeDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getZipReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZip()
        );
    }

    /**
     * @test
     */
    public function setZipForStringSetsZip()
    {
        $this->subject->setZip('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'zip',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCityReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->subject->setCity('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'city',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStreetReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStreet()
        );
    }

    /**
     * @test
     */
    public function setStreetForStringSetsStreet()
    {
        $this->subject->setStreet('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'street',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getApprovedReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getApproved()
        );
    }

    /**
     * @test
     */
    public function setApprovedForBoolSetsApproved()
    {
        $this->subject->setApproved(true);

        self::assertAttributeEquals(
            true,
            'approved',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDateTypeReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getDateType()
        );
    }

    /**
     * @test
     */
    public function setDateTypeForIntSetsDateType()
    {
        $this->subject->setDateType(12);

        self::assertAttributeEquals(
            12,
            'dateType',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getStartDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getStartDate()
        );
    }

    /**
     * @test
     */
    public function setStartDateForDateTimeSetsStartDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setStartDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'startDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEndDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getEndDate()
        );
    }

    /**
     * @test
     */
    public function setEndDateForDateTimeSetsEndDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setEndDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'endDate',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getReminderEmailSendReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getReminderEmailSend()
        );
    }

    /**
     * @test
     */
    public function setReminderEmailSendForBoolSetsReminderEmailSend()
    {
        $this->subject->setReminderEmailSend(true);

        self::assertAttributeEquals(
            true,
            'reminderEmailSend',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDatesReturnsInitialValueForDate()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDates()
        );
    }

    /**
     * @test
     */
    public function setDatesForObjectStorageContainingDateSetsDates()
    {
        $date = new \Chancenportal\Chancenportal\Domain\Model\Date();
        $objectStorageHoldingExactlyOneDates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDates->attach($date);
        $this->subject->setDates($objectStorageHoldingExactlyOneDates);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneDates,
            'dates',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addDateToObjectStorageHoldingDates()
    {
        $date = new \Chancenportal\Chancenportal\Domain\Model\Date();
        $datesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $datesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($date));
        $this->inject($this->subject, 'dates', $datesObjectStorageMock);

        $this->subject->addDate($date);
    }

    /**
     * @test
     */
    public function removeDateFromObjectStorageHoldingDates()
    {
        $date = new \Chancenportal\Chancenportal\Domain\Model\Date();
        $datesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $datesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($date));
        $this->inject($this->subject, 'dates', $datesObjectStorageMock);

        $this->subject->removeDate($date);
    }

    /**
     * @test
     */
    public function getTargetGroupsReturnsInitialValueForTargetGroup()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getTargetGroups()
        );
    }

    /**
     * @test
     */
    public function setTargetGroupsForObjectStorageContainingTargetGroupSetsTargetGroups()
    {
        $targetGroup = new \Chancenportal\Chancenportal\Domain\Model\TargetGroup();
        $objectStorageHoldingExactlyOneTargetGroups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneTargetGroups->attach($targetGroup);
        $this->subject->setTargetGroups($objectStorageHoldingExactlyOneTargetGroups);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneTargetGroups,
            'targetGroups',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addTargetGroupToObjectStorageHoldingTargetGroups()
    {
        $targetGroup = new \Chancenportal\Chancenportal\Domain\Model\TargetGroup();
        $targetGroupsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $targetGroupsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($targetGroup));
        $this->inject($this->subject, 'targetGroups', $targetGroupsObjectStorageMock);

        $this->subject->addTargetGroup($targetGroup);
    }

    /**
     * @test
     */
    public function removeTargetGroupFromObjectStorageHoldingTargetGroups()
    {
        $targetGroup = new \Chancenportal\Chancenportal\Domain\Model\TargetGroup();
        $targetGroupsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $targetGroupsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($targetGroup));
        $this->inject($this->subject, 'targetGroups', $targetGroupsObjectStorageMock);

        $this->subject->removeTargetGroup($targetGroup);
    }

    /**
     * @test
     */
    public function getCategoriesReturnsInitialValueForCategory()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getCategories()
        );
    }

    /**
     * @test
     */
    public function setCategoriesForObjectStorageContainingCategorySetsCategories()
    {
        $category = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $objectStorageHoldingExactlyOneCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCategories->attach($category);
        $this->subject->setCategories($objectStorageHoldingExactlyOneCategories);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneCategories,
            'categories',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addCategoryToObjectStorageHoldingCategories()
    {
        $category = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $categoriesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoriesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($category));
        $this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

        $this->subject->addCategory($category);
    }

    /**
     * @test
     */
    public function removeCategoryFromObjectStorageHoldingCategories()
    {
        $category = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $categoriesObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoriesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($category));
        $this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

        $this->subject->removeCategory($category);
    }

    /**
     * @test
     */
    public function getDistrictReturnsInitialValueForDistrict()
    {
        self::assertEquals(
            null,
            $this->subject->getDistrict()
        );
    }

    /**
     * @test
     */
    public function setDistrictForDistrictSetsDistrict()
    {
        $districtFixture = new \Chancenportal\Chancenportal\Domain\Model\District();
        $this->subject->setDistrict($districtFixture);

        self::assertAttributeEquals(
            $districtFixture,
            'district',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCreatorReturnsInitialValueForFrontendUser()
    {
        self::assertEquals(
            null,
            $this->subject->getCreator()
        );
    }

    /**
     * @test
     */
    public function setCreatorForFrontendUserSetsCreator()
    {
        $creatorFixture = new \Chancenportal\Chancenportal\Domain\Model\FrontendUser();
        $this->subject->setCreator($creatorFixture);

        self::assertAttributeEquals(
            $creatorFixture,
            'creator',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLastEditorReturnsInitialValueForFrontendUser()
    {
        self::assertEquals(
            null,
            $this->subject->getLastEditor()
        );
    }

    /**
     * @test
     */
    public function setLastEditorForFrontendUserSetsLastEditor()
    {
        $lastEditorFixture = new \Chancenportal\Chancenportal\Domain\Model\FrontendUser();
        $this->subject->setLastEditor($lastEditorFixture);

        self::assertAttributeEquals(
            $lastEditorFixture,
            'lastEditor',
            $this->subject
        );
    }
}
