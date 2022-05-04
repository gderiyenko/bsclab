<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicesRequest;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ServiceController extends Controller
{
    /**
     * @var ServiceService
     */
    private $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->service->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ServicesRequest $request
     * @return JsonResponse
     */
    public function create(ServicesRequest $request): JsonResponse
    {
        $this->service->create([
            'parent_id' => $request->input('parent_id'),
            'name' => $request->input('name'),
        ]);

        return response()->json('The service successfully added');
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
        $service = $this->service->findById($id);

        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServicesRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(ServicesRequest $request, string $id): JsonResponse
    {
        $this->service->update(
            $id,
            [
                'parent_id' => $request->input('parent_id'),
                'name' => $request->input('name'),
            ]
        );

        return response()->json('The service successfully updated');
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
        $this->service->destroy($id);

        return response()->json('The service successfully deleted');
    }
}
