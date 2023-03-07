<?php

namespace App\Service;

use App\Mail\LedenPortaalAccountGeactiveerd;
use App\Models\Administration\Member;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function __construct()
    {
    }

    public function sendMemberAccountCreated(Member $member): void
    {
        Mail::to($member->email)
            ->send(new LedenPortaalAccountGeactiveerd($member, url('route', ['confirmationKey' => $member->confirmationKey])));
    }
}
