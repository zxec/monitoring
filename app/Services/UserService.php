<?php

namespace App\Services;

use App\Models\User;
use App\Models\Gender;
use App\Models\Status;
use App\Models\Position;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Spatie\Activitylog\Models\Activity;

class UserService
{
    /**
     * Create a new user.
     *
     * @param $request
     * @return RedirectResponse
     */
    public function store($request): RedirectResponse
    {
        $request = $request->validated();
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request);
        $user->assignRole($request['role_id']);
        toastr()->success(__('flash.create_user'), __('flash.users'));
        return redirect('user');
    }

    /**
     * Update an user.
     *
     * @param User $user
     * @param $request
     * @return RedirectResponse
     */
    public function update(User $user, $request): RedirectResponse
    {
        $request = $request->validated();
        if (empty($request['password'])) {
            unset($request['password']);
        } else {
            $request['password'] = Hash::make($request['password']);
        }
        $user->update($request);
        $user->syncRoles($request['role_id']);
        toastr()->success(__('flash.edit_user'), __('flash.users'));
        return redirect('user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('user.edit')->with([
            'action' => [
                'url' => 'user.store',
            ],
            'departments' => Department::pluck('name', 'id'),
            'positions' => Position::pluck('name', 'id'),
            'genders' => Gender::pluck('name', 'id'),
            'statuses' => Status::pluck('name', 'id'),
            'roles' => Role::pluck('name', 'id'),
            'title' => __('form.new_user'),
            'submitButton' => __('form.create')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('user.edit')->with([
            'user' => $user,
            'action' => [
                'url' => 'user.update',
                'data' => $user->id,
                'method' => 'patch',
            ],
            'departments' => Department::pluck('name', 'id'),
            'positions' => Position::pluck('name', 'id'),
            'genders' => Gender::pluck('name', 'id'),
            'statuses' => Status::pluck('name', 'id'),
            'roles' => Role::pluck('name', 'id'),
            'title' => __('form.edit'),
            'submitButton' => __('form.save'),
            'logs'  => Activity::forSubject($user)->get(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::user()->id !== $user->id) {
            $user->delete();
            toastr()->success(__('flash.delete_user'), __('flash.users'));
        } else {
            toastr()->error(__('flash.fail_delete_user'), __('flash.users'));
        }
        return redirect('user');
    }
}
