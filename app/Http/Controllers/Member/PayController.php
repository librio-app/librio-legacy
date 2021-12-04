<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Administration\Member;
use App\Http\Requests\Member\Payment as Request;
use App\Models\Member\Book;

class PayController extends Controller
{
    /**
     * @param Member $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Member $member)
    {
        $openPayments = $member->takeIn(true)->with('barcode')->collect();
        $subscription = $member->subscriptions()->first();

        return view('member.pay.index', compact('member', 'subscription', 'openPayments'));
    }

    /**
     * @param Request $request
     * @param Member $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Member $member)
    {
        // pay per book
        $memberBookId = $request->get('member_book_id');
        if (isset($memberBookId)) {
            $memberBook = Book::withTrashed()->find($memberBookId);
            $memberBook->paid = ($memberBook->penalty + $memberBook->costs);
            $memberBook->save();
        }

        return redirect()->route('pay.member', ['member' => $member]);
    }
}
