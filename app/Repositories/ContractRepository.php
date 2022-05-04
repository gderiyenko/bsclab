<?php

namespace App\Repositories;

use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ContractRepository extends BaseRepository
{
    public $sortBy = 'date_contract';
    public $sortOrder = 'desc';

    public function __construct(Contract $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        $contracts = $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->with('firm')
            ->get();

        foreach ($contracts as $contractKey => $contract) {
            $contracts[$contractKey]['status'] = ($contracts[$contractKey]['date_end'] >= Carbon::now()) ? 'Діючий' : 'Не діючий';
        }

        return $contracts;
    }

    public function findById(string $id)
    {
        return $this->model->with('firm')->find($id);
    }

    public function getAllByFirmId(string $firmId): array
    {
        $contracts = $this->model
            ->where('firm_id', $firmId)
            ->with('firm')
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        foreach ($contracts as $contractKey => $contract) {
            $contracts[$contractKey]['status'] = ($contracts[$contractKey]['date_end'] >= Carbon::now()) ? 'Діючий' : 'Не діючий';
        }

        return $contracts;
    }

    public function update(string $id, array $data): bool
    {
        $query = $this->model->where('id', $id);
        return $query->update($data);
    }
}
