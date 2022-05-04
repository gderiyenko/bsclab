<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActsStoreRequest;
use App\Http\Requests\ActsUpdateRequest;
use App\Services\ActService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ActController extends Controller
{
    /**
     * @var ActService
     */
    private $act;

    public function __construct(ActService $act)
    {
        $this->act = $act;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $acts = $this->act->all()->toArray();

        return response()->json($acts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ActsStoreRequest $request
     * @return JsonResponse
     */
    public function create(ActsStoreRequest $request): JsonResponse
    {
        $act = $this->act->create($request->all());

        return response()->json($act);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $acts = $this->act->getAllByFirmId($id)->toArray();

        return response()->json($acts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function edit(string $id): JsonResponse
    {
        $act = $this->act->findById($id);

        return response()->json($act);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ActsUpdateRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(ActsUpdateRequest $request, string $id): JsonResponse
    {
        $act = $this->act->findById($id);
        $act->update($request->except(['_method', '_token', 'created_at', 'updated_at']));

        return response()->json('The act successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->act->destroy($id);

        return response()->json('The act successfully deleted');
    }
}
