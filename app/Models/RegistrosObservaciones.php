<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrosObservaciones extends Model
{
    use HasFactory;
    protected $fillable = ['id_adicionales','id_registros'];
}
