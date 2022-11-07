<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuarteles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// use Yajra\DataTables\DataTables;

use App\Exports\CuartelesExport;

class CuartelesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-registers|crear-registers|editar-registers|borrar-registers', ['only'=>['index']]);
        $this->middleware('permission:crear-registers', ['only'=>['create','store']]);
        $this->middleware('permission:editar-registers', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-registers', ['only'=>['destroy']]);
    }

    public function index(Request $request)
    {
        $texto = Str::upper(trim($request->get('texto')));
        $cuarteles = Cuarteles::where('nombres','LIKE','%'.$texto.'%')
                        ->orWhere('ap_paterno','LIKE','%'.$texto.'%')
                        ->orWhere('ap_materno','LIKE','%'.$texto.'%')
                        ->orWhere('ubicacion','LIKE','%'.$texto.'%')
                        ->orWhere('numero','LIKE','%'.$texto.'%')
                        ->orWhere('nivel','LIKE','%'.$texto.'%')
                        ->orWhere('fecha_deceso','LIKE','%'.$texto.'%')
                        ->orderBy('id','asc')
                        ->paginate(10);
        return view('cuarteles.index',compact('cuarteles','texto'));

    }

    public function export(Request $request){
        $busqueda = Str::upper(trim($request->get('texto')));
        return (new CuartelesExport)->exportarBusqueda($busqueda)->download('cuarteles.xlsx');
    }


    public function create()
    {
        $observaciones = DB::table('observaciones')->get();
        $cuarteles_info = DB::table('cuarteles_info')->get();
        $niveles = DB::table('niveles_general')->get();
        return view('cuarteles.creacion',compact('cuarteles_info','observaciones','niveles'));
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'ubicacion'=>'required',
            'nivel'=>'required',
            'numero'=>'required',
            'nombres'=>'required',
            'ap_paterno'=>'required',
            'ap_materno'=>'required',
            'fecha_deceso'=>'required',
            'imagen'=>'image:jpeg,jpg,png|max:3072',
            'obs'=>'required'
        ]);

        $registro = $request->all();

        if($image = $request->file('imagen')){
            $rutaGaurdada = 'imagen/';
            $imgRegis = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($rutaGaurdada,$imgRegis);
            $registro['imagen'] = "$imgRegis";
        }
        Cuarteles::create($registro);
        return redirect()->route('cuarteles.index');
    }

    public function show($id)
    {
        $cuartel=Cuarteles::find($id);
        return view('cuarteles.deta',compact('cuartel'));
    }

    public function edit(Cuarteles $cuartele)
    {
        $observaciones = DB::table('observaciones')->get();
        $cuarteles_info = DB::table('cuarteles_info')->get();
        $niveles = DB::table('niveles_general')->get();
        return view('cuarteles.editar',compact('cuartele','cuarteles_info','observaciones','niveles'));
    }

    public function update(Request $request, Cuarteles $cuartele)
    {
        $this->validate($request,[
            'ubicacion'=>'required',
            'nivel'=>'required',
            'numero'=>'required',
            'nombres'=>'required',
            'ap_paterno'=>'required',
            'fecha_deceso'=>'required',
            'obs'=>'required'
        ]);
        $reg = $request->all();

        if($imagen = $request->file('imagen')){
            $rutaGuardar = 'imagen/';
            $imgRegistro = date('YmdHis').".".$imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardar, $imgRegistro);
            $reg['imagen'] = "$imgRegistro";
        }else{
            unset($reg['imagen']);
        }
        
        $cuartele->update($reg);
        return redirect()->route('cuarteles.index');
    }

    public function destroy($id)
    {
        Cuarteles::find($id)->delete();
        return redirect()->route('cuarteles.index');
    }
}
