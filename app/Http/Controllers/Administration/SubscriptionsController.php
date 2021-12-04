<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administration\Subscription as Request;
use App\Models\Administration\Subscription;

class SubscriptionsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $subscriptions = Subscription::collect();

        return view('administration.subscriptions.index', compact('subscriptions'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('administration.subscriptions.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $subscription = Subscription::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.subscriptions', 1)]);

        flash($message)->success();

        return redirect('administration/subscriptions');
    }

    /**
     * @param  Subscription $subscription
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Subscription $subscription)
    {
        return view('administration.subscriptions.edit', compact('subscription'));
    }

    /**
     * @param Subscription $subscription
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Subscription $subscription, Request $request)
    {
        // Update author
        $subscription->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.subscriptions', 1)]);

        flash($message)->success();

        return redirect('administration/subscriptions');
    }

    /**
     * @param  Subscription $subscription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Subscription $subscription)
    {
        $subscription->enabled = 1;
        $subscription->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.subscriptions', 1)]);

        flash($message)->success();

        return redirect()->route('subscriptions.index');
    }

    /**
     * @param Subscription $subscription
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Subscription $subscription)
    {
        $subscription->enabled = 0;
        $subscription->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.subscriptions', 1)]);
        flash($message)->success();

        return redirect()->route('subscriptions.index');
    }

    /**
     * @param Subscription $subscription
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Subscription $subscription)
    {
        if ($subscription->members()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.subscriptions', 1),
                'relation' => strtolower(trans_choice('general.members', 2))
            ]);
            flash($message)->error();
        } else {
            $subscription->delete();
            $message = trans('messages.success.deleted', ['type' => trans_choice('general.subscriptions', 1)]);
            flash($message)->success();
        }

        return redirect()->route('subscriptions.index');
    }
}
