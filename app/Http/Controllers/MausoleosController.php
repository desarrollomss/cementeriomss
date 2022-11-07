<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mausoleos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Exports\MausoleosExport;

class MausoleosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-registers|crear-registers|editar-registers|borrar-registers', ['only'=>['index']]);
        $this->middleware('permission:crear-registers', ['only'=>['create','store']]);
        $this->middleware('permission:editar-registers', ['only'=>['edit','update']]);
        $this->middleware('permission:borrar-registers', ['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto = Str::upper(trim($request->get('texto')));
        $mausoleos = Mausoleos::where('nombres','LIKE','%'.$texto.'%')
                        ->orWhere('ap_paterno','LIKE','%'.$texto.'%')
                        ->orWhere('ap_materno','LIKE','%'.$texto.'%')
                        ->orWhere('ubicacion','LIKE','%'.$texto.'%')
                        ->orWhere('numero','LIKE','%'.$texto.'%')
                        ->orWhere('nivel','LIKE','%'.$texto.'%')
                        ->orWhere('fecha_deceso','LIKE','%'.$texto.'%')
                        ->orderBy('id','asc')
                        ->paginate(10);
        return view('mausoleos.index',compact('mausoleos','texto'));
    }

    public function export(Request $request){
        $busqueda = Str::upper(trim($request->get('texto')));
        return (new MausoleosExport)->exportarBusqueda($busqueda)->download('mausoleos.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $observaciones = DB::table('observaciones')->get();        
        $mausoleos_info = DB::table('mausoleos_info')->get();
        $niveles = DB::table('niveles_general')->get();
        return view('mausoleos.crear',compact('mausoleos_info','observaciones','niveles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        Mausoleos::create($registro);
        return redirect()->route('mausoleos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mausoleo=Mausoleos::find($id);
        return view('mausoleos.deta',compact('mausoleo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Mausoleos $mausoleo)
    {
        $observaciones = DB::table('observaciones')->get();        
        $mausoleos_info = DB::table('mausoleos_info')->get();
        $niveles = DB::table('niveles_general')->get();
        return view('mausoleos.editar',compact('mausoleo','mausoleos_info','observaciones','niveles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mausoleos $mausoleo)
    {
        $this->validate($request,[
            'ubicacion'=>'required',
            'nivel'=>'required',
            'numero'=>'required',
            'nombres'=>'required',
            'ap_paterno'=>'required',
            'fecha_deceso'=>'required',
            'imagen'=>'image:jpeg,jpg,png|max:3072',
            'obs'=>'required'
        ]);
        $reg = $request->all();
        
        if($image = $request->file('imagen')){
            $rutaGaurdada = 'imagen/';
            $imgRegis = date('YmdHis').".".$image->getClientOriginalExtension();
            $image->move($rutaGaurdada,$imgRegis);
            $reg['imagen'] = "$imgRegis";
        }else{
            unset($reg['imagen']);
        }
        $mausoleo->update($reg);
        return redirect()->route('mausoleos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mausoleos::find($id)->delete();
        return redirect()->route('mausoleos.index');
    }
}
