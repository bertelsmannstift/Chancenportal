<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class TargetGroupTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\TargetGroup
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\TargetGroup();
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
}
