<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UsersService
     */
    private $users;

    public function __construct(UsersService $users)
    {
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->users->allWithTrashed();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param UsersStoreRequest $request
     * @return JsonResponse
     */
    public function create(UsersStoreRequest $request): JsonResponse
    {
        $user = $this->users->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
        ]);

        return response()->json('The user successfully added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function edit(string $id): JsonResponse
    {
        $user = $this->users->findByIdWithTrashed($id);
        $user['password'] = null;
        $user['status'] = isset($user['deleted_at']) ? 'Заблокований' : 'Активний';

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UsersUpdateRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(UsersUpdateRequest $request, string $id): JsonResponse
    {
        $deleted_at = ($request->get('status') == 'Активний') ? null : Carbon::now();

        $this->users->update(
            $id,
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'deleted_at' => $deleted_at,
            ]
        );

        if ($request->get('password')) {
            $this->users->update(
                $id,
                [
                    'password' => Hash::make($request->input('password')),
                ]
            );
        }

        return response()->json('The user successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->users->destroy($id);

        return response()->json('The user successfully deleted');
    }
}
