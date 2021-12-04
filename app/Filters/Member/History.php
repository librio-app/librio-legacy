<?php

namespace App\Filters\Member;

use EloquentFilter\ModelFilter;

class History extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($search)
    {
        return $this->related('barcode.book', 'title', 'LIKE' , '%' . $search . '%');
    }

    public function barcode($barcode)
    {
        return $this->related('barcode', 'barcode', 'LIKE', '%' . $barcode . '%');
    }

    public function authors($authors)
    {
        // TODO make better for in filtering
        return $this->related('barcode.book.author', 'id', reset($authors));
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
