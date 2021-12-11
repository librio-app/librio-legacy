<?php

namespace App\Models\Catalog;

use App\Models\Downloadable;
use App\Models\Model;
use App\Service\BarcodeInterface;
use EloquentFilter\Filterable;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model implements BarcodeInterface
{
    use Notifiable, SoftDeletes, Filterable, Sortable, Downloadable;

    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'title', 'description', 'series_nr', 'isbn', 'ean', 'enabled', 'author_id', 'category_id', 'publisher_id', 'type_id', 'series_id', 'serie_nr'
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
     * Has one type
     */
    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    /**
     * Has one publisher
     */
    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }

    /**
     * Has one author
     */
    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    /**
     * Has one category
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Has one series
     */
    public function series()
    {
        return $this->hasOne(Series::class, 'id', 'series_id');
    }

    /**
     * Has many themes
     */
    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'theme_book', 'book_id', 'theme_id');
    }

    /**
     * Has many barcodes
     */
    public function barcodes()
    {
        return $this->hasMany(Barcode::class, 'book_id');
    }

    /**
     * Define the filter specific for books and themes
     *
     * @return ModelFilter
     */
    public function modelFilter()
    {
        $route = \Route::current();
        list($folder, $file) = explode('/', $route->uri());

        if (empty($folder) || empty($file)) {
            return $this->provideFilter();
        }

        // custom filtering for detail
        if ($folder === 'catalog' && $file === 'themes' && $route->action['as'] === 'themes.edit') {
            $file = 'theme';
        }

        $class = '\App\Filters\\' . ucfirst($folder) . '\\' . ucfirst($file);

        return $this->provideFilter($class);
    }
}
