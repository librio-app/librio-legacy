<?php

namespace App\Http\Controllers\Catalog;

use App\Contracts\Validation\Rule\BookIsLended;
use App\Models\Catalog\Barcode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Barcode as Request;
use App\Models\Catalog\Book;

class BarcodesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Book $book, Request $request)
    {
        $barcode = Barcode::create(array_merge(
            $request->input(),
            [
                'book_id' => $book->id,
            ]
        ));

        $message = trans('messages.success.added', ['type' => trans_choice('general.barcodes', 1)]);

        flash($message)->success();

        return redirect()->route('books.details', ['book' => $book->id]);
    }

    /**
     * @param Barcode $barcode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Barcode $barcode)
    {
        // TODO
    }

    /**
     * @param Barcode $barcode
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Barcode $barcode, Request $request)
    {
        // TODO
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function status()
    {
        $barcode = \request('barcode');

        return view('catalog.books.status', [
            'barcode' => $barcode,
            'redirect' => isset($barcode) ? true : false,
            'status' => \Session::get('status'),
        ]);
    }

    /**
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(\App\Http\Requests\Request $request)
    {
        $barcode = $request->get('barcode');
        $status = $request->get('status');

        $enum = array_values(config('enums.barcode_status'));
        $validator = \Validator::make($request->all(), [
            'barcode' => [
                'required',
                'exists:book_barcodes,barcode,barcode,' . $barcode,
                new BookIsLended(),
            ],
            'status' => 'required|string|in:' . implode(',', $enum),
            'redirect' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barcode.status')
                ->withErrors($validator)
                ->withInput();
        }

        $bookBarcode = Barcode::where('barcode', '=', $barcode)->first();
        $bookBarcode->status = $status;
        $bookBarcode->save();

        $redirect = $request->get('redirect');
        if ($redirect) {
            return redirect()->route('books.details', $bookBarcode->book->id);
        }

        $message = trans('messages.success.updated', ['type' => trans_choice('general.barcodes', 1)]);

        flash($message)->success();

        return redirect()->route('barcode.status')->with('status', $status);
    }

    /**
     * @param Barcode $category
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Barcode $barcode)
    {
        $book = $barcode->book;
        if ($barcode->allowedToDelete()) {
            $barcode->delete();
        } else {
            $message = trans('messages.failed.coupled', ['type' => trans_choice('general.barcodes', 1)]);
            flash($message)->error();
        }

        return redirect()->route('books.details', ['book' => $book]);
    }
}
