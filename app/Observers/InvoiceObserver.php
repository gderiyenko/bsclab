<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Services\Log\InvoiceLogService;
use Illuminate\Support\Facades\Auth;

class InvoiceObserver
{
    public function __construct(InvoiceLogService $invoiceLog)
    {
        $this->invoiceLog = $invoiceLog;
    }

    /**
     * Handle the Invoice "created" event.
     *
     * @param \App\Models\Invoice $invoice
     *
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $contractNumber = $invoice->contract->number ?? null;

        $this->invoiceLog->create([
            'invoice_id' => $invoice->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'створення',
            'invoice_number' => $invoice->number,
            'invoice_date' => $invoice->date,
            'contract_number' => $contractNumber,
            'payment_type' => $invoice->payment_type,
            'amount' => $invoice->amount,
            'pdv' => $invoice->pdv,
            'pdv_minus' => $invoice->pdv_minus,
        ]);
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param \App\Models\Invoice $invoice
     *
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        $contractNumber = $invoice->contract->number ?? null;

        $this->invoiceLog->create([
            'invoice_id' => $invoice->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'оновлення',
            'invoice_number' => $invoice->number,
            'invoice_date' => $invoice->date,
            'contract_number' => $contractNumber,
            'payment_type' => $invoice->payment_type,
            'amount' => $invoice->amount,
            'pdv' => $invoice->pdv,
            'pdv_minus' => $invoice->pdv_minus,
        ]);
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param \App\Models\Invoice $invoice
     *
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        $invoiceLog = $this->invoiceLog->getAllByInvoiceId($invoice->id)->last();

        $this->invoiceLog->create([
            'invoice_id' => $invoice->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'видалення',
            'invoice_number' => $invoice->number,
            'invoice_date' => $invoice->date,
            'contract_number' => $invoiceLog->contract_number,
            'payment_type' => $invoice->payment_type,
            'amount' => $invoice->amount,
            'pdv' => $invoice->pdv,
            'pdv_minus' => $invoice->pdv_minus,
        ]);
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param \App\Models\Invoice $invoice
     *
     * @return void
     */
    public function restored(Invoice $invoice)
    {
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param \App\Models\Invoice $invoice
     *
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
    }
}
