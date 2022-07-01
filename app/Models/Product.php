<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'added_by' ,'position', 'sentence'];

    public function photos():HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    public function creator():BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
}
