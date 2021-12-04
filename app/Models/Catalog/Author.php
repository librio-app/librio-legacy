<?php

namespace App\Models\Catalog;

use App\Models\Model;
use App\Service\BarcodeInterface;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Author extends Model implements BarcodeInterface
{
    use Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'authors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'first_name', 'last_name', 'description', 'birthday', 'enabled',
    ];

    protected $dates = [
        'birthday', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Belongs to books
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    /**
     * Alias
     * @return string
     */
    public function getName(): string
    {
        return $this->getNameAttribute();
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->first_name .  ' ' . $this->last_name;
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get birthday mutator
     *
     * @param  string  $value
     * @return string|null
     */
    public function getBirthdayAttribute($value): ?string
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
     * Set birthday mutator
     *
     * @param  string  $value
     * @return void
     */
    public function setBirthdayAttribute($value): void
    {
        if ($value != null) {
            $date = \DateTime::createFromFormat('d-m-Y', $value);
            $this->attributes['birthday'] = $date->format('Y-m-d');
        }
    }
}
