<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Catalog\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Category as Request;

class CategoriesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::collect();

        return view('catalog.categories.index', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.categories.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $category = Category::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.categories', 1)]);

        flash($message)->success();

        return redirect('catalog/categories');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('catalog.categories.edit', compact('category'));
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Category $category, Request $request)
    {
        // Update category
        $category->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.categories', 1)]);

        flash($message)->success();

        return redirect('catalog/categories');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Category $category)
    {
        $category->enabled = 1;
        $category->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.categories', 1)]);

        flash($message)->success();

        return redirect()->route('categories.index');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Category $category)
    {
        $category->enabled = 0;
        $category->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.categories', 1)]);

        flash($message)->success();

        return redirect()->route('categories.index');
    }

    /**
     * @param Category $category
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.categories', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $category->delete();
        }

        return redirect()->route('categories.index');
    }
}
