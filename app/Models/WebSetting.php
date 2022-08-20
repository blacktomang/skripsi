<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        "hero_file",
        "hero_title",
        "hero_desc",
        "about",
    ];
    const FILE_PATH = 'websettings';
}
