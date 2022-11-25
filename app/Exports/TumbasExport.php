<?php

namespace App\Exports;

use App\Models\Tumbas;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use stdClass;

class TumbasExport implements FromCollection,WithHeadings
{
    use Exportable;

    private $busqueda;

    public function exportarBusqueda($busqueda)
    {
        $this->busqueda = $busqueda;
        return $this;
    }

    public function headings(): array
    {
        return [
            'CODIGO',
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
        $query = DB::table('registros')
        ->join('c_niveles as cn','cn.id','=','registros.id_nivel')
        ->join('c_ubicaciones as cu','cu.id','=','registros.id_ubicacion')
        ->where('cu.codigo','like','T-%')
        ->whereNull('registros.deleted_at')
        ->select('cu.codigo as codigo','cn.descripcion as nivel', 'cu.descripcion as ubicación', 'registros.numero' ,'registros.nombres' ,'registros.paterno' ,'registros.materno' ,'registros.fecha_deceso')
        ->orderBy('registros.id', 'asc')
        ->get();

        return collect($query);
    }
}
