<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarcodeLendingExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        $p = \DB::getTablePrefix();
        $memberBooks = "{$p}member_books";
        $bookBarcodes = "{$p}book_barcodes";

        // Correlated subquery instead of JOIN + GROUP BY: Laravel Excel chunks with
        // forPage(), which breaks grouped aggregates and can yield invalid SQL (e.g. member_books.id in SELECT).
        return \DB::table('book_barcodes')
            ->select([
                'books.title',
                'book_barcodes.barcode',
                'categories.name as category',
            ])
            ->selectRaw("(SELECT COUNT(*) FROM {$memberBooks} WHERE {$memberBooks}.book_barcode_id = {$bookBarcodes}.id) as lend_count")
            ->join('books', 'books.id', '=', 'book_barcodes.book_id')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->whereNull('books.deleted_at')
            ->whereNull('book_barcodes.deleted_at')
            ->orderByDesc('lend_count')
            ->orderBy('books.title')
            ->orderBy('book_barcodes.barcode');
    }

    public function headings(): array
    {
        return [
            'title',
            'barcode',
            'category',
            'lend_count',
        ];
    }
}
