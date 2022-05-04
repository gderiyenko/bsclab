<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository extends BaseRepository
{
    public $sortBy = 'name';
    public $sortOrder = 'asc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param File $model Repo DB ORM Model
     */
    public function __construct(File $model)
    {
        $this->model = $model;
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->model->where('firm_id', $firmId)->with('firm')->get();
    }
}
