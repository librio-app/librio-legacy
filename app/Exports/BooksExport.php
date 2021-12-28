<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromQuery, WithHeadings
{
    /**
     * @var Builder
     */
    protected $query;

    use Exportable;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
       return $this->query
          ->select([
              'books.id',
              'books.code',
              'books.title',
              'books.description',
              'books.isbn',
              'books.ean',
              'books.enabled',
              'books.created_at',
              'books.updated_at',
              'books.category_id',
              'categories.name',
              'books.author_id',
              'authors.first_name',
              'authors.last_name',
              'books.publisher_id',
              'books.type_id',
              'books.series_id',
              'series.title AS series_title',
              'books.series_nr',
              'book_barcodes.barcode',
              'book_barcodes.status',
              'books.deleted_at',
          ])
          ->join('categories', 'categories.id', '=', 'books.category_id')
          ->join('authors', 'authors.id', '=', 'books.author_id')
          ->join('book_barcodes', 'book_barcodes.book_id', '=', 'books.id')
          ->leftJoin('series', 'series.id', '=', 'books.series_id')
          ->toBase();
    }

    public function headings(): array
    {
        return [
            'id',
            'code',
            'title',
            'description',
            'isbn',
            'ean',
            'enabled',
            'created_at',
            'updated_at',
            'category_id',
            'name',
            'author_id',
            'first_name',
            'last_name',
            'publisher_id',
            'type_id',
            'series_id',
            'series_title',
            'series_nr',
            'barcode',
            'status',
            'deleted_at',
        ];
    }
}
