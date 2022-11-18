<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{
    use HasFactory;
    protected $fillable = ['id_tipo_reg','id_nivel','id_ubicacion','numero','nombres','paterno','materno','fecha_deceso','imagen','ip_usuario','nombre_usuario','usuario_modificador'];

    public function observaciones()
    {
        return $this->belongsToMany('App\Models\Observaciones');
    }
}
