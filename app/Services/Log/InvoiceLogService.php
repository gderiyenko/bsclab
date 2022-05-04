<?php

namespace App\Services\Log;

use App\Repositories\Log\InvoiceLogRepository;
use App\Services\BaseService;

class InvoiceLogService extends BaseService
{
    public function __construct(InvoiceLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByInvoiceId(string $invoiceId)
    {
        return $this->repo->getAllByInvoiceId($invoiceId);
    }
}
