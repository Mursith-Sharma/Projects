<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeSection extends Model
{
    protected $fillable = ['name', 'teacher_id'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}