<?php

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends BaseRepository
{
    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Service $model Repo DB ORM Model
     */
    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function destroy(string $id): bool
    {
        if ($this->model->parent_id == 0) {
            $childrenIds = $this->model->where('parent_id', $id)->pluck('id');
            $this->model->destroy($childrenIds);
        }

        $this->model->destroy($id);

        return true;
    }
}
