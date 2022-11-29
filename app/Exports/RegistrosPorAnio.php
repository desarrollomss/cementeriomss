<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegistrosPorAnio implements FromCollection,WithHeadings
{
    use Exportable;

    public $aniodeceso;

    public function __construct($aniodeceso)
    {
        $this->aniodeceso = $aniodeceso;
    }

    public function headings(): array
    {
        return [
            'NIVEL',
            'UBICACIÓN',
            'NUMERO',
            'NOMBRES',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'FECHA DE DECESO'
        ];
    }
    public function collection()
    {
        $anio = $this->aniodeceso;
        $query = DB::table('registros')
        ->join('c_niveles','c_niveles.id','=','registros.id_nivel')
        ->join('c_ubicaciones','c_ubicaciones.id','=','registros.id_ubicacion')
        ->whereYear('fecha_deceso',$anio)
        ->whereNull('deleted_at')
        ->select('c_niveles.descripcion as nivel', 'c_ubicaciones.descripcion as ubicacion','registros.numero','registros.nombres','registros.paterno','registros.materno','registros.fecha_deceso')
        ->get();

        return collect($query);
    }
}
