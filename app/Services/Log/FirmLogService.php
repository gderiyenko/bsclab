<?php

namespace App\Services\Log;

use App\Repositories\Log\FirmLogRepository;
use App\Services\BaseService;

class FirmLogService extends BaseService
{
    public function __construct(FirmLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->repo->getAllByFirmId($firmId);
    }
}
