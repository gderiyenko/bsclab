<?php

namespace App\Observers;

use App\Models\Firm;
use App\Services\Log\FirmLogService;
use Illuminate\Support\Facades\Auth;

class FirmObserver
{
    public function __construct(FirmLogService $firmLog)
    {
        $this->firmLog = $firmLog;
    }

    /**
     * Handle the Firm "created" event.
     *
     * @param \App\Models\Firm $firm
     *
     * @return void
     */
    public function created(Firm $firm)
    {
        $this->firmLog->create([
            'firm_id' => $firm->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'створення',
            'firm_name' => $firm->firm_name,
            'firm_name_short' => $firm->firm_name_short,
            'boss_position' => $firm->boss_position,
            'boss_pib' => $firm->boss_pib,
            'work_position' => $firm->work_position,
            'work_pib' => $firm->work_pib,
            'addr_zip_ur' => $firm->addr_zip_ur,
            'addr_obl_ur' => $firm->addr_obl_ur,
            'addr_city_ur' => $firm->addr_city_ur,
            'addr_street_ur' => $firm->addr_street_ur,
            'addr_house_ur' => $firm->addr_house_ur,
            'addr_office_ur' => $firm->addr_office_ur,
            'addr_zip_fact' => $firm->addr_zip_fact,
            'addr_obl_fact' => $firm->addr_obl_fact,
            'addr_city_fact' => $firm->addr_city_fact,
            'addr_street_fact' => $firm->addr_street_fact,
            'addr_house_fact' => $firm->addr_house_fact,
            'addr_office_fact' => $firm->addr_office_fact,
            'edrpou' => $firm->edrpou,
            'ipn' => $firm->ipn,
            'tax' => $firm->tax,
            'account_number' => $firm->account_number,
            'bank_name' => $firm->bank_name,
            'bank_mfo' => $firm->bank_mfo,
            'phone_shared' => $firm->phone_shared,
            'email_shared' => $firm->email_shared,
            'phone_acc' => $firm->phone_acc,
            'email_acc' => $firm->email_acc,
            'phone_work' => $firm->phone_work,
            'email_work' => $firm->email_work,
            'carr_name' => $firm->carr_name,
            'carr_city' => $firm->carr_city,
            'carr_dep' => $firm->carr_dep,
            'carr_pib' => $firm->carr_pib,
            'carr_phone' => $firm->carr_phone,
            'note' => $firm->note,
        ]);
    }

    /**
     * Handle the Firm "updated" event.
     *
     * @param \App\Models\Firm $firm
     *
     * @return void
     */
    public function updated(Firm $firm)
    {
        $this->firmLog->create([
            'firm_id' => $firm->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'оновлення',
            'firm_name' => $firm->firm_name,
            'firm_name_short' => $firm->firm_name_short,
            'boss_position' => $firm->boss_position,
            'boss_pib' => $firm->boss_pib,
            'work_position' => $firm->work_position,
            'work_pib' => $firm->work_pib,
            'addr_zip_ur' => $firm->addr_zip_ur,
            'addr_obl_ur' => $firm->addr_obl_ur,
            'addr_city_ur' => $firm->addr_city_ur,
            'addr_street_ur' => $firm->addr_street_ur,
            'addr_house_ur' => $firm->addr_house_ur,
            'addr_office_ur' => $firm->addr_office_ur,
            'addr_zip_fact' => $firm->addr_zip_fact,
            'addr_obl_fact' => $firm->addr_obl_fact,
            'addr_city_fact' => $firm->addr_city_fact,
            'addr_street_fact' => $firm->addr_street_fact,
            'addr_house_fact' => $firm->addr_house_fact,
            'addr_office_fact' => $firm->addr_office_fact,
            'edrpou' => $firm->edrpou,
            'ipn' => $firm->ipn,
            'tax' => $firm->tax,
            'account_number' => $firm->account_number,
            'bank_name' => $firm->bank_name,
            'bank_mfo' => $firm->bank_mfo,
            'phone_shared' => $firm->phone_shared,
            'email_shared' => $firm->email_shared,
            'phone_acc' => $firm->phone_acc,
            'email_acc' => $firm->email_acc,
            'phone_work' => $firm->phone_work,
            'email_work' => $firm->email_work,
            'carr_name' => $firm->carr_name,
            'carr_city' => $firm->carr_city,
            'carr_dep' => $firm->carr_dep,
            'carr_pib' => $firm->carr_pib,
            'carr_phone' => $firm->carr_phone,
            'note' => $firm->note,
        ]);
    }

    /**
     * Handle the Firm "deleted" event.
     *
     * @param \App\Models\Firm $firm
     *
     * @return void
     */
    public function deleted(Firm $firm)
    {
        $this->firmLog->create([
            'firm_id' => $firm->id,
            'user_name' => Auth::user()->name,
            'action_name' => 'видалення',
            'firm_name' => $firm->firm_name,
            'firm_name_short' => $firm->firm_name_short,
            'boss_position' => $firm->boss_position,
            'boss_pib' => $firm->boss_pib,
            'work_position' => $firm->work_position,
            'work_pib' => $firm->work_pib,
            'addr_zip_ur' => $firm->addr_zip_ur,
            'addr_obl_ur' => $firm->addr_obl_ur,
            'addr_city_ur' => $firm->addr_city_ur,
            'addr_street_ur' => $firm->addr_street_ur,
            'addr_house_ur' => $firm->addr_house_ur,
            'addr_office_ur' => $firm->addr_office_ur,
            'addr_zip_fact' => $firm->addr_zip_fact,
            'addr_obl_fact' => $firm->addr_obl_fact,
            'addr_city_fact' => $firm->addr_city_fact,
            'addr_street_fact' => $firm->addr_street_fact,
            'addr_house_fact' => $firm->addr_house_fact,
            'addr_office_fact' => $firm->addr_office_fact,
            'edrpou' => $firm->edrpou,
            'ipn' => $firm->ipn,
            'tax' => $firm->tax,
            'account_number' => $firm->account_number,
            'bank_name' => $firm->bank_name,
            'bank_mfo' => $firm->bank_mfo,
            'phone_shared' => $firm->phone_shared,
            'email_shared' => $firm->email_shared,
            'phone_acc' => $firm->phone_acc,
            'email_acc' => $firm->email_acc,
            'phone_work' => $firm->phone_work,
            'email_work' => $firm->email_work,
            'carr_name' => $firm->carr_name,
            'carr_city' => $firm->carr_city,
            'carr_dep' => $firm->carr_dep,
            'carr_pib' => $firm->carr_pib,
            'carr_phone' => $firm->carr_phone,
            'note' => $firm->note,
        ]);
    }

    /**
     * Handle the Firm "restored" event.
     *
     * @param \App\Models\Firm $firm
     *
     * @return void
     */
    public function restored(Firm $firm)
    {
    }

    /**
     * Handle the Firm "force deleted" event.
     *
     * @param \App\Models\Firm $firm
     *
     * @return void
     */
    public function forceDeleted(Firm $firm)
    {
    }
}
