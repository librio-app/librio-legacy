<?php

namespace App\Models\Catalog;

use App\Models\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Member\Book as Lended;

class Barcode extends Model
{
    use Notifiable, Filterable, Sortable;

    protected $table = 'book_barcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id', 'barcode', 'status',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->barcode;
    }

    /**
     * Has one book
     */
    public function book()
    {
        return $this->hasOne(Book::class, 'id', 'book_id');
    }

    /**
     * Has many lended books
     */
    public function lended()
    {
        return $this->hasMany(Lended::class, 'book_barcode_id')->whereNull('take_in_at')->orderBy('lend_at')->withoutGlobalScope(SoftDeletingScope::class);
    }

    /**
     * @return bool
     */
    public function allowedToDelete(): bool
    {
        return $this->status !== 'lended';
    }
}
