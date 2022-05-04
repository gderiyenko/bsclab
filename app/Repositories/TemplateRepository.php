<?php

namespace App\Repositories;

use App\Models\Template;

class TemplateRepository extends BaseRepository
{
    public $sortBy = 'name';
    public $sortOrder = 'asc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Template $model Repo DB ORM Model
     */
    public function __construct(Template $model)
    {
        $this->model = $model;
    }

    public function getAllByType(string $type)
    {
        return $this->model
            ->where('type', $type)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }
}
