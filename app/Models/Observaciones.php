<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Registros;

class Observaciones extends Model
{
    use HasFactory;
    protected $table = 'obs';
    protected $fillable = ['registros_id','observaciones_id'];
    public function registros()
    {
        return $this->belongsToMany('Registros','observaciones_registros');
    }
}
