<?php

namespace App\Models;

use App\Notifications\Auth\Reset;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Reset($token, $this->name));
    }
}
