<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Registros;
use App\Models\RegistrosObservaciones;

class TumbasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-registers|crear-registers|editar-registers|borrar-registers', ['only'=>['index']]);
        $this->middleware('permission:crear-registers', ['only'=>['create','store']]);
        $this->middleware('permission:editar-registers', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-registers', ['only'=>['destroy']]);
    }

    public function index()
    {
        $observaciones = DB::table('c_observaciones')->get();
        $niveles = DB::table('c_niveles')->get();
        $ubicacion = DB::table('c_ubicaciones')->where('codigo','like','T-%')->select('id','codigo','descripcion')->orderBy('codigo','asc')->get();
        $adicionales = DB::table('c_adicionales')->get();
        return view('tumbas.index',compact('observaciones','niveles','ubicacion','adicionales'));
    }

    public function obtenertumbas()
    {
        $query = DB::table('registros')
        ->join('c_tipo_registros as ctr', 'registros.id_tipo_reg', '=', 'ctr.id')
        ->join('c_niveles as cn', 'registros.id_nivel', '=', 'cn.id')
        ->join('c_ubicaciones as cu', 'registros.id_ubicacion', '=', 'cu.id')
        ->join('registros_observaciones as ro', 'registros.id', '=', 'ro.id')
        ->join('c_observaciones as co', 'ro.id_observaciones', '=', 'co.id')
        ->where('cu.codigo', 'like', 'T-%')
        ->select('registros.id','cu.codigo','cu.descripcion as ubicacion','cn.descripcion as nivel','registros.numero','registros.nombres','registros.paterno','registros.materno','registros.fecha_deceso','registros.imagen','co.descripcion as observaciones')
        ->orderBy('registros.id', 'DESC');

        return datatables()->of($query)
        ->addColumn('fecha_deceso', function($row)
        {
            $fec_format = "";
            $fecha_deceso = "";
            if($row->fecha_deceso == null)
            {
                $fec_format = "SIN FECHA";
            }else{
                $fecha_deceso = $row->fecha_deceso;
                $fec_format = date('d-m-Y', strtotime($fecha_deceso));
            }
            return $fec_format;
        })
        ->addColumn('ver',function ($row){
            if (auth()->user()->can('ver-registers'))
            {
                return '<td>
                            <button type="button" class="btn btn-success btn-sm" data-id="'.$row->id.'" id="modalTumbasDeta"><em class="fas fa-eye"></em></button>
                        </td>';
            }
        })
        ->addColumn('editar',function ($row){
            if (auth()->user()->can('editar-registers'))
            {
                return '<td>
                            <a href="registro/'.$row->id.'/editar" class="btn btn-info btn-sm"><i
                            class="fas fa-user-edit"></i></a>
                        </td>';
            }
        })
        ->addColumn('borrar',function ($row){
            if (auth()->user()->can('borrar-registers'))
            {
                return '<td>
                            <button type="button" class="btn btn-danger btn-sm" data-id="'.$row->id.'" id="frmDelete"><i
                            class="fas fa-user-slash"></i></a>
                        </td>';
            }
        })
        ->rawColumns(['ver','editar','borrar','fecha_deceso'])
        ->make(true);
    }

    public function create()
    {
        $observaciones = DB::table('c_observaciones')->get();
        $niveles = DB::table('c_niveles')->get();
        $ubicacion = DB::table('c_ubicaciones')->where('codigo','like','T-%')->select('id','codigo','descripcion')->orderBy('codigo','asc')->get();
        $adicionales = DB::table('c_adicionales')->get();
        return view('tumbas.crear',compact('observaciones','niveles','ubicacion','adicionales'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'codigo'=>'required',
            'nivel'=>'required',
            'numero'=>'required',
            'nombres'=>'required',
            'ap_paterno'=>'required',
            'ap_materno'=>'required',
            'imagen'=>'image:jpeg,jpg,png|max:3072',
            'observaciones'=>'required',
            'adicionales'=>'required'
        ]);

        $registro = $request->all();

        if($image = $request->file('imagen')){
            $rutaGaurdada = 'imagen/';
            $imgRegis = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($rutaGaurdada,$imgRegis);
            $registro['imagen'] = "$imgRegis";
        }
        //  Registros::create($registro);

        dd($registro);


        return redirect()->route('mausoleos.index');
    }

    public function detalletumbas(Request $request)
    {
        $id = $request->id;
        $query = DB::select(DB::raw('select r.nombres ,r.paterno ,r.materno ,r.numero , r.fecha_deceso, co.descripcion as "observacion", r.imagen
        from registros r
        inner join registros_observaciones ro
        on r.id = ro.id_registros
        inner join c_observaciones co
        on ro.id_observaciones = co.id
        where r.id ='.$id));
        return response()->json(['detalle'=>$query]);
    }
}
