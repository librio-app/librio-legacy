<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Catalog\Publisher;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Publisher as Request;

class PublishersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $publishers = Publisher::collect();

        return view('catalog.publishers.index', compact('publishers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.publishers.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $publisher = Publisher::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.publishers', 1)]);

        flash($message)->success();

        return redirect('catalog/publishers');
    }

    public function details(Publisher $publisher)
    {
        $books = $publisher->books()->collect();
        return view('catalog.publishers.details',compact('publisher', 'books'));
    }

    /**
     * @param Publisher $publisher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Publisher $publisher)
    {
        return view('catalog.publishers.edit', compact('publisher'));
    }

    /**
     * @param Publisher $publisher
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Publisher $publisher, Request $request)
    {
        // Update publisher
        $publisher->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.publishers', 1)]);

        flash($message)->success();

        return redirect('catalog/publishers');
    }

    /**
     * @param Publisher $publisher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Publisher $publisher)
    {
        $publisher->enabled = 1;
        $publisher->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.publishers', 1)]);

        flash($message)->success();

        return redirect()->route('publishers.index');
    }

    /**
     * @param Publisher $publisher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Publisher $publisher)
    {
        $publisher->enabled = 0;
        $publisher->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.publishers', 1)]);
        flash($message)->success();

        return redirect()->route('publishers.index');
    }

    /**
     * @param Publisher $publisher
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Publisher $publisher)
    {
        if ($publisher->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.publishers', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);
            flash($message)->error();
        } else {
            $publisher->delete();

            $message = trans('messages.success.deleted', ['type' => trans_choice('general.publishers', 1)]);
            flash($message)->success();
        }

        return redirect()->route('publishers.index');
    }
}
