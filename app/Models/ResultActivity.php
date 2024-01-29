<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultActivity extends Model
{
    use HasFactory;
    public function result(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Result::class);
    }
    public function question(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
