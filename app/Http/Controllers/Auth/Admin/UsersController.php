<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Http\Requests\Auth\User as Request;
use Hash;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->collect();

        $roles = collect(Role::all()->pluck('display_name', 'id'))
            ->prepend(trans('general.all_type', ['type' => trans_choice('general.roles', 2)]), '');

        return view('auth.users.index', compact('users', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();

        return view('auth.users.create', compact('roles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // Create user
        $request['password'] = Hash::make($request['password']);
        $request['password_confirmation'] = Hash::make($request['password_confirmation']);
        $user = User::create($request->input());

        // Attach roles
        $user->roles()->attach($request['roles']);

        $message = trans('messages.success.added', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return redirect('auth/users');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        // Don't show roles with customer permission
        $roles = Role::all();

        return view('auth.users.edit', compact('user', 'roles'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request)
    {
        // Do not reset password if not entered/changed
        if (empty($request['password'])) {
            unset($request['password']);
            unset($request['password_confirmation']);
        } else {
            $request['password'] = Hash::make($request['password']);
            $request['password_confirmation'] = Hash::make($request['password_confirmation']);
        }

        // Update user
        $user->update($request->input());

        // Sync roles
        $user->roles()->sync($request['roles']);

        $message = trans('messages.success.updated', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return redirect('auth/users');
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable(User $user)
    {
        $user->enabled = 1;
        $user->save();

        $message = trans('messages.success.enabled', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return redirect()->route('users.index');
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable(User $user)
    {
        $user->enabled = 0;
        $user->save();

        $message = trans('messages.success.disabled', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return redirect()->route('users.index');
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
