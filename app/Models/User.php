<?php

namespace App\Models;

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
}
