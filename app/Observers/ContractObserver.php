<?php

namespace App\Observers;

use App\Models\Contract;
use App\Services\Log\ContractLogService;
use Illuminate\Support\Facades\Auth;

class ContractObserver
{
    public function __construct(ContractLogService $contractLog)
    {
        $this->contractLog = $contractLog;
    }

    /**
     * Handle the Contract "created" event.
     *
     * @param \App\Models\Contract $contract
     *
     * @return void
     */
    public function created(Contract $contract)
    {
        $this->contractLog->create([
            'contract_id' => $contract->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'створення',
            'number' => $contract->number,
            'date_contract' => $contract->date_contract,
            'date_end' => $contract->date_end,
            'amount' => $contract->amount,
            'note' => $contract->note,
            'category' => $contract->category,
        ]);
    }

    /**
     * Handle the Contract "updated" event.
     *
     * @param \App\Models\Contract $contract
     *
     * @return void
     */
    public function updated(Contract $contract)
    {
        $this->contractLog->create([
            'contract_id' => $contract->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'оновлення',
            'number' => $contract->number,
            'date_contract' => $contract->date_contract,
            'date_end' => $contract->date_end,
            'amount' => $contract->amount,
            'note' => $contract->note,
            'category' => $contract->category,
        ]);
    }

    /**
     * Handle the Contract "deleted" event.
     *
     * @param \App\Models\Contract $contract
     *
     * @return void
     */
    public function deleted(Contract $contract)
    {
        $this->contractLog->create([
            'contract_id' => $contract->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'видалення',
            'number' => $contract->number,
            'date_contract' => $contract->date_contract,
            'date_end' => $contract->date_end,
            'amount' => $contract->amount,
            'note' => $contract->note,
            'category' => $contract->category,
        ]);
    }

    /**
     * Handle the Contract "restored" event.
     *
     * @param \App\Models\Contract $contract
     *
     * @return void
     */
    public function restored(Contract $contract)
    {
    }

    /**
     * Handle the Contract "force deleted" event.
     *
     * @param \App\Models\Contract $contract
     *
     * @return void
     */
    public function forceDeleted(Contract $contract)
    {
    }
}
