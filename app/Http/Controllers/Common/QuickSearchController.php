<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Models\Administration\Member;
use App\Models\Catalog\Book;

class QuickSearchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = '';
        if ($request->has('search')) {
            $search = $request->get('search');
        }

        $books = Book::query()
            ->select('books.*')
            ->join('book_barcodes', 'book_barcodes.book_id', '=', 'books.id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->where(function ($query) use ($search) {
                $query->where('books.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('books.description', 'LIKE', '%' . $search . '%')
                    ->orWhere('book_barcodes.barcode', 'LIKE', '%' . $search . '%')
                    ->orWhere('authors.last_name', 'LIKE', '%' . $search . '%');
            })
            ->whereNull('book_barcodes.deleted_at')
            ->groupBy(['books.id'])
            ->limit(20)
            ->get();

        $members = Member::query()
            ->where(function ($query) use ($search) {
                $query->where('members.first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('members.code', 'LIKE', '%' . $search . '%')
                    ->orWhere('members.last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('members.email', 'LIKE', '%' . $search . '%');
            })
            ->whereNull('members.deleted_at')
            ->limit(20)
            ->get();

        return view('common.quicksearch.index', compact('search', 'books', 'members'));
    }
}
