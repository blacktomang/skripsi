<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'jabatan', 'deskripsi', 'foto'];
    const  FILE_PATH = 'testimonials';
}
