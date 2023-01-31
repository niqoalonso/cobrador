<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendicionPostura;
use App\Models\Postura;

class RendicionPosturaController extends Controller
{   
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function indexPostura()
    {  
        $posturas     = Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->get();
        return view('pages.rendicionPostura.index', compact('posturas'));
    }

    public function GenerarCodigoFolio()
    {
        do {            
            $number = rand(1, 5000);
            $codigo = RendicionPostura::select('folio')->where('folio', $number)->first();
        } while (!empty($codigo->folio));

        return $number;
    }

    public function storeRendicionPostura()
    {   
        $fecha          = new \DateTime();
        

        $efectivo       = Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 1)->sum('total');
        $cheque         = Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 2)->sum('total');
        $transferencia  = Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->where('tipo_pago_id', 3)->sum('total');
        $monto          = Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->sum('total');

        $rendicion = RendicionPostura::create(['folio' => $this->GenerarCodigoFolio(),
                                                'fecha_emision' => $fecha->format('Y-m-d'),
                                                'monto_efectivo' => $efectivo,
                                                'monto_cheque' => $cheque,
                                                'monto_transferencia' => $transferencia,
                                                'monto' => $monto,
                                                'user_id' => Auth()->user()->id]);
        
        Postura::where('user_id', Auth()->user()->id)->where('estado_id', 12)->update(['estado_id' => 11, 'rendicion_id' => $rendicion->id_rendicion]);

        return response()->json('Rendicion ingresa exitosamente.');
    }

    public function indexHistorial()
    {
        return view('pages.rendicionPostura.historial');
    }

    public function getHistorialPostura($mes)
    {   
        $rendicion = RendicionPostura::where('fecha_emision', 'like', $mes.'%')->where('user_id', Auth()->user()->id)->get();
        return response()->json($rendicion);
    }

    public function getPosturaRendicion($id)
    {
        $posturas = Postura::where('rendicion_id',$id)->with('TipoPago')->get();
        return response()->json($posturas);

    }


    public function indexSolicitudRendicion()
    {   
        $rendiciones = RendicionPostura::where('estado_id', 12)->get();
        return view('pages.rendicionPostura.solicitud', compact('rendiciones'));
    }

    public function aprobarRendicionPosturas($id)
    {
        RendicionPostura::where('id_rendicion', $id)->update(['estado_id' => 11]);

        $rendiciones = RendicionPostura::where('estado_id', 12)->with('User')->get();

        return response()->json(['rendiciones' => $rendiciones, 'mensaje' => "Rendición aprobada exitosamente."]);
        

    }
}
