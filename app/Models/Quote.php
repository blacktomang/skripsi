<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'added_by','position', 'sentence'];
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
