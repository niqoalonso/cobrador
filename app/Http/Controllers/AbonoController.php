<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Empresa;
use App\Models\TipoPago;
use App\Models\EntidadFinanciera;
use App\Models\Factura;
use App\Models\Arriendo;
use Illuminate\Http\Request;
use Auth;

class AbonoController extends Controller
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
        return view('pages.abono.index', compact('empresas', 'pagos', 'entidades'));
    }

    public function getFacturacionPagoPendiente($sku)
    {   

        $empresa = Empresa::where('sku', $sku)->first();
        $empresa->load('AllArriendo.FacturaPendientes');

        return response()->json($empresa);
    }

    public function getAbonoFactura($id)
    {   
        $abonos = Abono::where('factura_id', $id)->get();
        $abonos->load('TipoPago');
        return response()->json($abonos);
    }

    public function getFacturaDeArriendo($sku, $fecha)
    {   
       
        $arriendo = Arriendo::select('id_arriendo')->where('sku', $sku)->first();
        $facturas = Factura::where('fecha_emision', 'like', $fecha.'%')->where('arriendo_id', $arriendo->id_arriendo)->get();

        return response()->json($facturas);
    }

    public function historialAbono()
    {   
        $empresas = Empresa::all();
        $pagos = TipoPago::all();
        $entidades = EntidadFinanciera::all();
        return view('pages.abono.historial', compact('empresas', 'pagos', 'entidades'));
    }

    public function getHistorialAbono($sku)
    {
        $empresa = Empresa::where('sku', $sku)->first();
        $empresa->load('Arriendo.Factura');
        return response()->json($empresa);
    }

    public function getLocalArriendo($sku)
    {
        $arriendo = Arriendo::where('sku', $sku)->first();
        $arriendo->load('Local.Area');

        return response()->json($arriendo);
    }

    public function getArriendos($sku)
    {
        $arriendos = Empresa::where('sku', $sku)->first();
        $arriendos->load('Arriendo');
        return response()->json($arriendos);
    }

    public function GenerarCodigoSkuAbono()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = Abono::select('sku')->where('sku', $number)->first();
        } while (!empty($codigo->sku));

        return $number;
    }

    public function store(Request $request)
    {   
        $factura = Factura::find($request->id);

        if(($factura->monto_pendiente-$request->monto) < 0)
        {
            return response()->json(['status' => 0, 'mensaje' => 'Monto ingresado es superior al pendiente.']);
        }

        Abono::create([ 'sku'               => $this->GenerarCodigoSkuAbono(),
                        'fecha_emision'     => $request->f_emision,
                        'monto'             => $request->monto,
                        'n_cheque'          => $request->n_cheque,
                        'n_transferencia'   => $request->n_transaccion,
                        'titular'           => $request->titular,
                        'fecha_vencimiento' => $request->f_vencimiento,
                        'fecha_transaccion' => $request->f_transaccion,
                        'entidad_id'        => $request->entidad,
                        'factura_id'        => $factura->id_factura,
                        'tipo_pago_id'      => $request->tipo_pago,
                        'estado_id'         => 12,
                        'user_id'           => Auth::user()->id
                    ]);
                    
        $pendiente = $factura->monto_pendiente-$request->monto;

        $factura->update(['monto_pendiente' => $pendiente]);

        if($pendiente == 0)
        {
            $factura->update(['estado_id' => 8]);
        }

        return response()->json(['status' => 1, 'mensaje' => 'Abono guardado exitosamente.','sku' => $request->sku]);
    }

    public function getDetalleAbono($sku)
    {   
        $detalle = Abono::where('sku', $sku)->first();
        $detalle->load('TipoPago', 'EntidadFinanciera');

        $permiso = 0;

        if(Auth()->user()->getRoleNames()[0] == "Administrador")
        {
            $permiso = 1;    // Es Administrador, asi que puede anular abonos.
        }else{
            if($detalle->user_id == Auth()->user()->id){ //Verificados si es propietario de haber creado el abono, si es el mismo que lo creo, puede anular, de lo contrario no puede.
                $permiso = 1;
            }
        }

        return response()->json(['permisoAnular' => $permiso,'detalle' => $detalle]);
    }

    public function anularAbono(Request $request)
    {   
        $fecha = new \DateTime();

        $data = Abono::updateOrCreate(['id_abono' => $request->id],['motivo' => $request->motivo, 
                                                                    'solicitud_anulacion' => 1, 
                                                                    'estado_id' => 13, 
                                                                    'fecha_anulacion' => $fecha->format('Y-m-d'), 
                                                                    'user_id_anulacion' => Auth()->user()->id
                                                                ]);
        $factura = Factura::find($data->factura_id);
        Factura::updateOrCreate(['id_factura' => $factura->id_factura],['monto_pendiente' => $factura->monto_pendiente+$data->monto, 'estado_id' => 9]);
        
        return response()->json($factura->id_factura);
    }

    public function verMotivoAnulacionAbono($id)
    {
        $abono = Abono::where('id_abono', $id)->with('UserAnulacion')->first();
        return response()->json($abono);
    }

    //Anulacion Abonos

    public function anulacionAbonos()
    {
        $data = Abono::where('estado_id', 13)->where('solicitud_anulacion', 1)->with('Factura.Arriendo.Empresa', 'TipoPago')->get();
        return view('pages.abono.anulacion', compact('data'));
    }

    public function aceptarAnulacionAbono(Request $request)
    {   
        Abono::updateOrCreate(['id_abono' => $request->id],['observacion_anulacion' => $request-> motivo, 'solicitud_anulacion' => 0]);
        $data = Abono::where('estado_id', 13)->where('solicitud_anulacion', 1)->with('Factura.Arriendo.Empresa', 'TipoPago')->get();

        return response()->json(['data' => $data, 'mensaje' => 'Anulacion aceptada exitosamente.']);
    }

}
