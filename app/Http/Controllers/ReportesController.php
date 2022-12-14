<?php

namespace App\Http\Controllers;

use App\Exports\RegistrosPorAnio;
use App\Exports\TumbasExport;
use App\Exports\TumbasConsultaExport;
use App\Exports\MausoleosExport;
use App\Exports\CuartelesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Notifications\Action;

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
                r.fecha_deceso , co.descripcion as "observaciones", ca.descripcion as "adicionales" from registros r
                inner join observaciones_registros or2 on r.id = or2.registros_id
                inner join c_observaciones co on or2.observaciones_id = co.id
                inner join c_ubicaciones cu on cu.id = r.id_ubicacion
                inner join c_niveles cn on cn.id = r.id_nivel
                inner join adicionales_registros ar
                on ar.registros_id = r.id
                inner join c_adicionales ca
                on ca.id = ar.adicionales_id
                where co.id = '.$idobs));
                return back()->with('resp',$query);
            }

        } catch (\Throwable $th) {
            return back()->with('error', $th);
        }
    }

    public function registrosexportar(Request $request)
    {
        $tipoRegistro = $request->tiporegistro;
        if($tipoRegistro == "1")
        {
            return Excel::download(new TumbasExport(), 'tumbas.xls');
        }
        elseif($tipoRegistro == "2")
        {
            return Excel::download(new MausoleosExport(), 'mausoleos.xls');
        }
        elseif($tipoRegistro == "3"){
            return Excel::download(new CuartelesExport(), 'cuarteles.xls');
        }
    }
    public function registrosexportarconsulta($id)
    {
        //cambiar la consulta de tipo general.
        return Excel::download(new TumbasConsultaExport($id), 'filtro_tumbas.xls');
    }

    public function registrosporanio(Request $request)
    {
        $anio = $request->anio;
        $registros = DB::table('registros')
        ->whereYear('fecha_deceso',$anio)
        ->count();

        // $anioactual = (int)date("Y");

        if($registros > 0)
        {
            // Excel::download(new RegistrosPorAnio($anio), 'filtro_a??os.xls');
            // $aniosdeceso = $anioactual - $anio;
            // $resp = 'Cantidad de Registros : '. $registros.' Tiempo de deceso : '. $aniosdeceso.' A??os';
            // return back()->with('rpta',$resp);
            return Excel::download(new RegistrosPorAnio($anio), 'filtro_a??os.xls');
        }else{
            $resp ="Sin Registros Para Esa Fecha";
            return back()->with('rpta',$resp);
        }
    }
}
