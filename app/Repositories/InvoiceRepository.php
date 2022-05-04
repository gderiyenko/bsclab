<?php

namespace App\Repositories;

use App\Models\Firm;
use App\Models\Invoice;
use Illuminate\Support\Collection;

class InvoiceRepository extends BaseRepository
{
    public $sortBy = 'number';
    public $sortOrder = 'asc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Invoice $model Repo DB ORM Model
     */
    public function __construct(Invoice $model, Firm $firm)
    {
        $this->model = $model;
        $this->firm = $firm;
    }

    public function getAllByFirmId(string $firmId)
    {
        $invoices = $this->model
            ->where('firm_id', $firmId)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        $firmName = $this->firm->find($firmId)->firm_name;
        $firmNameShort = $this->firm->find($firmId)->firm_name_short;

        foreach ($invoices as $invoiceKey => $invoice) {
            $invoices[$invoiceKey]['firm_name'] = $firmName;
            $invoices[$invoiceKey]['firm_name_short'] = $firmNameShort;
            $invoices[$invoiceKey]['contract_number'] = $invoice->contract->number ?? null;
            $invoices[$invoiceKey]['amount_pay'] = 0;
            $invoices[$invoiceKey]['number_services'] = count($invoice->services);

            //  добавление даты протокола
            if (isset($invoice->act)) {
                $invoices[$invoiceKey]['act_number'] = $invoice->act->number;
                $invoices[$invoiceKey]['act_date'] = $invoice->act->date;
                $invoices[$invoiceKey]['protocol_date'] = $invoice->act->protocol_date;
            } else {
                $invoices[$invoiceKey]['act_number'] = null;
                $invoices[$invoiceKey]['act_date'] = null;
                $invoices[$invoiceKey]['protocol_date'] = null;
            }

            if (isset($invoice->payments)) {
                foreach ($invoice->payments as $payment) {
                    $invoices[$invoiceKey]['amount_pay'] += $payment['amount'];
                }
                $invoices[$invoiceKey]['amount_pay'] = number_format($invoices[$invoiceKey]['amount_pay'], 2, '.', '');
                $invoices[$invoiceKey]['balance'] = number_format($invoices[$invoiceKey]['amount'] - $invoices[$invoiceKey]['amount_pay'], 2, '.', '');
            }
        }

        return $invoices;
    }

    public function all(): Collection
    {
        $invoices = $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->with('firm')
            ->get();

        foreach ($invoices as $invoiceKey => $invoice) {
            $invoices[$invoiceKey]['firm_name_short'] = $invoice['firm']['firm_name_short'];
            $invoices[$invoiceKey]['edrpou'] = $invoice['firm']['edrpou'];
            $invoices[$invoiceKey]['isStatutFile'] = null;
            $invoices[$invoiceKey]['isVypyskaFile'] = null;
            $invoices[$invoiceKey]['isVytyahFile'] = null;
            $invoices[$invoiceKey]['isNdsFile'] = null;
            $invoices[$invoiceKey]['isNakazFile'] = null;
            $invoices[$invoiceKey]['isProtocolFile'] = null;

            foreach ($invoice->firm->files as $file) {
                if ($file['title'] == 'statut') {
                    $invoices[$invoiceKey]['isStatutFile'] = true;
                }

                if ($file['title'] == 'vypyska') {
                    $invoices[$invoiceKey]['isVypyskaFile'] = true;
                }

                if ($file['title'] == 'vytyah') {
                    $invoices[$invoiceKey]['isVytyahFile'] = true;
                }

                if ($file['title'] == 'nds') {
                    $invoices[$invoiceKey]['isNdsFile'] = true;
                }

                if ($file['title'] == 'nakaz') {
                    $invoices[$invoiceKey]['isNakazFile'] = true;
                }

                if ($file['title'] == 'protocol') {
                    $invoices[$invoiceKey]['isProtocolFile'] = true;
                }
            }

            //  добавление даты протокола
            if (isset($invoice->act)) {
                $invoices[$invoiceKey]['act_number'] = $invoice->act->number;
                $invoices[$invoiceKey]['act_date'] = $invoice->act->date;
                $invoices[$invoiceKey]['protocol_date'] = $invoice->act->protocol_date;
            } else {
                $invoices[$invoiceKey]['act_number'] = null;
                $invoices[$invoiceKey]['act_date'] = null;
                $invoices[$invoiceKey]['protocol_date'] = null;
            }
            unset($invoice['firm'], $invoice['act']);

            //  расчет суммы оплаты по каждому счету
            $invoices[$invoiceKey]['amount_pay'] = 0;

            if (isset($invoice->payments)) {
                foreach ($invoice->payments as $payment) {
                    $invoices[$invoiceKey]['amount_pay'] += $payment['amount'];
                }
                $invoices[$invoiceKey]['amount_pay'] = number_format($invoices[$invoiceKey]['amount_pay'], 2, '.', '');
            }

            $invoices[$invoiceKey]['balance'] = number_format($invoices[$invoiceKey]['amount'] - $invoices[$invoiceKey]['amount_pay'], 2, '.', '');

            $invoices[$invoiceKey]['payment_type_text'] = ($invoices[$invoiceKey]['payment_type'] == 'all') ? '100% попередня оплата' : 'часткова попередня оплата';
        }

        return $invoices;
    }

    public function findByIdWithServices(string $id)
    {
        $invoicesWithServices = $this->model->with('services')->find($id)->toArray();

        foreach ($invoicesWithServices['services'] as $serviceKey => &$service) {
            $invoicesWithServices['services'][$serviceKey]['pivot']['parent_id'] = $service['parent_id'];
            $service = $service['pivot'];
        }
        return $invoicesWithServices;
    }

    public function findByContractId(string $contractId)
    {
        return $this->model
            ->where('contract_id', $contractId)
            ->get();
    }
}
