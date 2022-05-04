<?php

namespace App\Repositories\Log;

use App\Models\Log\FirmLog;
use App\Repositories\BaseRepository;

class FirmLogRepository extends BaseRepository
{
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param FirmLog $model Repo DB ORM Model
     */
    public function __construct(FirmLog $model)
    {
        $this->model = $model;
    }

    public function getAllByFirmId(string $firmId)
    {
        $firmsLog = $this->model
            ->where('firm_id', $firmId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        return $firmsLog;
    }
}
