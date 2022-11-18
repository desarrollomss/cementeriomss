<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion'];
    public function registros()
    {
        return $this->belongsToMany('App\Models\Registros');
    }
}
