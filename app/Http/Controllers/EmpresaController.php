<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Arriendo;
use App\Models\Representante;
use App\Models\Local;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{

    public function index()
    {   
        $representantes = Representante::where('estado_id', 1)->get();
        $locales        = Local::where('estado_id', 3)->get();

        return view('pages.empresa_cliente.index', compact('representantes', 'locales'));
    }
    public function getLocalDisponible()
    {
        $locales = Local::where('estado_id', 3)->get();

        return response()->json(['locales' => $locales]);
    }

    public function getListCliente()
    {   
        $empresas = Empresa::all();

        return view('pages.empresa_cliente.list', compact('empresas'));
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

    public function GenerarCodigoSku()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = Empresa::select('sku')->where('sku', $number)->first();
        } while (!empty($codigo->sku));

        return $number;
    }

    public function GenerarCodigoSkuArriendo()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = Arriendo::select('sku')->where('sku', $number)->first();
        } while (!empty($codigo->sku));

        return $number;
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
                    'sku'                   =>  $this->GenerarCodigoSku(),
                    'rut'                   =>  $request->rut,
                    'razon_social'          =>  $request->razon_social,
                    'nombre_fantasia'       =>  $request->fantasia,
                    'correo'                =>  $request->correo,
                    'telefono'              =>  $request->telefono,
                    'celular'               =>  $request->celular,
                    'solicita_fac_email'    =>  ($request->factura) ? 1 : 0,
                    'alias'                 =>  $request->alias, 
                    'url_perfil'            =>  ($img == null) ? null : '/cliente/UrlPerfil/'.$name,
                    'representante_id'      =>  $request->representante,
                ]);
 
        $pdf = null;
        if($request->contrato)
        {   
            $pdf = storage::disk('public')->putFile('/ArriendoContrato', new File($request->contrato));
        }

        $arriendo = Arriendo::create([
                'sku'               => $this->GenerarCodigoSkuArriendo(),
                'url_contrato'      => $pdf,
                'valor_arriendo'    => $request->valor_arriendo,
                'fecha_inicio'      => $request->fecha_inicio,
                'fecha_termino'     => $request->fecha_termino,
                'estado_id'         => ($actual <= $request->fecha_inicio) ? 5: 6, 
                'empresa_id'        => $dato->id_empresa,
        ]);

        $arriendo->Local()->sync($request->locales);

        foreach ($request->locales as $key => $value) {
            Local::updateOrCreate(['id_local' => $value],['estado_id' => 4]);
        }

        $locales = Local::where('estado_id', 3)->get();

        return response()->json(['mensaje' => 'Cliente y Arriendo ingresado exitosamente.', 'locales' => $locales]);
    }

    public function show($id)
    {
        $data = Empresa::find($id);
        return response()->json($data);
    }

    public function edit($id)
    {   
        $empresa = Empresa::where('sku', $id)->first();
        $representantes = Representante::where('estado_id', 1)->get();

        return view('pages.empresa_cliente.editarEmpresa', compact('empresa', 'representantes'));
    }

    public function update(Request $request, $id)
    {   
        $data = Empresa::find($id);

        $img = null;
        $imgName = null;

        if($request->img){
            if($data->url_perfil != null)
            {
               Storage::disk('public')->delete($data->url_perfil);
            }            
            $par = str_replace("\0", "", $request->img);
            $image_parts = explode(";base64,", $par);
            $image_base64 = base64_decode($image_parts[1]);

            $name = $this->GenerarCodigo();
            $img =  Storage::put('/public/cliente/UrlPerfil/'.$name, $image_base64);
            Empresa::updateOrCreate(['id_empresa' => $data->id_empresa],['url_perfil' => '/cliente/UrlPerfil/'.$name]);
            $imgName = '/cliente/UrlPerfil/'.$name;
        }

        if($img != null)
        {
            Empresa::updateOrCreate(['id_empresa' => $request->id],[
                'url_perfil'            =>  '/cliente/UrlPerfil/'.$name,
            ]);
        }

        Empresa::updateOrCreate(['id_empresa' => $request->id],[
            'razon_social'          =>  $request->razon_social,
            'nombre_fantasia'       =>  $request->fantasia,
            'correo'                =>  $request->correo,
            'telefono'              =>  $request->telefono,
            'celular'               =>  $request->celular,
            'solicita_fac_email'    =>  ($request->factura) ? 1 : 0,
            'alias'                 =>  $request->alias, 
            'representante_id'      =>  $request->representante,
        ]);

        return response()->json(['mensaje' => 'Cliente actualizado exitosamente.', 'empresa' => $imgName]);
    }

    public function destroy(Empresa $empresa)
    {
        //
    }
}
