<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class LogTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Log
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\Log();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDate()
        );
    }

    /**
     * @test
     */
    public function setDateForDateTimeSetsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'date',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTermReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTerm()
        );
    }

    /**
     * @test
     */
    public function setTermForStringSetsTerm()
    {
        $this->subject->setTerm('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'term',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCategoryReturnsInitialValueForCategory()
    {
        self::assertEquals(
            null,
            $this->subject->getCategory()
        );
    }

    /**
     * @test
     */
    public function setCategoryForCategorySetsCategory()
    {
        $categoryFixture = new \Chancenportal\Chancenportal\Domain\Model\Category();
        $this->subject->setCategory($categoryFixture);

        self::assertAttributeEquals(
            $categoryFixture,
            'category',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOfferReturnsInitialValueForOffer()
    {
        self::assertEquals(
            null,
            $this->subject->getOffer()
        );
    }

    /**
     * @test
     */
    public function setOfferForOfferSetsOffer()
    {
        $offerFixture = new \Chancenportal\Chancenportal\Domain\Model\Offer();
        $this->subject->setOffer($offerFixture);

        self::assertAttributeEquals(
            $offerFixture,
            'offer',
            $this->subject
        );
    }
}
