<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'firm_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firm_id',
        'user_name',
        'action_name',
        'firm_name',
        'firm_name_short',
        'boss_position',
        'boss_pib',
        'work_position',
        'work_pib',
        'addr_zip_ur',
        'addr_obl_ur',
        'addr_city_ur',
        'addr_street_ur',
        'addr_house_ur',
        'addr_office_ur',
        'addr_zip_fact',
        'addr_obl_fact',
        'addr_city_fact',
        'addr_street_fact',
        'addr_house_fact',
        'addr_office_fact',
        'edrpou',
        'ipn',
        'tax',
        'account_number',
        'bank_name',
        'bank_mfo',
        'phone_shared',
        'email_shared',
        'phone_acc',
        'email_acc',
        'phone_work',
        'email_work',
        'carr_name',
        'carr_city',
        'carr_dep',
        'carr_pib',
        'carr_phone',
        'note',
    ];
}
