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
        return \DB::table('book_barcodes')
            ->select([
                'books.title',
                'book_barcodes.barcode',
                'categories.name as category',
            ])
            ->selectRaw('COUNT(member_books.id) as lend_count')
            ->join('books', 'books.id', '=', 'book_barcodes.book_id')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->leftJoin('member_books', 'member_books.book_barcode_id', '=', 'book_barcodes.id')
            ->whereNull('books.deleted_at')
            ->whereNull('book_barcodes.deleted_at')
            ->groupBy('book_barcodes.id', 'books.title', 'book_barcodes.barcode', 'categories.name')
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
