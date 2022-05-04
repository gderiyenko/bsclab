<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseService
{
    /**
     * Repository.
     *
     * @var
     */
    public $repo;

    /**
     * Get all data.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repo->all();
    }

    /**
     * Get all data.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection
    {
        return $this->repo->allWithTrashed();
    }

    /**
     * Create new record.
     *
     * @param array $data
     *
     * @return model
     */
    public function create(array $data): Model
    {
        return $this->repo->create($data);
    }

    /**
     * Find record by id.
     *
     * @param string $id
     *
     * @return Model
     */
    public function findById(string $id): Model
    {
        return $this->repo->findById($id);
    }

    /**
     * Find record by id.
     *
     * @param string $id
     *
     * @return Model
     */
    public function findByIdWithTrashed(string $id): Model
    {
        return $this->repo->findByIdWithTrashed($id);
    }

    /**
     * Update data.
     *
     * @param string $id
     * @param array  $data
     *
     * @return bool
     */
    public function update(string $id, array $data): bool
    {
        return $this->repo->update($id, $data);
    }

    /**
     * Delete record by id.
     *
     * @param string $id
     *
     * @return bool
     */
    public function destroy(string $id): bool
    {
        return $this->repo->destroy($id);
    }

    /**
     * count records.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->repo->count();
    }
}
