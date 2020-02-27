<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class FrontendUserTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUser
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\FrontendUser();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getPasswordResetHashReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPasswordResetHash()
        );
    }

    /**
     * @test
     */
    public function setPasswordResetHashForStringSetsPasswordResetHash()
    {
        $this->subject->setPasswordResetHash('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'passwordResetHash',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConfirmationSendReturnsInitialValueForBool()
    {
        self::assertSame(
            false,
            $this->subject->getConfirmationSend()
        );
    }

    /**
     * @test
     */
    public function setConfirmationSendForBoolSetsConfirmationSend()
    {
        $this->subject->setConfirmationSend(true);

        self::assertAttributeEquals(
            true,
            'confirmationSend',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTermsAndConditionsDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getTermsAndConditionsDate()
        );
    }

    /**
     * @test
     */
    public function setTermsAndConditionsDateForDateTimeSetsTermsAndConditionsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setTermsAndConditionsDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'termsAndConditionsDate',
            $this->subject
        );
    }
}
