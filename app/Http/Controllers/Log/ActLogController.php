<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\ActLogService;
use Illuminate\Http\JsonResponse;

class ActLogController extends Controller
{
    /**
     * @var ActLogService
     */
    private $actLog;

    public function __construct(ActLogService $actLog)
    {
        $this->actLog = $actLog;
    }

    /**
     * Display the specified resource.
     *
     * @param string $actId
     *
     * @return JsonResponse
     */
    public function show(string $actId): JsonResponse
    {
        $actsLog = $this->actLog->getAllByActId($actId)->toArray();

        return response()->json($actsLog);
    }
}
