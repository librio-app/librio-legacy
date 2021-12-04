<?php

namespace App\Filters\Member;

use EloquentFilter\ModelFilter;

class Pay extends ModelFilter
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
        // TODO search?

        return $this;
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
