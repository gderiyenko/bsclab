<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\Log\PaymentLogService;
use Illuminate\Support\Facades\Auth;

class PaymentObserver
{
    public function __construct(PaymentLogService $paymentLog)
    {
        $this->paymentLog = $paymentLog;
    }

    /**
     * Handle the Payment "created" event.
     *
     * @param \App\Models\Payment $payment
     *
     * @return void
     */
    public function created(Payment $payment)
    {
        $this->paymentLog->create([
            'payment_id' => $payment->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'створення',
            'date' => $payment->date,
            'amount' => $payment->amount,
            'invoice_number' => $payment->invoice->number,
            'description' => $payment->description,
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param \App\Models\Payment $payment
     *
     * @return void
     */
    public function updated(Payment $payment)
    {
        $this->paymentLog->create([
            'payment_id' => $payment->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'оновлення',
            'date' => $payment->date,
            'amount' => $payment->amount,
            'invoice_number' => $payment->invoice->number,
            'description' => $payment->description,
        ]);
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param \App\Models\Payment $payment
     *
     * @return void
     */
    public function deleted(Payment $payment)
    {
        $paymentLog = $this->paymentLog->getAllByPaymentId($payment->id)->last();

        $this->paymentLog->create([
            'payment_id' => $payment->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'видалення',
            'date' => $payment->date,
            'amount' => $payment->amount,
            'invoice_number' => $paymentLog->invoice_number,
            'description' => $payment->description,
        ]);
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param \App\Models\Payment $payment
     *
     * @return void
     */
    public function restored(Payment $payment)
    {
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param \App\Models\Payment $payment
     *
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
    }
}
