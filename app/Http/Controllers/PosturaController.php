<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosturaRequest;
use App\Http\Requests\UpdatePosturaRequest;
use App\Models\Postura;
use App\Models\Empresa;
use App\Models\TipoPago;
use App\Models\EntidadFinanciera;
use App\Models\ItemPostura;

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
        $items = ItemPostura::all();

        return view('pages.postura.index', compact('empresas', 'pagos', 'entidades', 'items'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePosturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePosturaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Postura  $postura
     * @return \Illuminate\Http\Response
     */
    public function show(Postura $postura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Postura  $postura
     * @return \Illuminate\Http\Response
     */
    public function edit(Postura $postura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePosturaRequest  $request
     * @param  \App\Models\Postura  $postura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePosturaRequest $request, Postura $postura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Postura  $postura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Postura $postura)
    {
        //
    }
}
