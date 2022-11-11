<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuartelesController extends Controller
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
        return view('cuarteles.index');
    }

    public function obtenercuarteles()
    {
        $tblCuarteles = DB::table('Cuarteles')
        ->join('c_niveles', function ($join) {
            $join->on('Cuarteles.id_nivel', '=', 'c_niveles.id');
        })
        ->join('c_observaciones', function($join){
            $join->on('Cuarteles.id_observacion', '=', 'c_obserciones.id');
        });
        return datatables()->of($tblCuarteles)
        ->addColumn('ver',function ($row){
            if (auth()->user()->can('ver-registers'))
            {
                return '<td>
                            <button type="button" class="btn btn-success btn-sm" data-id="'.$row['id'].'" id="ver">ver</a>
                        </td>';
            }
        })
        ->addColumn('editar',function ($row){
            if (auth()->user()->can('editar-registers'))
            {
                return '<td>
                            <a href="registro/'.$row['id'].'/editar" class="btn btn-warning btn-sm">Editar</a>
                        </td>';
            }
        })
        ->addColumn('borrar',function ($row){
            if (auth()->user()->can('borrar-registers'))
            {
                return '<td>
                            <button type="button" class="btn btn-danger btn-sm" data-id="'.$row['id'].'" id="borrar">Borrar</a>
                        </td>';
            }
        })
        ->make(true);
    }
}
