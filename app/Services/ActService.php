<?php

namespace App\Services;

use App\Repositories\ActRepository;
use Illuminate\Support\Collection;

class ActService extends BaseService
{
    public function __construct(ActRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByFirmId(string $firmId): array
    {
        return $this->repo->getAllByFirmId($firmId);
    }

    public function all(): Collection
    {
        return $this->repo->all();
    }

    public function destroyByInvoiceId(string $invoiceId)
    {
        $acts = $this->repo->findByInvoiceId($invoiceId);
        foreach ($acts as $act) {
            $act->delete();
        }
    }
}
