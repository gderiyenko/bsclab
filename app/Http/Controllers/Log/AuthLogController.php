<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Services\Log\AuthLogService;
use Illuminate\Http\JsonResponse;

class AuthLogController extends Controller
{
    /**
     * @var AuthLogService
     */
    private $authLog;

    public function __construct(AuthLogService $authLog)
    {
        $this->authLog = $authLog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $authLogs = $this->authLog->all()->toArray();

        return response()->json($authLogs);
    }
}
