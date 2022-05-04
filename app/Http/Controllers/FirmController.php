<?php

namespace App\Http\Controllers;

use App\Http\Requests\FirmsStoreRequest;
use App\Http\Requests\FirmsUpdateRequest;
use App\Services\ActService;
use App\Services\ContractService;
use App\Services\FirmService;
use App\Services\InvoiceService;
use App\Services\InvoiceServicesService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class FirmController extends Controller
{
    public function __construct(
        FirmService $firms,
        ContractService $contract,
        InvoiceService $invoices,
        InvoiceServicesService $invoiceServices,
        PaymentService $payments,
        ActService $acts
    ) {
        $this->firms = $firms;
        $this->contract = $contract;
        $this->invoices = $invoices;
        $this->invoiceServices = $invoiceServices;
        $this->payments = $payments;
        $this->acts = $acts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->firms->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FirmsStoreRequest $request
     * @return JsonResponse
     */
    public function create(FirmsStoreRequest $request): JsonResponse
    {
        if (!$request->has('firm_name_short')) {
            $request['firm_name_short'] = $request->get('firm_name');
        }

        $firm = $this->firms->create($request->all());

        return response()->json($firm);
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
        $firm = $this->firms->findById($id);

        return response()->json($firm);
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
        $firm = $this->firms->findById($id);

        return response()->json($firm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FirmsUpdateRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(FirmsUpdateRequest $request, string $id): JsonResponse
    {
        $firm = $this->firms->findById($id);

        if (!$request->get('firm_name_short')) {
            $request['firm_name_short'] = $request->get('firm_name');
        }

        $firm->update($request->except(['_method', '_token', 'created_at', 'updated_at']));

        return response()->json('The firm successfully updated');
    }

    public function destroy(string $id): JsonResponse
    {
        $firm = $this->firms->findById($id);
        $contracts = $firm->contracts;

        foreach ($contracts as $contract) {
            foreach ($this->invoices->findByContractId($contract->id) as $invoice) {
                $invoiceId = $invoice->id;
                $this->invoices->destroy($invoiceId);
                $this->invoiceServices->destroyByInvoiceId($invoiceId);
                $this->payments->destroyByInvoiceId($invoiceId);
                $this->acts->destroyByInvoiceId($invoiceId);
            }

            $this->contract->destroy($contract->id);
        }

        $this->firms->destroy($id);

        return response()->json('The firm successfully deleted');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function noActs(): Collection
    {
        return $this->firms->noActs();
    }
}
