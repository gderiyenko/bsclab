<?php

namespace App\Observers;

use App\Models\Act;
use App\Services\Log\ActLogService;
use Illuminate\Support\Facades\Auth;

class ActObserver
{
    public function __construct(ActLogService $actLog)
    {
        $this->actLog = $actLog;
    }

    /**
     * Handle the Act "created" event.
     *
     * @param \App\Models\Act $act
     *
     * @return void
     */
    public function created(Act $act)
    {
        $this->actLog->create([
            'act_id' => $act->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'створення',
            'act_number' => $act->number,
            'act_date' => $act->date,
            'invoice_number' => $act->invoice->number,
            'protocol_date' => $act->protocol_date,
        ]);
    }

    /**
     * Handle the Act "updated" event.
     *
     * @param \App\Models\Act $act
     *
     * @return void
     */
    public function updated(Act $act)
    {
        $this->actLog->create([
            'act_id' => $act->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'оновлення',
            'act_number' => $act->number,
            'act_date' => $act->date,
            'invoice_number' => $act->invoice->number,
            'protocol_date' => $act->protocol_date,
        ]);
    }

    /**
     * Handle the Act "deleted" event.
     *
     * @param \App\Models\Act $act
     *
     * @return void
     */
    public function deleted(Act $act)
    {
        $actLog = $this->actLog->getAllByActId($act->id)->last();

        $this->actLog->create([
            'act_id' => $act->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'видалення',
            'act_number' => $act->number,
            'act_date' => $act->date,
            'invoice_number' => $actLog->invoice_number,
            'protocol_date' => $act->protocol_date,
        ]);
    }

    /**
     * Handle the Act "restored" event.
     *
     * @param \App\Models\Act $act
     *
     * @return void
     */
    public function restored(Act $act)
    {
    }

    /**
     * Handle the Act "force deleted" event.
     *
     * @param \App\Models\Act $act
     *
     * @return void
     */
    public function forceDeleted(Act $act)
    {
    }
}
