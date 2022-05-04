<?php

namespace App\Services;

use App\Repositories\InvoiceServicesRepository;

class InvoiceServicesService extends BaseService
{
    public function __construct(InvoiceServicesRepository $repo)
    {
        $this->repo = $repo;
    }

    public function findByInvoiceId(string $invoiceId)
    {
        return $this->repo->findByInvoiceId($invoiceId);
    }

    public function destroyByInvoiceId(string $invoiceId)
    {
        $invoiceServices = $this->repo->findByInvoiceId($invoiceId);
        foreach ($invoiceServices as $invoiceService) {
            $invoiceService->delete();
        }
    }
}
