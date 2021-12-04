<?php

namespace App\Models\Administration;

use App\Models\Model;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;

class Subscription extends Model
{
    use Notifiable, SoftDeletes, Filterable, Sortable;

    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'book_limit', 'book_lending_days',
        'currency', 'subscription_price',
        'penalty', 'penalty_price',
        'payment_period', 'enabled', 'expire_date',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Has many members
     */
    public function members()
    {
        return $this->belongsToMany(Subscription::class, 'member_subscription', 'member_id', 'subscription_id')->withTimestamps();
    }
}
