<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\InvoiceLogService;
use Illuminate\Http\JsonResponse;

class InvoiceLogController extends Controller
{
    /**
     * @var InvoiceLogService
     */
    private $invoiceLog;

    public function __construct(InvoiceLogService $invoiceLog)
    {
        $this->invoiceLog = $invoiceLog;
    }

    /**
     * Display the specified resource.
     *
     * @param string $invoiceId
     *
     * @return JsonResponse
     */
    public function show(string $invoiceId): JsonResponse
    {
        $invoicesLog = $this->invoiceLog->getAllByInvoiceId($invoiceId)->toArray();

        return response()->json($invoicesLog);
    }
}
