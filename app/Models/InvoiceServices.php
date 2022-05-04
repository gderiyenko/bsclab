<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceServices extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_services';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'service_id',
        'service_quantity',
        'service_price',
        'amount',
        'amount_text',
    ];

    public function service()
    {
        return $this->BelongsTo(Service::class);
    }
}
