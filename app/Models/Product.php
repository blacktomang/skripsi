<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use League\CommonMark\Normalizer\SlugNormalizer;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'added_by', 'description', 'slug', 'price', 'stock', 'status'];
    const FILE_PATH = 'products';
    
    public function photos(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = (new SlugNormalizer())->normalize($value);
    }
}
