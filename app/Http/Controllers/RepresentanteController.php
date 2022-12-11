<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Representante;

class RepresentanteController extends Controller
{

    public function index()
    {   
        $representantes = Representante::where('estado_id', 1)->get();

        return view('pages.representante.index', compact('representantes'));
    }

    public function verificarRepresentante($rut)
    {
        $rep = Representante::where('rut', $rut)->first();

        if($rep){
            if($rep->estado_id == 2){
                return response()->json(['codigoEstado' => 1, 'Mensaje' => '¿Desea activar usuario?', 'datos' => $rep]);
            }else{
                return response()->json(['codigoEstado' => 0, 'Mensaje' => 'Usuario ya esta ingresado.']);
            }    
        }else{
            return response()->json(['codigoEstado' => 3]);
        }
    }

    public function create()
    {
        $rep = Representante::where('estado_id', 1)->get();

        return response()->json($rep);
    }

    public function store(Request $request)
    {
        Representante::create([ 'nombres' => $request->nombres, 'apellidos' => $request->apellidos,
                                'rut' => $request->rut, 'correo' => $request->correo,
                                'celular' => $request->celular, 'estado_id' => 1]);

        return response()->json(['mensaje' => 'Representante creado exitosamente.']);
    }

    public function show(Representante $representante)
    {
        //
    }

    public function edit($id)
    {
        $rep = Representante::find($id);
        
        return response()->json(['rep' => $rep]);
    }

    public function update(Request $request, $id)
    {
        Representante::updateOrCreate(['id_representante' => $id],[
                                                        'nombres'     =>    $request->nombres, 
                                                        'apellidos'   =>    $request->apellidos, 
                                                        'correo'      =>    $request->correo,
                                                        'rut'         =>    $request->rut,
                                                        'celular'     =>    $request->celular]);
        
        return response()->json(['mensaje' => 'Representante actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        
    }
}
