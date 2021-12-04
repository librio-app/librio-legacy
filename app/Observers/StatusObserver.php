<?php

namespace App\Observers;

use App\Models\Member\Book;

class StatusObserver
{
    /**
     * Handle the book "created" event.
     *
     * @param  \App\Models\Member\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        if (isset($book->lend_at) && !isset($book->take_in_at)){
            $barcode = $book->barcode;
            $barcode->status = 'lended';
            $barcode->save();
        }
    }

    /**
     * Handle the book "updated" event.
     *
     * @param  \App\Models\Member\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        if (isset($book->lend_at) && isset($book->take_in_at)){
            $barcode = $book->barcode;
            $barcode->status = setting('take_in_status', 'available');
            $barcode->save();
        }
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Models\Member\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        //
    }

    /**
     * Handle the book "restored" event.
     *
     * @param  \App\Models\Member\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        //
    }

    /**
     * Handle the book "force deleted" event.
     *
     * @param  \App\Models\Member\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
        //
    }
}
