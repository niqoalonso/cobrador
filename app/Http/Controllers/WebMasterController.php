<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebMasterController extends Controller
{

    public function index()
    {
        return view('pages.administracion.index');
    }

    //METODO DOM PDF PRUEBA

    public function domPDFDescargar()
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<h1>Styde.net</h1>');

        return $pdf->download('mi-archivo.pdf');
    }

    public function domPDFNavegador()
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<h1>Styde.net</h1>');

        return $pdf->stream('mi-archivo.pdf');
    }
    
}
