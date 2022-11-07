<?php

namespace App\Exports;

use App\Models\Mausoleos;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Support\Str;

class MausoleosExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

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
            'UBICACIÓN',
            'NIVEL',
            'NUMERO',
            'NOMBRES',
            'APELLIDO PATERNO',
            'APELLIDO MATERNO',
            'FECHA DE DECESO',
            'OBSERVACIONES',
        ];
    }
    public function query()
    {
         return Mausoleos::query()->select('ubicacion','nivel','numero','nombres','ap_paterno','ap_materno','fecha_deceso','obs');
    }
}