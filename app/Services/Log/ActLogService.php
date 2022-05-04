<?php

namespace App\Services\Log;

use App\Repositories\Log\ActLogRepository;
use App\Services\BaseService;

class ActLogService extends BaseService
{
    public function __construct(ActLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByActId(string $actId)
    {
        return $this->repo->getAllByActId($actId);
    }
}
