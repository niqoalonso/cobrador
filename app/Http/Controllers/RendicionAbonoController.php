<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendicionAbono;
use App\Models\Abono;

class RendicionAbonoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function indexAbono()
    {  
        $abonos     = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->get();
        return view('pages.rendicionAbono.index', compact('abonos'));
    }

    public function GenerarCodigoFolio()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = RendicionAbono::select('folio')->where('folio', $number)->first();
        } while (!empty($codigo->folio));

        return $number;
    }

    public function storeRendicionAbono()
    {   
        $fecha          = new \DateTime();
        

        $efectivo       = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 1)->sum('monto');
        $cheque         = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 2)->sum('monto');
        $transferencia  = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 3)->sum('monto');
        $monto          = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->sum('monto');

        $rendicion = RendicionAbono::create([   'folio' => $this->GenerarCodigoFolio(),
                                                'fecha_emision' => $fecha->format('Y-m-d'),
                                                'monto_efectivo' => $efectivo,
                                                'monto_cheque' => $cheque,
                                                'monto_transferencia' => $transferencia,
                                                'monto' => $monto,
                                                'user_id' => Auth()->user()->id]);
        
        $abonos         = Abono::where('user_id', Auth()->user()->id)->where('estado_id', 12)->update(['estado_id' => 11, 'rendicion_id' => $rendicion->id_rendicion]);

        return response()->json('Rendicion ingresa exitosamente.');
    }

    public function indexHistorial()
    {
        return view('pages.rendicionAbono.historial');
    }

    public function getHistorialAbono($mes)
    {   
        $rendicion = RendicionAbono::where('fecha_emision', 'like', $mes.'%')->where('user_id', Auth()->user()->id)->get();
        return response()->json($rendicion);
    }

    public function getAbonoRendicion($id)
    {
        $abonos = Abono::where('rendicion_id',$id)->get();
        return response()->json($abonos);

    }

    public function indexSolicitudRendicion()
    {   
        $rendiciones = RendicionAbono::where('estado_id', 12)->get();
        return view('pages.rendicionAbono.solicitud', compact('rendiciones'));
    }

    public function aprobarRendicionAbonos($id)
    {
        RendicionAbono::where('id_rendicion', $id)->update(['estado_id' => 11]);

        $rendiciones = RendicionAbono::where('estado_id', 12)->with('User')->get();

        return response()->json(['rendiciones' => $rendiciones, 'mensaje' => "Rendición aprobada exitosamente."]);
        

    }

}
