<?php

namespace App\Filters\Catalog;

use EloquentFilter\ModelFilter;

class Books extends ModelFilter
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
        return $this->where(function ($query) use ($search) {
            $tableName = $this->query->getModel()->getTable();
            $query->where($tableName . '.code', 'LIKE', '%' . $search . '%')
                  ->orWhere($tableName . '.title', 'LIKE', '%' . $search . '%')
                  ->orWhere($tableName . '.description', 'LIKE', '%' . $search . '%');
        });
    }

    public function barcode($barcode)
    {
        return $this->related('barcodes', 'barcode', 'LIKE', '%' . $barcode . '%');
    }

    public function categories($categories)
    {
        return $this->whereIn('category_id', (array) $categories);
    }

    public function authors($authors)
    {
        return $this->whereIn('author_id', (array) $authors);
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
