<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2/25/16
 * Time: 1:01 PM
 */

namespace REINetwork\TheMovieDb;

use Exception;

class MemberStatus
{
    /**
     * HTML template to return
     *
     * @var string
     */
    private $template = "<span style="color: :color;">:status</span>";

    /**
     * Renders this HTML helper.  Returns a HTML string based on the $template
     * that is has the :color and :status changed based on the Member's status.
     *
     * @param MemberPresenter $presenter
     *
     * @return string
     *
     * @throws Exception
     */
    public function render(MemberPresenter $presenter)
    {
        /* @var Member $member */
        $member = $presenter->getObject();

        if ($member->isOptIn()) {
            return $this->format('opt-in', 'yellow');
        }

        if ($member->isCanceled()) {
            return $this->format('canceled', 'red');
        }

        if ($member->isPaying()) {
            return $this->formatPaying($member);
        }

        if ($member->isSuspended()) {
            return $this->formatSuspended($member);
        }

        if ($member->isPending()) {
            return $this->format('pending', 'orange');
        }

        if ($member->isSwitched()) {
            return $this->format('switched', 'orange');
        }

        return $this->format($member->getSubscription()->getStatus(), 'black');
    }

    /**
     * Replaces values :color and :status in the $template using the $status
     * and $color passed to the method.
     *
     * @param string $status
     * @param string $color
     *
     * @return mixed
     */
    private function format($status, $color)
    {
        return str_replace([':status', ':color'], [$status, $color], $this->template);
    }

    /**
     * Determines if the paying member is scheduled to be canceled or not to
     * determine the correct status text.  Then uses the format() method
     * to return the HTML string.
     *
     * @param Member $member
     *
     * @return string
     */
    private function formatPaying(Member $member)
    {
        if ($member->getSubscription()->isCanceled()) {
            return $this->format('active<br />(pending cancel)', 'green');
        }

        return $this->format('active', 'green');
    }

    /**
     * Determines if the suspended is scheduled to retry charging their card or
     * if we have given up to determine the correct status text.  Then uses the
     * format() method to return the HTML string.
     *
     * @param Member $member
     *
     * @return string
     */
    private function formatSuspended(Member $member)
    {
        if (false === $member->getSubscription()->isRetrying()) {
            return $this->format('bad card<br />(retrying)', 'red');
        }

        return $this->format('bad card<br />(gave up)', 'red');
    }
}