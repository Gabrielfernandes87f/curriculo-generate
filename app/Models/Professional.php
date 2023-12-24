<?php

namespace App\Models;

use App\Models\Certification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'certification_id',
        'company',
        'period',
        'function',
        'description',
        'technology',

    ];

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }
}
