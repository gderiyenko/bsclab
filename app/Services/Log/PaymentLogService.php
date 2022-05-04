<?php

namespace App\Services\Log;

use App\Repositories\Log\PaymentLogRepository;
use App\Services\BaseService;

class PaymentLogService extends BaseService
{
    public function __construct(PaymentLogRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllByPaymentId(string $paymentId)
    {
        return $this->repo->getAllByPaymentId($paymentId);
    }
}
