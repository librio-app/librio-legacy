<?php

namespace App\Filters\Member;

use EloquentFilter\ModelFilter;

class Reservations extends ModelFilter
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
        return $this->select('member_reservations.*')
            ->with('member', 'barcode')
            ->join('book_barcodes', 'member_reservations.book_barcode_id', '=', 'book_barcodes.id')
            ->join('books', 'book_barcodes.book_id', '=', 'books.id')
            ->join('members', 'member_reservations.member_id', '=', 'member_id')
            ->where('books.title', 'LIKE', '%' . $query . '%')
            ->orWhere('book_barcodes.barcode', 'LIKE', '%' . $query . '%')
            ->orWhere('members.first_name', 'LIKE', '%' . $query . '%')
            ->orWhere('members.last_name', 'LIKE', '%' . $query . '%')
            ->orWhere('members.email', 'LIKE', '%' . $query . '%')
            ->orWhere('members.code', 'LIKE', '%' . $query . '%')
            ->groupBy('member_reservations.id');
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
