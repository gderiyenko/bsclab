<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentsRequest;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class PaymentController extends Controller
{
    /**
     * @var PaymentService
     */
    private $payment;

    public function __construct(PaymentService $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->payment->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PaymentsRequest $request
     * @return JsonResponse
     */
    public function create(PaymentsRequest $request): JsonResponse
    {
        $this->payment->create([
            'firm_id' => $request->input('firm_id'),
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'invoice_id' => $request->input('invoice_id'),
            'description' => $request->input('description'),
        ]);

        return response()->json('The payment successfully added');
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
        $payments = $this->payment->getAllByFirmId($id);

        return response()->json($payments);
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
        $payment = $this->payment->findById($id);

        return response()->json($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentsRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(PaymentsRequest $request, string $id): JsonResponse
    {
        $payment = $this->payment->findById($id);
        $payment->update([
            'amount' => $request->input('amount'),
            'date' => $request->input('date'),
            'invoice_id' => $request->input('invoice_id'),
            'description' => $request->input('description'),
        ]);

        return response()->json('The payment successfully updated');
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
        $this->payment->destroy($id);

        return response()->json('The payment successfully deleted');
    }
}
