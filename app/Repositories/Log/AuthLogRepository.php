<?php

namespace App\Repositories\Log;

use App\Models\Log\AuthLog;
use App\Repositories\BaseRepository;

class AuthLogRepository extends BaseRepository
{
    public $sortBy = 'created_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param AuthLog $model Repo DB ORM Model
     */
    public function __construct(AuthLog $model)
    {
        $this->model = $model;
    }
}
