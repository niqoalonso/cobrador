<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Local;

class AreaLocalController extends Controller
{   

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission:Gestion Locales & Areas']);
    }

    //FUNCTIONES AREA

    public function index()
    {   
        $areas = Area::where('estado_id',1)->get();
        $locales = Local::all();
        $locales->load('Estado');

        return view('pages.area_local.index', compact('areas', 'locales'));
    }

    public function getArea()
    {
        $areas = Area::where('estado_id', 1)->get();
        return response()->json($areas);
    }

    public function storeArea(Request $request)
    {   
        Area::create(['nombre' => $request->nombre, 'estado_id' => 1]);

        return response()->json(['mensaje' => 'Area agregada exitosamente.']);
    }

    public function editarArea($id)
    {
        $area = Area::find($id);

        return response()->json(['mensaje' => 'Edición activada.', 'area' => $area]);
    }

    public function updateArea(Request $request, $id)
    {   
        Area::updateOrCreate(['id_area' => $request->id],['nombre' => $request->nombre]);

        return response()->json(['mensaje' => 'Area actualizada exitosamente.']);
    }

    public function verificarUsoArea($id)
    {
        $area = Area::find($id);
      
            if(count($area->local) == 0)
            {
                return response()->json(['codigoEstado' => '0', 'mensaje' => '¿Esta seguro que desea eliminar esta Area?']);
            }else{
                return response()->json(['codigoEstado' => '1', 'mensaje' => 'Area esta en uso. Esta asignado a uno varios localea.']);
            }
    }

    public function eliminarArea($id)
    {
        Area::destroy($id);
        return response()->json(['mensaje' => 'Area eliminada exitosamente.']);
    }


    //FUNCIONES LOCALES



    public function getLocal()
    {
        $locales = Local::all();
        $locales->load('area', 'estado');
        return response()->json($locales);
    }

    public function getLocalDisponible()
    {
        $locales = Local::where('estado_id', 3)->get();
        return response()->json($locales);
    }

    public function storeLocal(Request $request)
    {
        Local::create(['identificador' => $request->identificador, 'direccion' => $request->direccion, 'area_id' => $request->area, 'estado_id' => 3]);

        return response()->json(['mensaje' => 'Local agregada exitosamente.']);
    }

    public function editarLocal($id)
    {
        $local = Local::find($id);
        $local->load('Area');

        $areas = Area::all();

        return response()->json(['mensaje' => 'Edición activada.', 'local' => $local, 'areas' => $areas]);
    }

    public function updateLocal(Request $request, $id)
    {
        Local::updateOrCreate(['id_local' => $request->id],['identificador' => $request->identificador, 'direccion' => $request->direccion, 'area_id' => $request->area]);

        return response()->json(['mensaje' => 'Local actualizado exitosamente.']);
    }

    public function verificarUsoLocal($id)
    {
        $local = Local::find($id);
      
            if(count($local->Arriendo) == 0)
            {
                return response()->json(['codigoEstado' => '0', 'mensaje' => '¿Esta seguro que desea eliminar este Local?']);
            }else{
                return response()->json(['codigoEstado' => '1', 'mensaje' => 'Local esta en uso. Esta asociado a uno arriendo.']);
            }

    }

    public function eliminarLocal($id)
    {
        Local::destroy($id);

        return response()->json(['mensaje' => 'Local eliminada exitosamente.']);
    }

}
