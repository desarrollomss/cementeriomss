<?php

namespace App\Http\Controllers;

use App\Exports\TumbasExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    public function index()
    {
        $observaciones = DB::table('c_observaciones')->get();
        return view('reportes', compact('observaciones'));
    }

    public function consultaobservaciones(Request $request)
    {
        $idobs = $request->observaciones;
        try {
            if(!is_null($idobs))
            {
                $query = DB::select(DB::raw('select cu.descripcion as "ubicacion", cn.descripcion as "nivel", r.numero ,r.nombres ,r.paterno ,r.materno ,
                r.fecha_deceso , co.descripcion as "observaciones" from registros r
                inner join observaciones_registros or2 on r.id = or2.registros_id
                inner join c_observaciones co on or2.observaciones_id = co.id
                inner join c_ubicaciones cu on cu.id = r.id_ubicacion
                inner join c_niveles cn on cn.id = r.id_nivel
                where co.id = '.$idobs));
                return back()->with('resp',$query);
            }

        } catch (\Throwable $th) {
            return back()->with('error', $th);
        }
    }

    public function exporttumbas()
    {
        return Excel::download(new TumbasExport(), 'tumbas.xls');
    }
}
