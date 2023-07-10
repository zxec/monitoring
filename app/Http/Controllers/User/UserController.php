<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\View\View;
use App\Services\UserService;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public UserService $service;

    public function __construct(UserService $service)
    {
        $this->authorizeResource(User::class);
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return mixed
     */
    public function index(UserDataTable $dataTable): mixed
    {
        return $dataTable->render('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return $this->service->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        return $this->service->store($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        return $this->service->edit($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        return $this->service->update($user, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        return $this->service->destroy($user);
    }
}
