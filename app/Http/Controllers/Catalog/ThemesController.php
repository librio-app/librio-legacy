<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Requests\Catalog\ThemeBarcode;
use App\Models\Catalog\Barcode;
use App\Models\Catalog\Book;
use App\Models\Catalog\Theme;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Theme as Request;

class ThemesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $themes = Theme::collect();

        return view('catalog.themes.index', compact('themes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('catalog.themes.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $theme = Theme::create($request->input());

        $message = trans('messages.success.added', ['type' => trans_choice('general.themes', 1)]);

        flash($message)->success();

        return redirect('catalog/themes');
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Theme $theme)
    {
        $books = $theme->books()->collect();

        return view('catalog.themes.edit', compact('theme', 'books'));
    }

    /**
     * @param Theme $theme
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Theme $theme, Request $request)
    {
        // Update category
        $theme->update($request->input());

        $message = trans('messages.success.updated', ['type' => trans_choice('general.themes', 1)]);

        flash($message)->success();

        return redirect('catalog/themes');
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Theme $theme)
    {
        $theme->active = 1;
        $theme->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.themes', 1)]);

        flash($message)->success();

        return redirect()->route('themes.index');
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Theme $theme)
    {
        $theme->active = 0;
        $theme->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.themes', 1)]);
        flash($message)->success();

        return redirect()->route('themes.index');
    }

    public function download()
    {
        return Theme::download();
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\View\View
     */
    public function addBooks(Theme $theme)
    {
        $books = $theme->books()->collect();

        return view('catalog.themes.add', compact('theme', 'books'));
    }

    /**
     * @param Theme $theme
     * @param ThemeBarcode $themeBarcode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addBook(Theme $theme, ThemeBarcode $themeBarcode)
    {
        $barcode = Barcode::where(['barcode' => $themeBarcode->get('barcode')])->first();
        $barcode->book->themes()->save($theme);

        $message = trans('messages.success.added', ['type' => trans_choice('general.books', 1)]);
        flash($message)->success();

        return redirect()->route('themes.add', ['theme' => $theme]);
    }

    /**
     * @param Theme $theme
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeBook(Theme $theme, Book $book)
    {
        $themes = $book->themes()->get();
        $newThemes = $themes->filter(function (Theme $currentTheme) use ($theme) {
            return $currentTheme->id !== $theme->id;
        });
        $book->themes()->sync($newThemes->toArray());


        $message = trans('messages.success.deleted', ['type' => trans_choice('general.books', 1)]);
        flash($message)->success();

        return redirect()->route('themes.add', ['theme' => $theme]);
    }

    /**
     * @param Theme $theme
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Theme $theme)
    {
        if ($theme->books()->count() > 0) {
            $message = trans('messages.failed.coupled', [
                'type' => trans_choice('general.themes', 1),
                'relation' => strtolower(trans_choice('general.books', 2)),
            ]);

            flash($message)->error();
        } else {
            $theme->delete();
        }

        return redirect()->route('themes.index');
    }
}
