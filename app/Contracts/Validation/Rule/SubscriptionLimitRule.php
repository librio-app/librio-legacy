<?php


namespace App\Contracts\Validation\Rule;

use App\Models\Administration\Member;
use App\Models\Administration\Subscription;
use Illuminate\Contracts\Validation\Rule;

class SubscriptionLimitRule implements Rule
{
    public function passes($attribute, $value)
    {
        $member = Member::find($value);
        $subscription = $member->subscriptions()->first();
        $max = 0;

        if ($subscription instanceof Subscription) {
            $max = count($member->lended);

            if ($subscription->book_limit === 0) {
                return true;
            }

            return $subscription->book_limit > $max;
        }

        return false;
    }

    public function message()
    {
        return trans('validation.book_limit');
    }
}
