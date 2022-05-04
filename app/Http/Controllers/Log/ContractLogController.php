<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\ContractLogService;
use Illuminate\Http\JsonResponse;

class ContractLogController extends Controller
{
    /**
     * @var ContractLogService
     */
    private $contractLog;

    public function __construct(ContractLogService $contractLog)
    {
        $this->contractLog = $contractLog;
    }

    /**
     * Display the specified resource.
     *
     * @param string $contractId
     *
     * @return JsonResponse
     */
    public function show(string $contractId): JsonResponse
    {
        $contractsLog = $this->contractLog->getAllByContractId($contractId)->toArray();

        return response()->json($contractsLog);
    }
}
