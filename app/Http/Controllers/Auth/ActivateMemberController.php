<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Hash;

class ActivateMemberController extends Controller
{
    public function activate(string $confirmationKey)
    {
        // TODO
    }
}
