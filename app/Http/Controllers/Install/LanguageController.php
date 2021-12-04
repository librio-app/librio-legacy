<?php

namespace App\Http\Controllers\Install;

use Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LanguageController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('install.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Set locale
        Session::put('locale', $request['lang']);

        return redirect('install/database');
    }
}
