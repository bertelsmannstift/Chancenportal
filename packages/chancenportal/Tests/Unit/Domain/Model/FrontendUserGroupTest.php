<?php
namespace Chancenportal\Chancenportal\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class FrontendUserGroupTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Chancenportal\Chancenportal\Domain\Model\FrontendUserGroup();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
