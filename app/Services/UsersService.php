<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UsersService extends BaseService
{
    public function __construct(UsersRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data): Model
    {
        $data['password'] = Hash::make($data['password']);
        return parent::create($data);
    }
}
