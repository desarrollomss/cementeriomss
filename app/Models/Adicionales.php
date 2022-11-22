<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adicionales extends Model
{
    use HasFactory;
    protected $table = 'ads';
    protected $fillable = ['registros_id','adicionales_id'];
    public function registros()
    {
        return $this->belongsToMany('Registros','adicionales_registros');
    }
}
