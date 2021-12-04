<?php

namespace App\Models\Auth;

use App\Notifications\Auth\Reset;
use EloquentFilter\Filterable;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\User as Authenticatable;
use Route;

class User extends Authenticatable
{
    use LaratrustUserTrait, Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'enabled', 'locale',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * @param string token
     * Send reset link to user via email
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Reset($token));
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
}
