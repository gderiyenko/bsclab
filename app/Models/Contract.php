<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contracts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'date_contract',
        'firm_id',
        'date_end',
        'amount',
        'note',
        'category',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function invoices()
    {
        return $this->HasMany(Invoice::class);
    }
}
