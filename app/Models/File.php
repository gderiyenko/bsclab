<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use UsesUuid;
    use HasFactory;

    public $timestamp = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    protected $fillable = [
        'firm_id',
        'title',
        'meta_path',
        'url',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }
}
