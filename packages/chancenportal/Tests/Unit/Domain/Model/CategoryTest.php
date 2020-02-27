<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class CategoryTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Category
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\Category();
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
    public function getColorReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getColor()
        );
    }

    /**
     * @test
     */
    public function setColorForStringSetsColor()
    {
        $this->subject->setColor('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'color',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getChildrenReturnsInitialValueForCategory()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getChildren()
        );
    }

    /**
     * @test
     */
    public function setChildrenForObjectStorageContainingCategorySetsChildren()
    {
        $child = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $objectStorageHoldingExactlyOneChildren = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneChildren->attach($child);
        $this->subject->setChildren($objectStorageHoldingExactlyOneChildren);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneChildren,
            'children',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addChildToObjectStorageHoldingChildren()
    {
        $child = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $childrenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $childrenObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($child));
        $this->inject($this->subject, 'children', $childrenObjectStorageMock);

        $this->subject->addChild($child);
    }

    /**
     * @test
     */
    public function removeChildFromObjectStorageHoldingChildren()
    {
        $child = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $childrenObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $childrenObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($child));
        $this->inject($this->subject, 'children', $childrenObjectStorageMock);

        $this->subject->removeChild($child);
    }

    /**
     * @test
     */
    public function getParentReturnsInitialValueForCategory()
    {
        self::assertEquals(
            null,
            $this->subject->getParent()
        );
    }

    /**
     * @test
     */
    public function setParentForCategorySetsParent()
    {
        $parentFixture = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $this->subject->setParent($parentFixture);

        self::assertAttributeEquals(
            $parentFixture,
            'parent',
            $this->subject
        );
    }
}
