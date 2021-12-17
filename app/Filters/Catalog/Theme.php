<?php

namespace App\Filters\Catalog;

use EloquentFilter\ModelFilter;

class Theme extends ModelFilter
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
        return $this->where('title', 'LIKE', '%' . $query . '%');
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
