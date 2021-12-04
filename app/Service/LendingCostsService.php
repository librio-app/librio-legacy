<?php

namespace App\Service;

use App\Models\Administration\Subscription;
use App\Models\Member\Book;
use Carbon\Carbon;

class LendingCostsService
{
    /**
     * @param Book $lendedBook
     * @param $subscription
     * @return float
     */
    public function calculatePenalty(Book $lendedBook, $subscription): float
    {
        // fallback if no subscription is found
        if (!$subscription instanceof Subscription) {
            return 0;
        }

        // if subscription penalty is disabled
        if (!$subscription->penalty || $subscription->book_lending_days === 0 || $subscription->penalty_price === null) {
            return 0;
        }

        // calculate day diff
        $days = $this->lendDays($lendedBook);
        if ($days > $subscription->book_lending_days) {
            return $days * $subscription->penalty_price;
        }

        return 0;
    }

    /**
     * @param Book $lendedBook
     * @param $subscription
     * @return float
     */
    public function calculateCosts(Book $lendedBook, $subscription): float
    {
        // fallback if no subscription is found
        if (!$subscription instanceof Subscription) {
            return 0;
        }

        // if not per pook daily, we skip this.
        if ($subscription->payment_period !== 'per-book-daily') {
            return 0;
        }

        $days = $this->lendDays($lendedBook);
        if ($days >= 0) {
            return $days * $subscription->subscription_price;
        }

        return 0;
    }

    /**
     * @param Book $lendedBook
     * @return int
     */
    private function lendDays(Book $lendedBook): int
    {
        // calculate day diff
        /** @var Carbon $lend */
        $lend = $lendedBook->lend_at;
        $now = new \DateTime();
        return $lend->diffInDays($now, true);
    }
}
