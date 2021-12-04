<?php

namespace App\Http\Controllers\Install;

use App\Http\Requests\Install\Setting as Request;
use App\Utilities\Installer;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
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
        return view('install.settings.create');
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
        // Create company name
        Installer::createCompanyName($request->get('company_name'));

        // Create user
        Installer::createUser(
            $request->get('user_email'),
            $request->get('user_name'),
            $request->get('user_password'),
            session('locale')
        );

        // Make the final touches
        Installer::finalTouches();

        // Redirect to dashboard
        return redirect('auth/login');
    }
}
