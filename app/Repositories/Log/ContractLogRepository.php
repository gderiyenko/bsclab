<?php

namespace App\Repositories\Log;

use App\Models\Log\ContractLog;
use App\Repositories\BaseRepository;

class ContractLogRepository extends BaseRepository
{
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param ContractLog $model Repo DB ORM Model
     */
    public function __construct(ContractLog $model)
    {
        $this->model = $model;
    }

    public function getAllByContractId(string $contractId)
    {
        $contractsLog = $this->model
            ->where('contract_id', $contractId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        return $contractsLog;
    }
}
