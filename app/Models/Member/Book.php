<?php

namespace App\Models\Member;

use App\Models\Administration\Member;
use App\Models\Catalog\Barcode;
use App\Models\Model;
use EloquentFilter\Filterable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
    use Notifiable, Filterable, Sortable;

    protected $table = 'member_books';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'book_barcode_id', 'lend_at', 'take_in_at', 'penalty', 'cost', 'paid',
    ];

    protected $dates = [
        'lend_at', 'take_in_at', 'created_at', 'updated_at'
    ];

    /**
     * Has one member
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    /**
     * Has one barcode
     */
    public function barcode()
    {
        return $this->hasOne(Barcode::class,  'id', 'book_barcode_id');
    }
}
