<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\PaymentLogService;
use Illuminate\Http\JsonResponse;

class PaymentLogController extends Controller
{
    /**
     * @var PaymentLogService
     */
    private $paymentLog;

    public function __construct(PaymentLogService $paymentLog)
    {
        $this->paymentLog = $paymentLog;
    }

    /**
     * Display the specified resource.
     *
     * @param string $paymentId
     *
     * @return JsonResponse
     */
    public function show(string $paymentId): JsonResponse
    {
        $paymentsLog = $this->paymentLog->getAllByPaymentId($paymentId)->toArray();

        return response()->json($paymentsLog);
    }
}
