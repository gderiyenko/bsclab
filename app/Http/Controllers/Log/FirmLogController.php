<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\FirmLogService;
use Illuminate\Http\JsonResponse;

class FirmLogController extends Controller
{
    /**
     * @var FirmLogService
     */
    private $firmLog;

    public function __construct(FirmLogService $firmLog)
    {
        $this->firmLog = $firmLog;
    }

    /**
     * Display the specified resource.
     *
     * @param string $firmId
     *
     * @return JsonResponse
     */
    public function show(string $firmId): JsonResponse
    {
        $firmsLog = $this->firmLog->getAllByFirmId($firmId)->toArray();

        return response()->json($firmsLog);
    }
}
