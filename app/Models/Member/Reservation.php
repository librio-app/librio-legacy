<?php

namespace App\Models\Member;

use App\Models\Administration\Member;
use App\Models\Catalog\Barcode;
use App\Models\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Reservation extends Model
{
    use Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'member_reservations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'book_barcode_id'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
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
        return $this->hasOne(Barcode::class, 'id', 'book_barcode_id');
    }
}
