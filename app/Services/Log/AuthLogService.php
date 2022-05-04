<?php

namespace App\Services\Log;

use App\Repositories\Log\AuthLogRepository;
use App\Services\BaseService;

class AuthLogService extends BaseService
{
    public function __construct(AuthLogRepository $repo)
    {
        $this->repo = $repo;
    }
}
