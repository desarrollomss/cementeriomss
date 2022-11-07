<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tumbas extends Model
{
    use HasFactory;
    protected $fillable=[
        'codigo',
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
