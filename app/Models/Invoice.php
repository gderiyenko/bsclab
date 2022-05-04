<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firm_id',
        'number',
        'date',
        'contract_id',
        'amount',
        'amount_text',
        'pdv',
        'pdv_text',
        'pdv_minus',
        'pdv_minus_text',
        'payment_type',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'invoice_services')->withPivot('service_quantity', 'service_price', 'id');
    }

    public function invoiceServices()
    {
        return $this->hasMany(InvoiceServices::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function act()
    {
        return $this->hasOne(Act::class);
    }

    public function payments()
    {
        return $this->HasMany(Payment::class);
    }
}
