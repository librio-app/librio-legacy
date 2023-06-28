<?php

namespace App\Http\Controllers\Opac;

use App\Http\Controllers\Controller;

class LendedController extends Controller
{
    public function index()
    {
        $lended = \Auth::user()->lended()->collect();

        return view('opac.lended', [
            'lended' => $lended,
        ]);
    }
}
