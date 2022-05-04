<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UsersRepository extends BaseRepository
{
    public $sortByFirst = 'deleted_at';
    public $sortBySecond = 'role';
    public $sortByThird = 'name';

    public $sortOrder = 'asc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param User $model Repo DB ORM Model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->model
            ->orderBy($this->sortByFirst, $this->sortOrder)
            ->orderBy($this->sortBySecond, $this->sortOrder)
            ->orderBy($this->sortByThird, $this->sortOrder)
            ->withTrashed()->get();
    }

    /**
     * Update record in the database and get data back.
     *
     * @param string $id
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        $query = $this->model->withTrashed()->where('id', $id);
        return $query->update($data);
    }
}
