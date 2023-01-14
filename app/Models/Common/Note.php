<?php

namespace App\Models\Common;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Note extends Model
{
    use Notifiable;

    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function getNotitieDatum()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}
