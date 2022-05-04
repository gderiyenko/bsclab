<?php

namespace App\Repositories;

use App\Models\Act;
use App\Models\Contract;
use App\Models\Firm;
use Illuminate\Support\Collection;

class ActRepository extends BaseRepository
{
    public $sortBy = 'date';
    public $sortOrder = 'desc';

    /**
     * Repo Constructor
     * Override to clarify typehinted model.
     *
     * @param Act $model Repo DB ORM Model
     */
    public function __construct(Act $model, Firm $firm, Contract $contract)
    {
        $this->model = $model;
        $this->firm = $firm;
        $this->contract = $contract;
    }

    public function getAllByFirmId(string $firmId): array
    {
        $actsWithInvoice = $this->model
            ->where('firm_id', $firmId)
            ->with('invoice')
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();

        $firm = $this->firm->find($firmId);
        foreach ($actsWithInvoice as $actKey => $act) {
            $actsWithInvoice[$actKey]['firm_name'] = $firm->firm_name;
            $actsWithInvoice[$actKey]['edrpou'] = $firm->edrpou;

            $actsWithInvoice[$actKey]['number_services'] = (isset($act->invoice)) ? count($act->invoice->services) : '';
            $actsWithInvoice[$actKey]['invoice_number'] = (isset($act->invoice)) ? $act->invoice->number : '';

            $contractId = $act['invoice']['contract_id'];
            $contract = $this->contract->find($contractId);

            $actsWithInvoice[$actKey]['contract_number'] = $contract['number'];
        }

        return $actsWithInvoice;
    }

    public function all(): Collection
    {
        $acts = $this->model
            ->orderBy($this->sortBy, $this->sortOrder)
            ->with('firm')
            ->get();

        foreach ($acts as $actKey => $act) {
            $acts[$actKey]['firm_name_short'] = $act['firm']['firm_name_short'];
            $acts[$actKey]['edrpou'] = $act['firm']['edrpou'];

            $acts[$actKey]['amount'] = (isset($act->invoice)) ? $act->invoice->amount : '';
            $acts[$actKey]['number_invoice'] = (isset($act->invoice)) ? $act->invoice->number : '';

            unset($act['firm'], $act['invoice']);
        }

        return $acts;
    }
}
