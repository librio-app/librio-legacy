<?php

namespace App\Http\Controllers\Opac;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Author;
use App\Models\Catalog\Book;
use App\Models\Catalog\Category;
use App\Http\Requests\Request;
use App\Models\Catalog\Series;
use App\Service\ThemeService;

class OpacController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ThemeService $themeService)
    {
        $authors = Author::enabled()->get()->pluck('name', 'id');
        $categories = Category::enabled()->pluck('name', 'id');
        $themes = $themeService->getActiveThemes()->pluck('name', 'id');

        return view('opac.index', compact('authors', 'categories', 'themes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = '';
        $books = Book::with('barcodes', 'author', 'category', 'series')->whereHas('barcodes', function ($query) {
            $query->where('status', '!=', 'new'); // TODO don't show new books, make optional?
        })->enabled()->collect(['created_at' => 'desc']);

        $searching = $request->get('search');
        $categoryId = $request->get('category');
        $authorId = $request->get('author');
        $serieId = $request->get('serie');

        if (!empty($searching)) {
            $search = $searching;
        } elseif (!empty($categoryId)) {
            $category = Category::find($categoryId);
            if ($category instanceof Category) {
                $search = $category->name;
            }
        } elseif (!empty($authorId)) {
            $author = Author::find($authorId);
            if ($author instanceof Author) {
                $search = $author->getName();
            }
        } elseif (!empty($serieId)) {
            $serie = Series::find($serieId);
            if ($serie instanceof Series) {
                $search = $serie->title;
            }
        }

        return view('opac.search', compact('books', 'search'));
    }

    public function quickSearch()
    {
        // TODO
    }
}
