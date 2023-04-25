<?php

namespace App\Models\Administration;

use App\Models\Downloadable;
use App\Models\Member\Book;
use App\Models\Member\Reservation;
use App\Notifications\Auth\Reset;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User as Authenticatable;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Route;

class Member extends Authenticatable
{
    use Notifiable, SoftDeletes, Filterable, Sortable, Downloadable;

    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'salutation', 'first_name', 'insertion', 'last_name', 'account', 'email', 'password', 'birthday', 'comments', 'enabled', 'locale',
        'address_line_1', 'address_line_2', 'zipcode', 'state', 'city', 'confirmation_key',
    ];

    protected $dates = [
        'birthday', 'created_at', 'updated_at', 'deleted_at', 'confirmation_key_send_dt',
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
        return $this->first_name .  ' ' . (!empty($this->insertion) ? $this->insertion . ' ' : '' ) . $this->last_name;
    }

    /**
     * Alias
     * @return string
     */
    public function getNameWithSalutation(): string
    {
        return $this->getNameWithSalutationAttribute();
    }

    /**
     * @return string
     */
    public function getNameWithSalutationAttribute(): string
    {
        return trans("salutation." . $this->salutation) . ' ' . $this->getName();
    }

    /**
     * Has many subscriptions
     */
    public function subscriptions()
    {
        $prefix = env('DB_PREFIX', 'librio_');
        $now = new \DateTime();
        $subscriptions = $this->belongsToMany(Subscription::class, 'member_subscription', 'member_id', 'subscription_id')
            ->whereRaw("({$prefix}member_subscription.expire_date IS NULL OR {$prefix}member_subscription.expire_date >= '{$now->format('Y-m-d h:m:s')}')")
            ->orderByDesc('pivot_created_at')
            ->withPivot('expire_date')
            ->withTimestamps()
            ->get();

        // filter subscriptions with valid subscription period
        $periods = config('enums.expire_date_format');
        return $subscriptions->filter(function (Subscription $subscription) use ($periods) {
            if (array_key_exists($subscription->expire_date, $periods)) {
                $period = $periods[$subscription->expire_date];
                $periodDateTime = new \DateTime();
                $periodDateTime->add(new \DateInterval($period));
                $now = new \DateTime();
                if ($periodDateTime >= $now) {
                    return true;
                }
                return false;
            }
            return false;
        });
    }

    /**
     * Has many subscriptions
     */
    public function allSubscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'member_subscription', 'member_id', 'subscription_id')
            ->orderByDesc('pivot_created_at')
            ->withTimestamps();
    }

    /**
     * Has many lended
     */
    public function lended($history = false)
    {
        $relation = $this->hasMany(Book::class, 'member_id')
            ->with(['barcode'])
            ->orderBy('lend_at', 'DESC')
            ->withoutGlobalScope(SoftDeletingScope::class);

        if (!$history) {
            $relation->whereNull('take_in_at');
        }

        return $relation;
    }

    /**
     * Has many taken in
     */
    public function takeIn($onlyWithCosts = false)
    {
        $query = $this->hasMany(Book::class, 'member_id')
            ->whereNotNull('take_in_at')
            ->orderBy('lend_at')
            ->withoutGlobalScope(SoftDeletingScope::class);

        if ($onlyWithCosts) {
            $query->whereRaw('(penalty + costs) != paid');
        }

        return $query;
    }

    /**
     * Has many reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'member_id')
            ->with(['barcode'])
            ->orderBy('created_at');
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

    /**
     * @param string token
     * Send reset link to user via email
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Reset($token, $this->getName()));
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
