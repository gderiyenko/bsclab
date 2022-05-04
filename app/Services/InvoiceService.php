<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use Illuminate\Support\Collection;

class InvoiceService extends BaseService
{
    public function __construct(InvoiceRepository $repo)
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

    public function findByIdWithServices(string $id)
    {
        return $this->repo->findByIdWithServices($id);
    }

    public function findByContractId(string $contractId)
    {
        return $this->repo->findByContractId($contractId);
    }

    public function calcAmount(string $id)
    {
        $invoice = $this->repo->findById($id);
        $sum = 0;

        foreach ($invoice->invoiceServices as $invoiceService) {
            $sum += $invoiceService->amount;
        }

        return $sum;
    }
}
