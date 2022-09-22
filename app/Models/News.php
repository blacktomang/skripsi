<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Normalizer\SlugNormalizer;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['photo', 'title','slug', 'description', 'date'];
    const  FILE_PATH = 'news';
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = (new SlugNormalizer())->normalize($value);
    }
}
