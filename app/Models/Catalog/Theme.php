<?php

namespace App\Models\Catalog;

use App\Models\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Theme extends Model
{
    use Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'themes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active', 'start_at', 'end_at',
    ];

    protected $dates = [
         'start_at', 'end_at', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Get start mutator
     *
     * @param  string  $value
     * @return string|null
     */
    public function getStartAtAttribute($value): ?string
    {
        if ($value != null) {
            $date = \DateTime::createFromFormat('Y-m-d', $value);
            if ($date === false) {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
            }
            return $date->format('d-m-Y');
        }

        return null;
    }

    /**
     * Set start mutator
     *
     * @param  string  $value
     * @return void
     */
    public function setStartAtAttribute($value): void
    {
        if ($value != null) {
            $date = \DateTime::createFromFormat('d-m-Y', $value);
            $this->attributes['start_at'] = $date->format('Y-m-d');
        }
    }

    /**
     * Get end mutator
     *
     * @param  string  $value
     * @return string|null
     */
    public function getEndAtAttribute($value): ?string
    {
        if ($value != null) {
            $date = \DateTime::createFromFormat('Y-m-d', $value);
            if ($date === false) {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
            }
            return $date->format('d-m-Y');
        }

        return null;
    }

    /**
     * Set end mutator
     *
     * @param  string  $value
     * @return void
     */
    public function setEndAtAttribute($value): void
    {
        if ($value != null) {
            $date = \DateTime::createFromFormat('d-m-Y', $value);
            $this->attributes['end_at'] = $date->format('Y-m-d');
        }
    }

    /**
     * Belongs to books
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'theme_book', 'theme_id', 'book_id');
    }
}
