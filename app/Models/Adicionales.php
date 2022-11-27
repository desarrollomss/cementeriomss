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
        return $this->belongsToMany('App\Models\Registros','adicionales_registros');
    }
}
