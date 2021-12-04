<?php

namespace App\Models\Catalog;

use App\Models\Model;
use App\Service\BarcodeInterface;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model implements BarcodeInterface
{
    use Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'description', 'enabled',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Belongs to books
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
