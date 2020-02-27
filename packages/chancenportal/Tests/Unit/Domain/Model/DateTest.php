<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class DateTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\Date
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\Date();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
    public function getStartTimeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getStartTime()
        );
    }

    /**
     * @test
     */
    public function setStartTimeForStringSetsStartTime()
    {
        $this->subject->setStartTime('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'startTime',
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
    public function getEndTimeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEndTime()
        );
    }

    /**
     * @test
     */
    public function setEndTimeForStringSetsEndTime()
    {
        $this->subject->setEndTime('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'endTime',
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
}
