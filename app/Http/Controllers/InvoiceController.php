<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesStoreRequest;
use App\Http\Requests\InvoicesUpdateRequest;
use App\Services\ActService;
use App\Services\InvoiceService;
use App\Services\InvoiceServicesService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    public function __construct(
        InvoiceService $invoice,
        InvoiceServicesService $invoiceServices,
        PaymentService $payments,
        ActService $acts
    ) {
        $this->invoice = $invoice;
        $this->invoiceServices = $invoiceServices;
        $this->payments = $payments;
        $this->acts = $acts;
    }

    public function index(): JsonResponse
    {
        $invoices = $this->invoice->all()->toArray();

        return response()->json($invoices);
    }

    public function create(InvoicesStoreRequest $request): JsonResponse
    {
        $invoice = $this->invoice->create([
            'number' => $request->get('invoice')['number'],
            'date' => $request->get('invoice')['date'],
            'firm_id' => $request->get('invoice')['firm_id'],
            'contract_id' => $request->get('invoice')['contract_id'],
            'payment_type' => $request->get('invoice')['payment_type'],
            'amount' => $request->get('invoice')['amount'],
            'amount_text' => $request->get('invoice')['amount_text'],
            'pdv' => $request->get('invoice')['pdv'],
            'pdv_text' => $request->get('invoice')['pdv_text'],
            'pdv_minus' => $request->get('invoice')['pdv_minus'],
            'pdv_minus_text' => $request->get('invoice')['pdv_minus_text'],
        ]);

        foreach ($request->get('invoiceServices') as $invoiceService) {
            $this->invoiceServices->create([
                'invoice_id' => $invoice->id,
                'service_id' => $invoiceService['service_id'],
                'service_quantity' => $invoiceService['service_quantity'],
                'service_price' => $invoiceService['service_price'],
                'amount' => $invoiceService['service_quantity'] * $invoiceService['service_price'],
            ]);
        }

        $this->invoice->update(
            $invoice->id,
            [
                'amount' => $this->invoice->calcAmount($invoice->id),
            ]
        );

        return response()->json('The invoice successfully added');
    }

    public function show(string $id): JsonResponse
    {
        $invoices = $this->invoice->getAllByFirmId($id)->toArray();

        return response()->json($invoices);
    }

    public function edit(string $id): JsonResponse
    {
        $invoice = $this->invoice->findByIdWithServices($id);

        return response()->json($invoice);
    }

    public function update(InvoicesUpdateRequest $request, string $id)
    {
        $this->invoiceServices->destroyByInvoiceId($id);

        foreach ($request->get('invoiceServices') as $invoiceService) {
            $this->invoiceServices->create([
                'invoice_id' => $request->input('invoice')['id'],
                'service_id' => $invoiceService['service_id'],
                'service_quantity' => $invoiceService['service_quantity'],
                'service_price' => $invoiceService['service_price'],
                'amount' => $invoiceService['service_quantity'] * $invoiceService['service_price'],
            ]);
        }

        $invoice = $this->invoice->findById($id);
        $invoice->update([
            'number' => $request->input('invoice')['number'],
            'date' => $request->input('invoice')['date'],
            'contract_id' => $request->input('invoice')['contract_id'],
            'payment_type' => $request->input('invoice')['payment_type'],
            'amount' => $this->invoice->calcAmount($id),
            'amount_text' => $request->input('invoice')['amount_text'],
            'pdv' => $request->input('invoice')['pdv'],
            'pdv_text' => $request->input('invoice')['pdv_text'],
            'pdv_minus' => $request->input('invoice')['pdv_minus'],
            'pdv_minus_text' => $request->input('invoice')['pdv_minus_text'],
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->invoice->destroy($id);
        $this->invoiceServices->destroyByInvoiceId($id);
        $this->payments->destroyByInvoiceId($id);
        $this->acts->destroyByInvoiceId($id);

        return response()->json('The invoice successfully deleted');
    }
}
