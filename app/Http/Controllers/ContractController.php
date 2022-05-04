<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractsStoreRequest;
use App\Http\Requests\ContractsUpdateRequest;
use App\Services\ActService;
use App\Services\ContractService;
use App\Services\InvoiceService;
use App\Services\InvoiceServicesService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ContractController extends Controller
{
    public function __construct(
        ContractService $contract,
        InvoiceService $invoices,
        InvoiceServicesService $invoiceServices,
        PaymentService $payments,
        ActService $acts
    ) {
        $this->contract = $contract;
        $this->invoices = $invoices;
        $this->invoiceServices = $invoiceServices;
        $this->payments = $payments;
        $this->acts = $acts;
    }

    public function index(): Collection
    {
        return $this->contract->all();
    }

    public function create(ContractsStoreRequest $request): JsonResponse
    {
        $this->contract->create(
            $request->all()
        );

        return response()->json('The contract successfully added');
    }

    public function show(string $id): JsonResponse
    {
        $contracts = $this->contract->getAllByFirmId($id);

        return response()->json($contracts);
    }

    public function edit(string $id): JsonResponse
    {
        $contract = $this->contract->findById($id);

        return response()->json($contract);
    }

    public function update(ContractsUpdateRequest $request, string $id): JsonResponse
    {
        $contract = $this->contract->findById($id);
        $contract->update($request->except(['_method', '_token', 'created_at', 'updated_at', 'firm']));

        return response()->json('The contract successfully updated');
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
        foreach ($this->invoices->findByContractId($id) as $invoice) {
            $invoiceId = $invoice->id;
            $this->invoices->destroy($invoiceId);
            $this->invoiceServices->destroyByInvoiceId($invoiceId);
            $this->payments->destroyByInvoiceId($invoiceId);
            $this->acts->destroyByInvoiceId($invoiceId);
        }

        $this->contract->destroy($id);

        return response()->json('The contract successfully deleted');
    }
}
