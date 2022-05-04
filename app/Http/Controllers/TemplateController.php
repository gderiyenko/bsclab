<?php

namespace App\Http\Controllers;

use App\Http\Requests\TemplatesStoreRequest;
use App\Http\Requests\TemplatesUpdateRequest;
use App\Models\Service;
use App\Models\Template;
use App\Services\ActService;
use App\Services\ContractService;
use App\Services\FirmService;
use App\Services\InvoiceService;
use App\Services\TemplateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PhpOffice\PhpWord\TemplateProcessor;

class TemplateController extends Controller
{
    public function __construct(
        TemplateService $templates,
        FirmService $firms,
        ContractService $contracts,
        InvoiceService $invoices,
        ActService $acts
    ) {
        $this->templates = $templates;
        $this->firms = $firms;
        $this->contracts = $contracts;
        $this->invoices = $invoices;
        $this->acts = $acts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->templates->all();
    }

    /**
     * Show the template for creating a new resource.
     *
     * @param TemplatesStoreRequest $request
     *
     * @return JsonResponse
     */
    public function create(TemplatesStoreRequest $request): JsonResponse
    {
        if ($request->hasFile('file')) {
            $this->templates->create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'body' => base64_encode($request->file('file')->get()),
            ]);
        }

        return response()->json('The template successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param string $type
     *
     * @return JsonResponse
     */
    public function show(string $type): JsonResponse
    {
        $templates = $this->templates->getAllByType($type)->toArray();

        return response()->json($templates);
    }

    /**
     * Show the template for editing the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function edit(string $id): JsonResponse
    {
        $template = $this->templates->findById($id);

        return response()->json($template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemplatesUpdateRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(TemplatesUpdateRequest $request, string $id): JsonResponse
    {
        $this->templates->update(
            $id,
            [
                'name' => $request->input('name'),
            ]
        );

        return response()->json('The template successfully updated');
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
        $this->templates->findById($id)->destroy($id);

        return response()->json('The file successfully deleted');
    }

    public function download(string $id): JsonResponse
    {
        $template = Template::findOrFail($id);
        $fileName = $template->name . '.docx';

        return response()->json(['fileName' => $fileName, 'fileBody' => $template->body]);
    }

    public function docxCreate(Request $request)
    {
        $documentId = $request[0];
        $templateId = $request[1]['id'];
        $templateType = $request[1]['type'];

        $template = Template::find($templateId);

        switch ($templateType) {
            case 'contract':
                $contract = $this->contracts->findById($documentId);
                $firm = $contract->firm;
                $fileName = 'Договір №' . $contract->number;
                break;
            case 'invoice':
                $invoice = $this->invoices->findById($documentId);
                $fileName = 'Рахунок №' . $invoice->number;
                $invoiceServices = $invoice->invoiceServices;
                $contract = $invoice->contract ?? null;
                $firm = $invoice->firm;
                break;
            case 'act':
                $act = $this->acts->findById($documentId);
                $fileName = 'Акт №' . $act->number;
                $invoice = $act->invoice;
                $invoiceServices = $invoice->invoiceServices;
                $contract = $invoice->contract ?? null;
                $firm = $invoice->firm;
                break;
            default:
                die();
        }

        $file = tmpfile();
        $tempFilePath = stream_get_meta_data($file)['uri'];
        file_put_contents($tempFilePath, base64_decode($template->body));

        $templateProcessor = new TemplateProcessor($tempFilePath);

        // Массив для Договоров
        $templateProcessor->setValue('firm_name', $firm->firm_name);
        $templateProcessor->setValue('firm_name_short', $firm->firm_name_short);
        $templateProcessor->setValue('edrpou', $firm->edrpou);
        $templateProcessor->setValue('ipn', $firm->ipn);
        $templateProcessor->setValue('tax', $firm->tax);
        $templateProcessor->setValue('boss_position', $firm->boss_position);
        $templateProcessor->setValue('boss_pib', $firm->boss_pib);
        $templateProcessor->setValue('boss_pib_short', pibConverter($firm->boss_pib));
        $templateProcessor->setValue('work_position', $firm->work_position);
        $templateProcessor->setValue('work_pib', $firm->work_pib);
        $templateProcessor->setValue('work_pib_short', pibConverter($firm->work_pib));
        $templateProcessor->setValue('addr_zip_ur', $firm->addr_zip_ur);
        $templateProcessor->setValue('addr_obl_ur', $firm->addr_obl_ur);
        $templateProcessor->setValue('addr_city_ur', $firm->addr_city_ur);
        $templateProcessor->setValue('addr_street_ur', $firm->addr_street_ur);
        $templateProcessor->setValue('addr_house_ur', $firm->addr_house_ur);
        $templateProcessor->setValue('addr_office_ur', $firm->addr_office_ur);
        $templateProcessor->setValue('addr_zip_fact', $firm->addr_zip_fact);
        $templateProcessor->setValue('addr_obl_fact', $firm->addr_obl_fact);
        $templateProcessor->setValue('addr_city_fact', $firm->addr_city_fact);
        $templateProcessor->setValue('addr_street_fact', $firm->addr_street_fact);
        $templateProcessor->setValue('addr_house_fact', $firm->addr_house_fact);
        $templateProcessor->setValue('addr_office_fact', $firm->addr_office_fact);
        $templateProcessor->setValue('bank_name', $firm->bank_name);
        $templateProcessor->setValue('account_number', $firm->account_number);
        $templateProcessor->setValue('bank_mfo', $firm->bank_mfo);
        $templateProcessor->setValue('phone_shared', $firm->phone_shared);
        $templateProcessor->setValue('phone_acc', $firm->phone_acc);
        $templateProcessor->setValue('phone_work', $firm->phone_work);
        $templateProcessor->setValue('email_shared', $firm->email_shared);
        $templateProcessor->setValue('email_acc', $firm->email_acc);
        $templateProcessor->setValue('email_work', $firm->email_work);
        $templateProcessor->setValue('carr_name', $firm->carr_name);
        $templateProcessor->setValue('carr_city', $firm->carr_city);
        $templateProcessor->setValue('carr_dep', $firm->carr_dep);
        $templateProcessor->setValue('carr_pib', $firm->carr_pib);
        $templateProcessor->setValue('carr_phone', $firm->carr_phone);

        if ($contract) {
            $templateProcessor->setValue('contract_number', $contract->number);
            $templateProcessor->setValue('contract_date_cyf', strftime("%d.%m.%Y р.", strtotime($contract->date_contract)));
            $contractMonth = getMonthUkr($contract->date_contract);
            $templateProcessor->setValue('contract_date', strftime("«%d» ${contractMonth} %Y р.", strtotime($contract->date_contract)));
            $contractEndMonth = getMonthUkr($contract->date_end);
            $templateProcessor->setValue('contract_date_end', strftime("«%d» ${contractEndMonth} %Y р.", strtotime($contract->date_end)));
        } else {
            $templateProcessor->setValue('contract_number', null);
            $templateProcessor->setValue('contract_date_cyf', null);
            $templateProcessor->setValue('contract_date', null);
            $templateProcessor->setValue('contract_date_end', null);
        }
        //////////////////////////////////////////////////////////////

        // Дополнительный массив для счетов
        if (isset($invoice, $invoiceServices)) {
            $templateProcessor->setValue('inv_number', $invoice->number);
            $invoiceMonth = getMonthUkr($invoice->date);
            $templateProcessor->setValue('inv_date', strftime("«%d» ${invoiceMonth} %Y р.", strtotime($invoice->date)));
            $templateProcessor->setValue('inv_date_cyf', strftime("%d.%m.%Y р.", strtotime($invoice->date)));
            $templateProcessor->setValue('inv_count', $invoiceServices->count());
            $templateProcessor->setValue('amount', str_replace('.', ',', $invoice->amount));
            $templateProcessor->setValue('amount_text', str_replace('.', ',', $invoice->amount_text));
            $templateProcessor->setValue('amount_pdv', str_replace('.', ',', $invoice->pdv));
            $templateProcessor->setValue('amount_pdv_text', str_replace('.', ',', $invoice->pdv_text));
            $templateProcessor->setValue('pdv_minus', str_replace('.', ',', $invoice->pdv_minus));
            $templateProcessor->setValue('pdv_minus_text', str_replace('.', ',', $invoice->pdv_minus_text));

            foreach ($invoiceServices as $invoiceServiceKey => $invoiceService) {
                $serviceMaterial = Service::find($invoiceService->service->parent_id)->name;
                ++$invoiceServiceKey;
                $templateProcessor->setValue('inv_material_' . $invoiceServiceKey, $serviceMaterial);
                $templateProcessor->setValue('inv_charact_' . $invoiceServiceKey, $invoiceService->service->name);
                $templateProcessor->setValue('inv_quantity_' . $invoiceServiceKey, $invoiceService->service_quantity);
                $templateProcessor->setValue('inv_price_' . $invoiceServiceKey, str_replace('.', ',', $invoiceService->service_price));
                $templateProcessor->setValue('inv_amount_' . $invoiceServiceKey, str_replace('.', ',', $invoiceService->amount));
            }
        }
        ////////////////////////////////////////////////////////////////

        // Дополнительный массив для актов
        if (isset($act)) {
            $templateProcessor->setValue('act_number', $act->number);
            $actMonth = getMonthUkr($act->date);
            $templateProcessor->setValue('act_date', strftime("«%d» ${actMonth} %Y р.", strtotime($act->date)));
            $templateProcessor->setValue('act_date_cyf', strftime("%d.%m.%Y р.", strtotime($act->date)));
        }
        ////////////////////////////////////////////////////////////////

        $modifiedFile = $templateProcessor->save();
        $fileBody = file_get_contents($modifiedFile);

        return response()->json(['fileName' => $fileName . '.docx', 'fileBody' => base64_encode($fileBody)]);
    }
}
