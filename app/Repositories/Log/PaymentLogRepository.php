<?php

namespace App\Repositories\Log;

use App\Models\Log\PaymentLog;
use App\Repositories\BaseRepository;

class PaymentLogRepository extends BaseRepository
{
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param PaymentLog $model Repo DB ORM Model
     */
    public function __construct(PaymentLog $model)
    {
        $this->model = $model;
    }

    public function getAllByPaymentId(string $paymentId)
    {
        $paymentsLog = $this->model
            ->where('payment_id', $paymentId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        return $paymentsLog;
    }
}
