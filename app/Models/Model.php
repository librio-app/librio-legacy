<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;
use Route;

class Model extends Eloquent
{
    use Filterable, SoftDeletes, Sortable;

    protected $dates = ['deleted_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Define the filter provider globally.
     *
     * @return ModelFilter
     */
    public function modelFilter()
    {
        list($folder, $file) = explode('/', Route::current()->uri());

        if (empty($folder) || empty($file)) {
            return $this->provideFilter();
        }

        $class = '\App\Filters\\' . ucfirst($folder) . '\\' . ucfirst($file);

        return $this->provideFilter($class);
    }

    /**
     * Scope to get all rows filtered, sorted and paginated.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $sort
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCollect($query, $sort = 'name')
    {
        $request = request();

        $input = $request->input();
        $limit = $request->get('limit', 25);

        return $query->filter($input)->sortable($sort)->paginate($limit);
    }

    /**
     * Scope to only include active models.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where($query->getModel()->getTable() .'.enabled', 1);
    }
}
