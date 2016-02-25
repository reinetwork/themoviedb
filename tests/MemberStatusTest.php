<?php

use REINetwork\TheMovieDb\Member;
use REINetwork\TheMovieDb\MemberPresenter;

class MemberStatusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \REINetwork\TheMovieDb\MemberStatus
     */
    private $helper;

    /**
     * @var Member|Mockery\Mock
     */
    private $member;

    /**
     * Create instance of HtmlBuilder
     */
    public function setUp()
    {
        parent::setUp();

        $this->helper = new \REINetwork\TheMovieDb\MemberStatus();
    }

    /**
     * Validate if a member is a opt-in a HTML string with color "black" and
     * text of "opt-in" is returned.
     */
    public function testMemberIsOptIn()
    {
        $presenter = $this->createMemberPresenter('opt-in');

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: black;">opt-in</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is cancelled a HTML string with color "red" and
     * text of "canceled" is returned.
     */
    public function testMemberIsCanceled()
    {
        $presenter = $this->createMemberPresenter('canceled');

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: red;">canceled</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is paying and not scheduled to be canceled, a HTML
     * string with color "green" and text of "active" is returned.
     */
    public function testMemberIsActive()
    {
        $presenter = $this->createMemberPresenter('paying');
        $this->member->shouldReceive('getSubscription')->once()->withNoArgs()->andReturnSelf();
        $this->member->shouldReceive('isPendingCancel')->once()->withNoArgs()->andReturn(false);

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: green;">active</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is paying and scheduled to be canceled, a HTML string
     * with color "green" and text of "active<br />(pending cancel)" is returned.
     */
    public function testMemberIsActivePendingCancel()
    {
        $presenter = $this->createMemberPresenter('paying');
        $this->member->shouldReceive('getSubscription')->once()->withNoArgs()->andReturnSelf();
        $this->member->shouldReceive('isPendingCancel')->once()->withNoArgs()->andReturn(true);

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: green;">active<br />(pending cancel)</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is suspended and has no next_charge_on a HTML string with
     * color "red" and text of "bad card<br />(gave up)" is returned.
     */
    public function testMemberIsSuspendedGaveUp()
    {
        $presenter = $this->createMemberPresenter('suspended');
        $this->member->shouldReceive('getSubscription')->once()->withNoArgs()->andReturnSelf();
        $this->member->shouldReceive('isRetrying')->once()->withNoArgs()->andReturn(false);

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: red;">bad card<br />(gave up)</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is suspended and has a next_charge_on date, a HTML string with
     * color "red" and text of "bad card<br />(retrying" is returned.
     */
    public function testMemberIsSuspendedRetrying()
    {
        $presenter = $this->createMemberPresenter('suspended');
        $this->member->shouldReceive('getSubscription')->once()->withNoArgs()->andReturnSelf();
        $this->member->shouldReceive('isRetrying')->once()->withNoArgs()->andReturn(true);

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: red;">bad card<br />(retrying)</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a member is in PENDING status, a HTML string with
     * color "orange" and text of "<span>pending</span>" is returned.
     */
    public function testMemberIsPending()
    {
        $presenter = $this->createMemberPresenter('pending');

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: orange;">pending</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate if a Member has its Subscription in SWITCHED status, a HTML string with
     * color "orange" and text of "<span>pending</span>" is returned.
     */
    public function testMemberIsSwitched()
    {
        $presenter = $this->createMemberPresenter('switched');

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: orange;">switched</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Validate that if a Member has a subscription is a status that is not
     * known to the MemberStatus helper then it falls through and returns
     * the status in color black.
     */
    public function testMemberHasUnknownStatus()
    {
        $status = 'unknown';

        $presenter = $this->createMemberPresenter($status);
        $this->member->shouldReceive('getSubscription->getStatus')->andReturn($status);

        $actual = $this->helper->render($presenter);

        $expected = '<span style="color: black;">unknown</span>';

        $this->assertSame($expected, $actual);
    }

    /**
     * Create a mock member and MemberPresenter.  Set the status expectation based on the $status
     * that is passed to the method.
     *
     * @param $status
     * @return MemberPresenter|Mockery\MockInterface
     */
    private function createMemberPresenter($status)
    {
        $this->member = Mockery::mock(Member::class);

        $isOptIn = ($status === 'opt-in') ? true : false;
        $isCanceled = ($status === 'canceled') ? true : false;
        $isPaying = ($status === 'paying') ? true : false;
        $isSuspended = ($status === 'suspended') ? true : false;
        $isPending = ($status === 'pending') ? true : false;
        $isSwitched = ($status === 'switched') ? true : false;

        $this->member->shouldReceive('isOptIn')->zeroOrMoreTimes()->withNoArgs()->andReturn($isOptIn);
        $this->member->shouldReceive('isCanceled')->zeroOrMoreTimes()->withNoArgs()->andReturn($isCanceled);
        $this->member->shouldReceive('isPaying')->zeroOrMoreTimes()->withNoArgs()->andReturn($isPaying);
        $this->member->shouldReceive('isSuspended')->zeroOrMoreTimes()->withNoArgs()->andReturn($isSuspended);
        $this->member->shouldReceive('isPending')->zeroOrMoreTimes()->withNoArgs()->andReturn($isPending);
        $this->member->shouldReceive('isSwitched')->zeroOrMoreTimes()->withNoArgs()->andReturn($isSwitched);

        $presenter = Mockery::mock(MemberPresenter::class);
        $presenter->shouldReceive('getObject')->once()->withNoArgs()->andReturn($this->member);

        return $presenter;
    }
}