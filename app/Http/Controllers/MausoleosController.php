<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Registros;
use Carbon\Carbon;
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
        $niveles = DB::table('c_niveles')->where('codigo', 'like', 'G')->get();
        $ubicacion = DB::table('c_ubicaciones')->where('codigo', 'like', 'M-%')->select('id', 'codigo', 'descripcion')->orderBy('codigo', 'asc')->get();
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
                            <a href="/cementerio-app/cementerio/registros/' . $row->id . '/edit/mausoleos" class="btn btn-info btn-sm"><i
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

    public function create()
    {
        $niveles = DB::table('c_niveles')->where('codigo', 'like', 'G')->get();
        $ubicacion = DB::table('c_ubicaciones')->where('codigo', 'like', 'M-%')->select('id', 'codigo', 'descripcion')->orderBy('descripcion', 'asc')->get();
        $observaciones = DB::table('c_observaciones')->get();
        $adicionales = DB::table('c_adicionales')->get();
        return view('mausoleos.crear', compact('observaciones', 'niveles', 'ubicacion', 'adicionales'));
    }

    public function store(Request $request)
    {
        $codigo = random_bytes(5);
        $codcasteado = bin2hex($codigo);

        $msn = "Registro Guardado Correctamente!";

        $this->validate($request, [
            'nivel' => 'required',
            'ubicacion' => 'required',
            'numero' => 'required',
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'imagen' => 'image:jpeg,jpg,png|max:3072',
        ]);

        $registro = new Registros();
        $registro->codigounico = $codcasteado;
        $registro->id_tipo_reg = $request->tiporegistro;
        $registro->id_nivel = $request->nivel;
        $registro->id_ubicacion = $request->ubicacion;
        $registro->numero = $request->numero;
        $registro->nombres = $request->nombres;
        $registro->paterno = $request->paterno;
        $registro->materno = $request->materno;
        $registro->imagen = $request->imagen;
        $registro->fecha_deceso = $request->fecha_deceso;
        $registro->ip_usuario = request()->ip();
        $registro->nombre_usuario = Auth::user()->name;
        $registro->usuario_modificador = null;
        $registro->deleted_at = null;

        if ($image = $request->file('imagen')) {
            $rutaGaurdada = 'imagen/';
            $imgRegis = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($rutaGaurdada, $imgRegis);
            $registro['imagen'] = "$imgRegis";
        } else {
            $registro->imagen = 'default.png';
        }

        $registro->save();

        $observ = $request->observaciones;
        $adicio = $request->adicionales;

        $obtnerid = DB::table('registros')->where('codigounico', '=', $codcasteado)->get();
        $regsave = Registros::where('id', $obtnerid[0]->id)->get();

        if ($observ != null) {
            for ($i = 0; $i < sizeof($observ); $i++) {
                DB::insert('insert into observaciones_registros (registros_id,observaciones_id) values (?,?)', [$regsave[0]->id, $observ[$i]]);
            }
        }
        if ($adicio != null) {
            for ($i = 0; $i < sizeof($adicio); $i++) {
                DB::insert('insert into adicionales_registros (registros_id,adicionales_id) values (?,?)', [$regsave[0]->id, $adicio[$i]]);
            }
        }

        return redirect()->route('mausoleos.index')->with('success', $msn);
    }

    public function detallemausoleos(Request $request)
    {
        $id = $request->id;
        $query = DB::select(DB::raw('select r.nombres ,r.paterno ,r.materno ,r.numero , r.fecha_deceso, r.imagen from registros r where id =' . $id));

        $queryobs = DB::select(DB::raw('select co.descripcion as "observacion" from registros r
        inner join observaciones_registros ro
        on r.id = ro.registros_id
        inner join c_observaciones co
        on ro.observaciones_id = co.id
        where r.id = ' . $id));

        $queryads = DB::select(DB::raw('select ca.descripcion as "adicional" from registros r
        inner join adicionales_registros ar
        on r.id = ar.registros_id
        inner join c_adicionales ca
        on ar.adicionales_id = ca.id
        where r.id = ' . $id));

        return response()->json(['detalle' => $query, 'obs' => $queryobs, 'ads' => $queryads]);
    }

    public function edit($id)
    {
        $registro = Registros::find($id);

        $niveles = DB::table('c_niveles')->get();

        $ubicacion = DB::table('c_ubicaciones')->where('codigo', 'like', 'M-%')->select('id', 'codigo', 'descripcion')->orderBy('descripcion', 'asc')->get();

        $obsreg = DB::table('observaciones_registros')->where('observaciones_registros.registros_id', $id)->pluck('observaciones_registros.observaciones_id', 'observaciones_registros.observaciones_id')->all();

        $observaciones = DB::table('c_observaciones')->get();

        $adsreg = DB::table('adicionales_registros')->where('adicionales_registros.registros_id', $id)->pluck('adicionales_registros.adicionales_id', 'adicionales_registros.adicionales_id')->all();

        $adicionales = DB::table('c_adicionales')->get();
        return view('mausoleos.editar', compact('adsreg', 'obsreg', 'observaciones', 'registro', 'niveles', 'ubicacion', 'adicionales'));
    }

    public function update(Request $request, $id)
    {

        $msn = "Registro Actualizado Correctamente!";
        $registro = Registros::find($id);

        $this->validate($request, [
            'nivel' => 'required',
            'ubicacion' => 'required',
            'numero' => 'required',
            'nombres' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'imagen' => 'image:jpeg,jpg,png|max:3072'
        ]);

        $registro->id_tipo_reg = $request->tiporegistro;
        $registro->id_nivel = $request->nivel;
        $registro->id_ubicacion = $request->ubicacion;
        $registro->numero = $request->numero;
        $registro->nombres = $request->nombres;
        $registro->paterno = $request->paterno;
        $registro->materno = $request->materno;
        $registro->imagen = $request->imagen;
        $registro->fecha_deceso = $request->fecha_deceso;
        $registro->ip_usuario = request()->ip();
        $registro->usuario_modificador = Auth::user()->name;
        $registro->deleted_at = null;

        if ($request->imagen != null) {
            if ($image = $request->file('imagen')) {
                $rutaGaurdada = 'imagen/';
                $imgRegis = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($rutaGaurdada, $imgRegis);
                $registro['imagen'] = "$imgRegis";
            }
        } else {
            $registro->imagen = 'default.png';
        }

        $observ = $request->observaciones;
        $adicio = $request->adicionales;

        $registro->observaciones()->sync($observ);
        $registro->adicionales()->sync($adicio);

        $registro->save();

        return redirect()->route('mausoleos.index')->with('success', $msn);
    }

    public function detalleeliminar(Request $request)
    {
        $id = $request->id;
        $query = DB::select(DB::raw('select r.id, r.nombres, r.paterno, r.materno from registros r where id =' . $id));
        return response()->json(['detalle' => $query]);
    }

    public function delete(Request $request)
    {
        $msn = "Registro Eliminado!";

        $registro = Registros::find($request->id);

        if (!is_null($registro)) {
            $registro->usuario_modificador = Auth::user()->name;
            $registro->deleted_at = Carbon::now()->toDateTimeString();
            $registro->ip_usuario = request()->ip();
            $registro->update();
            return back()->with('success', $msn);
        } else {
            $msn = 'No Se Elimino El Registro ¡Error!';
            return back()->with('error', $msn);
        }
    }
}
