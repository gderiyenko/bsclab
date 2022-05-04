<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{
    use UsesUuid;
    use HasFactory;
    use SoftDeletes;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'firms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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

    public function files()
    {
        return $this->hasMany(File::class, "firm_id", "id");
    }

    public function payments()
    {
        return $this->BelongsTo(Payment::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
