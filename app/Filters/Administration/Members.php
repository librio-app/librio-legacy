<?php

namespace App\Filters\Administration;

use EloquentFilter\ModelFilter;

class Members extends ModelFilter
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
        $tableName = $this->query->getModel()->getTable();

        $query = $this->where($tableName . '.email', 'LIKE', '%' . $query . '%')
            ->orWhere($tableName . '.first_name', 'LIKE', '%' . $query . '%')
            ->orWhere($tableName . '.last_name', 'LIKE', '%' . $query . '%')
            ->orWhere($tableName . '.code', 'LIKE', '%' . $query . '%')
            ->orWhere($tableName . '.comment', 'LIKE', '%' . $query . '%');

        return $query;
    }

    public function role($id)
    {
        return $this->related('roles', 'role_id', $id);
    }
}
