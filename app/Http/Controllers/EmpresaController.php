<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Arriendo;
use App\Models\Representante;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{

    public function index()
    {   
        $representantes = Representante::where('estado_id', 1)->get();

        return view('pages.empresa_cliente.index', compact('representantes'));
    }

    public function verificarEmpresa($rut)
    {
        $empresa = Empresa::where('rut', $rut)->first();

        if($empresa){
            if($empresa->estado_id == 2){
                return response()->json(['codigoEstado' => 1, 'Mensaje' => '¿Desea activar cliente?', 'datos' => $user]);
            }else{
                return response()->json(['codigoEstado' => 0, 'Mensaje' => 'Cliente ya esta ingresado.']);
            }    
        }else{
            return response()->json(['codigoEstado' => 3]);
        }
    }

    public function GenerarCodigo()
    {
        do {            
            $number = rand().'.jpg';
            $codigo = Empresa::select('url_perfil')->where('url_perfil', $number)->first();
        } while (!empty($codigo->url_perfil));

        return $number;
    }

    public function store(Request $request)
    {   
        return response()->json([]);
        $fecha = getdate();
        $actual = $fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];

        $img = null;
        if($request->img){
            Storage::disk('public')->delete($request->img);
            $par = str_replace("\0", "", $request->img);
            $image_parts = explode(";base64,", $par);
            $image_base64 = base64_decode($image_parts[1]);

            $name = $this->GenerarCodigo();
            $img =  Storage::put('/public/cliente/UrlPerfil/'.$name, $image_base64);
        }
        
       $dato =  Empresa::create([
                    'rut' => $request->rut,
                    'razon_social'          => $request->razon_social,
                    'nombre_fantasia'       => $request->fantasia,
                    'correo'                => $request->correo,
                    'telefono'              => $request->telefono,
                    'celular'               => $request->celular,
                    'solicita_fac_email'    => $request->facturacion,
                    'alias'                 => $request->alias, 
                    'url_perfil'            => ($img == null) ? null : '/producto/UrlPerfil/'.$name
                ]);

        $pdf = null;
        if($request->contrato)
        {   
            $pdf = storage::disk('public')->putFile('/ArriendoContrato', new File($request->contrato));
        }

        Arriendo::create([
                'url_contrato'      => $pdf,
                'valor_arriendo'    => $request->valor_arriendo,
                'fecha_inicio'      => $request->fecha_inicio,
                'fecha_termino'     => $request->fecha_termino,
                'estado_id'         => ($actual <= $request->fecha_inicio) ? 5: 6, 
                'empresa_id'        => $dato->id_empresa,
        ]);

        return response()->json(['mensaje' => 'Cliente y Arriendo ingresado exitosamente.']);
    }

    public function show(Empresa $empresa)
    {
        //
    }

    public function edit(Empresa $empresa)
    {
        //
    }

    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        //
    }

    public function destroy(Empresa $empresa)
    {
        //
    }
}
