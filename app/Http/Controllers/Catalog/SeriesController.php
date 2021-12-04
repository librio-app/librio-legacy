<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Catalog\Book;
use App\Models\Catalog\Series;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Series as Request;

class SeriesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $series = Series::collect();

        return view('catalog.series.index', compact('series'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.series.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $series = Series::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.series', 1)]);

        flash($message)->success();

        return redirect('catalog/series');
    }

    /**
     * @param series $series
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Series $series)
    {
        $books = $series->books()->collect('series_nr');

        return view('catalog.series.edit', compact('series', 'books'));
    }

    /**
     * @param Series $series
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Series $series, Request $request)
    {
        // Update category
        $series->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.series', 1)]);

        flash($message)->success();

        return redirect('catalog/series');
    }

    /**
     * @param Series $series
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Series $series)
    {
        $series->enabled = 1;
        $series->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.series', 1)]);

        flash($message)->success();

        return redirect()->route('series.index');
    }

    /**
     * @param Series $serie
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Series $series)
    {
        $series->enabled = 0;
        $series->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.series', 1)]);

        flash($message)->success();

        return redirect()->route('series.index');
    }

    public function removeBook(Book $book)
    {
        $seriesId = $book->series_id;
        $book->series_id = null;
        $book->series_nr = null;
        $book->save();

        $message = trans('messages.success.deleted', ['type' => trans_choice('general.books', 1)]);

        flash($message)->success();

        return redirect()->route('series.edit', ['series' => $seriesId]);
    }

    /**
     * @param Series $series
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Series $series)
    {
        if ($series->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.series', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $series->delete();
        }

        return redirect()->route('series.index');
    }
}
