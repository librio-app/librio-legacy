<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function show()
    {
        return view('auth.admin.login.create');
    }

    public function store()
    {
        // Attempt to login
        if (!auth('web')->attempt(request(['email', 'password']), request('remember', false))) {
            flash(trans('auth.failed'))->error();

            return back();
        }

        // Get user object
        $user = auth('web')->user();

        // Check if user is enabled
        if (!$user->enabled) {
            $this->logout();

            flash(trans('auth.disabled'))->error();

            return redirect('admin/auth/login');
        }

        return redirect($this->redirectTo);
    }

    public function destroy()
    {
        $this->logout();

        return redirect('admin/auth/login');
    }

    public function logout()
    {
        auth('web')->logout();

        // Session destroy is required if stored in database
        if (env('SESSION_DRIVER') == 'database') {
            $request = app('Illuminate\Http\Request');
            $request->session()->getHandler()->destroy($request->session()->getId());
        }
    }
}
