<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MausoleosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-registers|crear-registers|editar-registers|borrar-registers', ['only' => ['index']]);
        $this->middleware('permission:crear-registers', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-registers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-registers', ['only' => ['destroy']]);
    }

    public function index()
    {
        $observaciones = DB::table('c_observaciones')->get();
        $niveles = DB::table('c_niveles')->get();
        $ubicacion = DB::table('c_ubicaciones')->where('codigo', 'like', 'T-%')->select('id', 'codigo', 'descripcion')->orderBy('codigo', 'asc')->get();
        $adicionales = DB::table('c_adicionales')->get();
        return view('mausoleos.index', compact('observaciones', 'niveles', 'ubicacion', 'adicionales'));
    }

    public function obtenermausoleos()
    {
        $query = DB::table('registros')
            ->join('c_tipo_registros as ctr', 'registros.id_tipo_reg', '=', 'ctr.id')
            ->join('c_niveles as cn', 'registros.id_nivel', '=', 'cn.id')
            ->join('c_ubicaciones as cu', 'registros.id_ubicacion', '=', 'cu.id')
            ->where('cu.codigo', 'like', 'M-%')
            ->whereNull('deleted_at')
            ->select('registros.id', 'cu.codigo', 'cu.descripcion as ubicacion', 'cn.descripcion as nivel', 'registros.numero', 'registros.nombres', 'registros.paterno', 'registros.materno', 'registros.fecha_deceso', 'registros.imagen')
            ->orderBy('registros.id', 'desc');

        return datatables()->of($query)
            ->addColumn('fecha_deceso', function ($row) {
                $fec_format = "";
                $fecha_deceso = "";
                if ($row->fecha_deceso == null) {
                    $fec_format = "SIN FECHA";
                } else {
                    $fecha_deceso = $row->fecha_deceso;
                    $fec_format = date('d-m-Y', strtotime($fecha_deceso));
                }
                return $fec_format;
            })
            ->addColumn('ver', function ($row) {
                if (auth()->user()->can('ver-registers')) {
                    return '<td>
                                <button type="button" class="btn btn-success btn-sm" data-id="' . $row->id . '" id="modalDeta"><em class="fas fa-eye"></em></button>
                            </td>';
                }
            })
            ->addColumn('editar', function ($row) {
                if (auth()->user()->can('editar-registers')) {
                    return '<td>
                            <a href="/cementerio/registros/' . $row->id . '/edit" class="btn btn-info btn-sm"><i
                                class="fas fa-user-edit"></i></a>
                            </td>';
                }
            })
            ->addColumn('borrar', function ($row) {
                if (auth()->user()->can('borrar-registers')) {
                    return '<td>
                                <button type="button" class="btn btn-danger btn-sm" data-id="' . $row->id . '" data-toggle="modal" data-target="#exampleModal" id="eliminar">
                                    <i class="fas fa-user-slash"></i>
                                </button>
                            </td>';
                }
            })
            ->rawColumns(['ver', 'editar', 'borrar', 'fecha_deceso'])
            ->make(true);
    }
}
