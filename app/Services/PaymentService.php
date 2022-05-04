<?php

namespace App\Services;

use App\Repositories\PaymentRepository;

class PaymentService extends BaseService
{
    public function __construct(PaymentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByFirmId(string $firmId)
    {
        return $this->repo->getAllByFirmId($firmId);
    }

    public function destroyByInvoiceId(string $invoiceId)
    {
        $payments = $this->repo->findByInvoiceId($invoiceId);
        foreach ($payments as $payment) {
            $payment->delete();
        }
    }
}
