<?php

namespace App\Service;

use App\Models\Administration\Member;
use App\Models\Administration\Subscription;

class SubscriptionService
{
    /**
     * @param Member $member
     * @param int $subscriptionId
     * @return Member|void
     */
    public function sync(Member $member, int $subscriptionId)
    {
        // if nothing changed, return
        $now = new \DateTime();
        $currentSubscription = \DB::table('member_subscription')
            ->where('member_id', '=', $member->id)
            ->where('subscription_id', '=', $subscriptionId)
            ->where(function ($query) use ($now) {
                return $query->whereNull('expire_date')->where('expire_date', '>=', $now->format('Y-m-d H:i:s'), 'or');
            })
            ->orderByDesc('created_at')
            ->first();

        if ($currentSubscription) {
            return;
        }

        // set all active on expired
        $this->expire($member);

        $subscription = Subscription::enabled()->find($subscriptionId);
        if (!$subscription) {
            return;
        }

        $pivotAttributes = [];
        if ($subscription->expire_date !== null && $subscription->expire_date !== 'ongoing') {
            $format = config('enums.expire_date_format');
            $now = new \DateTime();
            $now->add(new \DateInterval($format[$subscription->expire_date]));
            $pivotAttributes['expire_date'] = $now;
        }

        // add new
        $member->allSubscriptions()->save($subscription, $pivotAttributes);

        return $member;
    }

    /**
     * @param Member $member
     * @return bool
     */
    public function expire(Member $member)
    {
        // set all active on expired
        $now = new \DateTime();
        \DB::table('member_subscription')
            ->where('member_id', '=', $member->id)
            ->where(function ($query) use ($now) {
                return $query->whereNull('expire_date')->where('expire_date', '>=', $now->format('Y-m-d H:i:s'), 'or');
            })
            ->update(['expire_date' => new \DateTime()]);

        return true;
    }
}
