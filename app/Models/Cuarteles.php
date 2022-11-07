<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuarteles extends Model
{
    use HasFactory;
    protected $fillable=[
        'ubicacion',
        'nivel',
        'numero',
        'nombres',
        'ap_paterno',
        'ap_materno',
        'fecha_deceso',
        'imagen',
        'obs'
    ];
}
