<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Support\Collection;

class PaymentRepository extends BaseRepository
{
    public $sortBy = 'date';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Payment $model Repo DB ORM Model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->with('firm')
            ->get();
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->model
            ->where('firm_id', $firmId)
            ->with('invoice')
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }
}
