<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arriendo;
use App\Models\Empresa;
use App\Models\Representante;
use App\Models\Local;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ArriendoController extends Controller
{

    public function index()
    {   
        $empresas = Empresa::where('estado_id', 1)->get();
        $representantes = Representante::where('estado_id', 1)->get();

        return view('pages.arriendo.index', compact('empresas', 'representantes'));
    }

    public function GenerarCodigoSku()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = Arriendo::select('sku')->where('sku', $number)->first();
        } while (!empty($codigo->sku));

        return $number;
    }

    public function create()
    {
        //
    }

    public function store(StoreArriendoRequest $request)
    {
        //
    }

    public function show($id)
    {   
        $arriendos = Arriendo::where('empresa_id',$id)->get();
        
        return response()->json($arriendos);
    }

    public function gestionArriendoOnly($id)
    {
        $arriendo = Arriendo::find($id);
        $arriendo->Load('Local');

        return response()->json($arriendo);
    }

    public function edit($id)
    {   
        $data = [];

        $arriendo = Arriendo::where('sku', $id)->first();
        $arriendo->load('Local');

        $locales = Local::where('estado_id', 3)->get();


        foreach ($arriendo->Local as $key => $value) {
            array_push($data, $value);
        }

        foreach ($locales as $key => $value) {
            array_push($data, $value);
        }
       
        return view('pages.arriendo.editar', compact('data', 'arriendo'));
    }

    public function update(Request $request, $id)
    {   
        $info = Arriendo::find($id);

        $pdf = null;
        if($request->contrato)
        {   
            if($info->url_contrato != null){
                Storage::disk('public')->delete($info->url_contrato);
            }
            $pdf = storage::disk('public')->putFile('/ArriendoContrato', new File($request->contrato));
            Arriendo::updateOrCreate(['id_arriendo' => $id],['url_contrato' => $pdf]);
        }

        $arriendo = Arriendo::updateOrCreate(['id_arriendo' => $id],[
                                                'valor_arriendo'    => $request->valor_arriendo,
                                                'fecha_inicio'      => $request->fecha_inicio,
                                                'fecha_termino'     =>  $request->fecha_termino,
        ]);

        foreach ($info->Local as $key => $value) {
            Local::updateOrCreate(['id_local' => $value->id_local],['estado_id' => 3]);
        }

        $arriendo->Local()->sync($request->locales);

        foreach ($request->locales as $key => $value) {
            Local::updateOrCreate(['id_local' => $value],['estado_id' => 4]);
        }

        return response()->json(['mensaje' => 'Arriendo actualizado exitosamente.', 'documento' => $pdf]);
    }

    public function destroy(Arriendo $arriendo)
    {
        //
    }
}
