<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'acts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'date',
        'invoice_id',
        'firm_id',
        'protocol_date',
    ];

    public function invoice()
    {
        return $this->BelongsTo(Invoice::class);
    }

    public function firm()
    {
        return $this->BelongsTo(Firm::class);
    }
}
