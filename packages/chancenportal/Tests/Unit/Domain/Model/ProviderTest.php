<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class ProviderTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Provider
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\Provider();
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
    public function getSublineReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSubline()
        );
    }

    /**
     * @test
     */
    public function setSublineForStringSetsSubline()
    {
        $this->subject->setSubline('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'subline',
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
    public function getNumberOfEmployeesReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getNumberOfEmployees()
        );
    }

    /**
     * @test
     */
    public function setNumberOfEmployeesForIntSetsNumberOfEmployees()
    {
        $this->subject->setNumberOfEmployees(12);

        self::assertAttributeEquals(
            12,
            'numberOfEmployees',
            $this->subject
        );
    }

    /**
     * @test
     */
     public function getParticipationReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getParticipation()
        );
    }

    /**
     * @test
     */
    public function setParticipationForBoolSetsParticipation()
    {
        $this->subject->setParticipation(true);

        self::assertAttributeEquals(
            true,
            'participation',
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
    public function getLogoReturnsInitialValueForFileReference()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getLogo()
        );
    }

    /**
     * @test
     */
    public function setLogoForFileReferenceSetsLogo()
    {
        $logo = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $objectStorageHoldingExactlyOneLogo = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneLogo->attach($logo);
        $this->subject->setLogo($objectStorageHoldingExactlyOneLogo);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneLogo,
            'logo',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addLogoToObjectStorageHoldingLogo()
    {
        $logo = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $logoObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $logoObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($logo));
        $this->inject($this->subject, 'logo', $logoObjectStorageMock);

        $this->subject->addLogo($logo);
    }

    /**
     * @test
     */
    public function removeLogoFromObjectStorageHoldingLogo()
    {
        $logo = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $logoObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $logoObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($logo));
        $this->inject($this->subject, 'logo', $logoObjectStorageMock);

        $this->subject->removeLogo($logo);
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
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getWebsiteReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getWebsite()
        );
    }

    /**
     * @test
     */
    public function setWebsiteForStringSetsWebsite()
    {
        $this->subject->setWebsite('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'website',
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
    public function getPhoneReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone()
    {
        $this->subject->setPhone('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'phone',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPhone2ReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPhone2()
        );
    }

    /**
     * @test
     */
    public function setPhone2ForStringSetsPhone2()
    {
        $this->subject->setPhone2('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'phone2',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOpeningHoursReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getOpeningHours()
        );
    }

    /**
     * @test
     */
    public function setOpeningHoursForStringSetsOpeningHours()
    {
        $this->subject->setOpeningHours('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'openingHours',
            $this->subject
        );
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
    public function getContentImageCopyrightReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContentImageCopyright()
        );
    }

    /**
     * @test
     */
    public function setContentImageCopyrightForStringSetsContentImageCopyright()
    {
        $this->subject->setContentImageCopyright('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'contentImageCopyright',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getLabelsReturnsInitialValueForLabel()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getLabels()
        );
    }

    /**
     * @test
     */
    public function setLabelsForObjectStorageContainingLabelSetsLabels()
    {
        $label = new \Chancenportal\Chancenportal\Domain\Model\Label();
        $objectStorageHoldingExactlyOneLabels = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneLabels->attach($label);
        $this->subject->setLabels($objectStorageHoldingExactlyOneLabels);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneLabels,
            'labels',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addLabelToObjectStorageHoldingLabels()
    {
        $label = new \Chancenportal\Chancenportal\Domain\Model\Label();
        $labelsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $labelsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($label));
        $this->inject($this->subject, 'labels', $labelsObjectStorageMock);

        $this->subject->addLabel($label);
    }

    /**
     * @test
     */
    public function removeLabelFromObjectStorageHoldingLabels()
    {
        $label = new \Chancenportal\Chancenportal\Domain\Model\Label();
        $labelsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $labelsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($label));
        $this->inject($this->subject, 'labels', $labelsObjectStorageMock);

        $this->subject->removeLabel($label);
    }

    /**
     * @test
     */
    public function getOffersReturnsInitialValueForOffer()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOffers()
        );
    }

    /**
     * @test
     */
    public function setOffersForObjectStorageContainingOfferSetsOffers()
    {
        $offer = new \Chancenportal\Chancenportal\Domain\Model\Offer();
        $objectStorageHoldingExactlyOneOffers = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOffers->attach($offer);
        $this->subject->setOffers($objectStorageHoldingExactlyOneOffers);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneOffers,
            'offers',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addOfferToObjectStorageHoldingOffers()
    {
        $offer = new \Chancenportal\Chancenportal\Domain\Model\Offer();
        $offersObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $offersObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($offer));
        $this->inject($this->subject, 'offers', $offersObjectStorageMock);

        $this->subject->addOffer($offer);
    }

    /**
     * @test
     */
    public function removeOfferFromObjectStorageHoldingOffers()
    {
        $offer = new \Chancenportal\Chancenportal\Domain\Model\Offer();
        $offersObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $offersObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($offer));
        $this->inject($this->subject, 'offers', $offersObjectStorageMock);

        $this->subject->removeOffer($offer);
    }

    /**
     * @test
     */
    public function getOwnerGroupReturnsInitialValueForFrontendUserGroup()
    {
        self::assertEquals(
            null,
            $this->subject->getOwnerGroup()
        );
    }

    /**
     * @test
     */
    public function setOwnerGroupForFrontendUserGroupSetsOwnerGroup()
    {
        $ownerGroupFixture = new \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup();
        $this->subject->setOwnerGroup($ownerGroupFixture);

        self::assertAttributeEquals(
            $ownerGroupFixture,
            'ownerGroup',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCarrierReturnsInitialValueForCarrier()
    {
        self::assertEquals(
            null,
            $this->subject->getCarrier()
        );
    }

    /**
     * @test
     */
    public function setCarrierForCarrierSetsCarrier()
    {
        $carrierFixture = new \Chancenportal\Chancenportal\Domain\Model\Carrier();
        $this->subject->setCarrier($carrierFixture);

        self::assertAttributeEquals(
            $carrierFixture,
            'carrier',
            $this->subject
        );
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
    public function getAuthorReturnsInitialValueForFrontendUser()
    {
        self::assertEquals(
            null,
            $this->subject->getAuthor()
        );
    }

    /**
     * @test
     */
    public function setAuthorForFrontendUserSetsAuthor()
    {
        $authorFixture = new \Chancenportal\Chancenportal\Domain\Model\FrontendUser();
        $this->subject->setAuthor($authorFixture);

        self::assertAttributeEquals(
            $authorFixture,
            'author',
            $this->subject
        );
    }
}
