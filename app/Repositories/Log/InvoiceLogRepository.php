<?php

namespace App\Repositories\Log;

use App\Models\Log\InvoiceLog;
use App\Repositories\BaseRepository;

class InvoiceLogRepository extends BaseRepository
{
    public $sortBy = 'updated_at';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param InvoiceLog $model Repo DB ORM Model
     */
    public function __construct(InvoiceLog $model)
    {
        $this->model = $model;
    }

    public function getAllByInvoiceId(string $invoiceId)
    {
        $invoicesLog = $this->model
            ->where('invoice_id', $invoiceId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        return $invoicesLog;
    }
}
