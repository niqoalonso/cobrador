<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postura;
use App\Models\Empresa;
use App\Models\TipoPago;
use App\Models\EntidadFinanciera;
use App\Models\ItemPostura;
use App\Models\Arriendo;
use App\Models\ItemPosturaPostura;
use App\Models\DetallePostura;

class PosturaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {   
        $empresas = Empresa::all();
        $pagos = TipoPago::all();
        $entidades = EntidadFinanciera::all();
        $itemsPosturas = ItemPostura::all();

        return view('pages.postura.index', compact('empresas', 'pagos', 'entidades', 'itemsPosturas'));
    }

    public function getArriendos($sku)
    {
        $arriendos = Empresa::where('sku', $sku)->first();
        $arriendos->load('Arriendo');
        return response()->json($arriendos);
    }

    public function getItemPostura($id)
    {
        $data = ItemPostura::find($id);
        return response()->json($data);
    }

    public function GenerarCodigoSkuPostura()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = Postura::select('sku')->where('sku', $number)->first();
        } while (!empty($codigo->sku));

        return $number;
    }
    
    public function store(Request $request)
    {   
        $data = json_decode($request->detalle, true);

        $fecha = new \DateTime();

        $arriendo = Arriendo::where('sku', $request->sku)->first();

        $postura = Postura::create([
                        'sku'         => $this->GenerarCodigoSkuPostura(),
                        'arriendo_id' => $arriendo->id_arriendo, 
                        'fecha_emision' => $fecha->format('Y-m-d'),
                        'total' => array_sum(array_column($data, 'total')),
                        'estado_id' => 12,
                        'tipo_pago_id' => $request->tipo_pago]);

        foreach ($data as $key => $value) {
            DetallePostura::create([
                            'postura_id' => $postura->id_postura,
                            'item_postura_id' => $value['id'],
                            'cantidad' => $value['cantidad'],
                            'valor_unitario' => $value['monto'],
                            'total' => $value['cantidad']*$value['monto']]);
        }

        return response()->json("Postura agregada exitosamente.");
    }

    public function getPosturaArriendo($sku)
    {   
        $postura = Arriendo::where('sku', $sku)->with('PosturaNORendidas.TipoPago')->first();
        return response()->json($postura);
    }

    public function getDetallePostura($sku)
    {   
        $postura = Postura::where('sku', $sku)->with('TipoPago', 'DetallePostura.ItemPostura')->first();

        return response()->json($postura);
    }

    public function anularPostura(Request $request)
    {   
        $fecha = new \DateTime();

        Postura::updateOrCreate(['id_postura' => $request->id],[
                                        'estado_id' => 13, 
                                        'motivo' => $request->motivo, 
                                        'solicitud_anulacion' => 1, 
                                        'fecha_anulacion' => $fecha->format('Y-m-d')]);

        return response()->json($request);
    }

    public function historialPostura()
    {
        $empresas = Empresa::all();
        $pagos = TipoPago::all();
        $entidades = EntidadFinanciera::all();
        $itemsPosturas = ItemPostura::all();

        return view('pages.postura.historial', compact('empresas', 'pagos', 'entidades', 'itemsPosturas'));
    }

    public function searchPostura(Request $request)
    {   
        $arriendo = Arriendo::where('sku', $request->sku)->first();

        if($request->estado == 0)
        {
            $data = Postura::where('arriendo_id', $arriendo->id_arriendo)
                            ->where('fecha_emision', 'like', $request->mes.'%')
                            ->whereIn('estado_id', [11,12,13])
                            ->with('TipoPago')
                            ->get();
        }else{
            $data = Postura::where('arriendo_id', $arriendo->id_arriendo)
                            ->where('fecha_emision', 'like', $request->mes.'%')
                            ->where('estado_id', $request->estado)
                            ->with('TipoPago')
                            ->get();
        }
        
        return response()->json($data);
    }

    //Anulacion Postura

    public function anulacionPostura()
    {   

        $data = Postura::where('estado_id', 13)->where('solicitud_anulacion', 1)->with('Arriendo.Empresa', 'TipoPago')->get();
        return view('pages.postura.anulacion', compact('data'));
    }

    public function aceptarAnulacionPostura(Request $request)
    {   
        Postura::updateOrCreate(['id_postura' => $request->id],['observacion_anulacion' => $request-> motivo, 'solicitud_anulacion' => 0]);

        $data = Postura::where('estado_id', 13)->where('solicitud_anulacion', 1)->with('Arriendo.Empresa', 'TipoPago')->get();

        return response()->json(['data' => $data, 'mensaje' => 'Anulación aceptada exitosamente.']);
    }

}
