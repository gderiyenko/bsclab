<?php

namespace App\Repositories\Log;

use App\Models\Log\ActLog;
use App\Repositories\BaseRepository;

class ActLogRepository extends BaseRepository
{
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param ActLog $model Repo DB ORM Model
     */
    public function __construct(ActLog $model)
    {
        $this->model = $model;
    }

    public function getAllByActId(string $actId)
    {
        $actsLog = $this->model
            ->where('act_id', $actId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        return $actsLog;
    }
}
