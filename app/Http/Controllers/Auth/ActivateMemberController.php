<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ActivateMemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show(string $confirmationKey)
    {
        return view('member.activate.show', ['confirmationKey' => $confirmationKey]);
    }

    public function activate(string $confirmationKey)
    {
        // TODO
    }
}
