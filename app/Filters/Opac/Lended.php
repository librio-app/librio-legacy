<?php

namespace App\Filters\Opac;

use EloquentFilter\ModelFilter;

class Lended extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($query)
    {
        return $this->select('member_books.*')
            ->join('book_barcodes', 'member_books.book_barcode_id', '=', 'book_barcodes.id')
            ->join('books', 'book_barcodes.book_id', '=', 'books.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->where(function($q) use ($query)
            {
                return $q->where('books.title', 'LIKE', '%' . $query . '%')
                    ->orWhere('books.description', 'LIKE', '%' . $query . '%')
                    ->orWhere('books.isbn', 'LIKE', '%' . $query . '%')
                    ->orWhere('books.code', 'LIKE', '%' . $query . '%');
            })
            ->orWhere(function($q) use ($query)
            {
                return $q->where('authors.first_name', 'LIKE', '%' . $query . '%')
                    ->orWhere('authors.last_name', 'LIKE', '%' . $query . '%');
            })
            ->orWhere(function($q) use ($query)
            {
                return $q->where('book_barcodes.barcode', 'LIKE', '%' . $query . '%');
            });
    }
}
