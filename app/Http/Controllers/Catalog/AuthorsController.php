<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Catalog\Author;
use App\Http\Requests\Catalog\Author as Request;

class AuthorsController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $authors = Author::collect();

        return view('catalog.authors.index', compact('authors'));
    }

    public function details(Author $author)
    {
        return view('catalog.authors.details', compact('author'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.authors.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $author = Author::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.authors', 1)]);

        flash($message)->success();

        return redirect()->route('authors.details', ['author' => $author]);
    }

    /**
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Author $author)
    {
        return view('catalog.authors.edit', compact('author'));
    }

    /**
     * @param Author $author
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Author $author, Request $request)
    {
        // Update author
        $author->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.authors', 1)]);

        flash($message)->success();

        return redirect()->route('authors.details', ['author' => $author]);
    }

    /**
     * @param Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Author $author)
    {
        $author->enabled = 1;
        $author->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.authors', 1)]);

        flash($message)->success();

        return redirect()->route('authors.index');
    }

    /**
     * @param Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Author $author)
    {
        $author->enabled = 0;
        $author->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.authors', 1)]);

        flash($message)->success();

        return redirect()->route('authors.index');
    }

    /**
     * @param Author $author
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.authors', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $author->delete();
        }

        return redirect()->route('authors.index');
    }
}
