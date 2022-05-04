<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firm_id',
        'amount',
        'date',
        'description',
        'invoice_id',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
