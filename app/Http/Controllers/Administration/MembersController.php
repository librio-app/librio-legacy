<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Member as Request;
use App\Models\Administration\Member;
use App\Models\Administration\Subscription;
use App\Service\ReservationService;
use App\Service\SubscriptionService;

class MembersController extends Controller
{
    /**
     * @var ReservationService
     */
    private $reservationService;

    /**
     * MembersController constructor.
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $members = Member::collect();

        return view('administration.members.index', compact('members'));
    }

    /**
     * @param Member $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(Member $member)
    {
        $subscription = $member->subscriptions()->first();
        $lended = $member->lended()->get();
        $notAvailableReservations = $this->reservationService->getNotAvailableReservations($member);
        $reservations = $member->reservations()->get();

        return view('administration.members.details', compact('member', 'subscription', 'lended', 'notAvailableReservations', 'reservations'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $subscriptions = Subscription::pluck('name', 'id');

        $latestMemberCode = setting('member_code_prefix') . ((Member::latest()->first()->id ?? 1) + 1);

        return view('administration.members.create', compact('subscriptions', 'latestMemberCode'));
    }

    /**
     * @param SubscriptionService $subscriptionService
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubscriptionService $subscriptionService, Request $request)
    {
        $data = $request->input();
        $data['password'] = \Hash::make($data['password']);
        $member = Member::create($data);
        $subscriptionService->sync($member, $request->get('subscription_id'));

        $message = trans('messages.success.added', ['type' => trans_choice('general.members', 1)]);

        flash($message)->success();

        return redirect()->route('members.details', ['member' => $member]);
    }

    /**
     * @param  $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Member $member)
    {
        $subscriptions = Subscription::pluck('name', 'id');
        $subscription = $member->subscriptions()->first();
        $selectedSubscription = null;

        if ($subscription) {
            $selectedSubscription = $subscription->id;
        }

        return view('administration.members.edit', compact('member', 'subscriptions', 'selectedSubscription'));
    }

    /**
     * @param SubscriptionService $subscriptionService
     * @param Member $member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubscriptionService $subscriptionService, Member $member, Request $request)
    {
        $data = $request->input();
        $subscription = $member->subscriptions()->first();
        // when disabled and subscription changes, enable
        if ($subscription instanceof Subscription && $subscription->id !== ((int) $data['subscription_id'])) {
            $data['enabled'] = true;
        }

        // update member
        $member->update($data);

        if ((bool) $data['enabled'] === false) {
            $subscriptionService->expire($member);
        } else {
            $subscriptionService->sync($member, $request->get('subscription_id'));
        }

        $message = trans('messages.success.updated', ['type' => trans_choice('general.members', 1)]);

        flash($message)->success();

        return redirect()->route('members.details', ['member' => $member]);
    }

    /**
     * @param  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Member $member)
    {
        $member->enabled = 1;
        $member->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.members', 1)]);

        flash($message)->success();

        return redirect()->route('members.index');
    }

    /**
     * @param  $member
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Member $member)
    {
        if ($member->lended()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.member', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $member->enabled = 0;
            $member->save();
        }

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.members', 1)]);
        flash($message)->success();

        return redirect()->route('members.index');
    }

    /**
     * @param  $member
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Member $member)
    {
        if ($member->lended()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.members', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $member->delete();

            $message = trans('messages.success.deleted', ['type' => trans_choice('general.members', 1)]);
            flash($message)->success();
        }

        return redirect()->route('members.index');
    }

    public function download()
    {
        return Member::download();
    }
}
