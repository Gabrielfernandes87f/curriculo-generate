<?php

namespace App\Models;

use App\Models\User;
use App\Models\Professional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'email',
        'location',
        'website',
        'projects_link',
        'project',
        'linkedin',
        'about',
        'education',
        'course',
        'course_link',
        'expertise',
        'languages',
        'experience',
        'Skills',
    ];

    public function professional(): HasMany
    {
        return $this->hasMany(Professional::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
