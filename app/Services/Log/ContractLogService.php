<?php

namespace App\Services\Log;

use App\Repositories\Log\ContractLogRepository;
use App\Services\BaseService;

class ContractLogService extends BaseService
{
    public function __construct(ContractLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByContractId(string $contractId)
    {
        return $this->repo->getAllByContractId($contractId);
    }
}
