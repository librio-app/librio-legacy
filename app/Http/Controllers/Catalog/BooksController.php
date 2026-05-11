<?php

namespace App\Http\Controllers\Catalog;

use App\Exports\BarcodeLendingExport;
use App\Models\Catalog\Author;
use App\Models\Catalog\Barcode;
use App\Models\Catalog\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Book as Request;
use App\Models\Catalog\Category;
use App\Models\Catalog\Publisher;
use App\Models\Catalog\Series;
use App\Models\Catalog\Theme;
use App\Models\Catalog\Type;
use App\Service\BarcodeService;
use Illuminate\Http\Request as HttpRequest;
use Maatwebsite\Excel\Excel;

class BooksController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $books = Book::with('author', 'category', 'series')->collect(['created_at' => 'desc']);
        $categories = Category::enabled()->pluck('name', 'id');
        $authors = Author::enabled()->get()->pluck('name', 'id');

        return view('catalog.books.index', compact('books', 'categories', 'authors'));
    }

    /**
     * @param BarcodeService $barcodeService
     * @param Book $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(BarcodeService $barcodeService, Book $book)
    {
        $barcodes = $book->barcodes;

        $newBarcode = null;
        try {
            $newBarcode = $barcodeService->generateBarcode($book);
        } catch (\RuntimeException $e) {
            flash($e->getMessage())->warning();
        }

        return view('catalog.books.details', compact('book', 'newBarcode', 'barcodes'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $authors = Author::enabled()->get()->pluck('name', 'id');
        $categories = Category::enabled()->pluck('name', 'id');
        $types = Type::pluck('name', 'id');
        $publishers = Publisher::enabled()->pluck('name', 'id');
        $series = Series::pluck('title', 'id');
        $themes = Theme::pluck('name', 'id');

        return view('catalog.books.create', compact('authors', 'categories', 'types', 'publishers', 'series', 'themes'));
    }

    /**
     * @param BarcodeService $barcodeService
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BarcodeService $barcodeService, Request $request)
    {
        /** @var Book $book */
        $book = Book::create($request->input());
        $book->themes()->sync(array_filter($request->get('themes') ?? []));

        // add barcode
        $barcode = Barcode::create([
            'book_id' => $book->id,
            'barcode' => $barcodeService->generateBarcode($book),
        ]);
        $book->barcodes()->save($barcode);

        $message = trans('messages.success.added', ['type' => trans_choice('general.books', 1)]);
        flash($message)->success();

        return redirect()->route('books.details', ['book' => $book]);
    }

    /**
     * @param Book $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Book $book)
    {
        $authors = Author::enabled()->get()->pluck('name', 'id');
        $categories = Category::enabled()->pluck('name', 'id');
        $types = Type::pluck('name', 'id');
        $publishers = Publisher::enabled()->pluck('name', 'id');
        $series = Series::pluck('title', 'id');
        $themes = Theme::pluck('name', 'id');
        $selectedThemes = $book->themes->pluck('id')->toArray();

        return view('catalog.books.edit', compact('book', 'authors', 'categories', 'types', 'publishers', 'series', 'themes', 'selectedThemes'));
    }

    /**
     * @param Book $book
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Book $book, Request $request)
    {
        // Update category
        $book->update($request->input());
        $book->themes()->sync(array_filter($request->get('themes') ?? []));

        $message = trans('messages.success.updated', ['type' => trans_choice('general.books', 1)]);

        flash($message)->success();

        return redirect('catalog/books');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(Book $book)
    {
        $book->enabled = 1;
        $book->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.books', 1)]);

        flash($message)->success();

        return redirect()->route('books.index');
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(Book $book)
    {
        $book->enabled = 0;
        $book->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.books', 1)]);

        flash($message)->success();

        return redirect()->route('books.index');
    }

    /**
     * @param Book $category
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index');
    }

    public function download(HttpRequest $request)
    {
        if ($request->query('export') === 'barcode_lending') {
            return (new BarcodeLendingExport())->download('barcode_lending_statistics.csv', Excel::CSV);
        }

        return Book::download();
    }
}
