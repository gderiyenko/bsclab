<?php

namespace App\Services;

use App\Repositories\ContractRepository;
use Illuminate\Support\Collection;

class ContractService extends BaseService
{
    public function __construct(ContractRepository $repo)
    {
        $this->repo = $repo;
    }

    public function all(): Collection
    {
        return $this->repo->all();
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->repo->getAllByFirmId($firmId);
    }
}
