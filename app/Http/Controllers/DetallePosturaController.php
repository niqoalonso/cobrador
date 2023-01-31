<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetallePosturaRequest;
use App\Http\Requests\UpdateDetallePosturaRequest;
use App\Models\DetallePostura;

class DetallePosturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetallePosturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetallePosturaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetallePostura  $detallePostura
     * @return \Illuminate\Http\Response
     */
    public function show(DetallePostura $detallePostura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetallePostura  $detallePostura
     * @return \Illuminate\Http\Response
     */
    public function edit(DetallePostura $detallePostura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetallePosturaRequest  $request
     * @param  \App\Models\DetallePostura  $detallePostura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetallePosturaRequest $request, DetallePostura $detallePostura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetallePostura  $detallePostura
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetallePostura $detallePostura)
    {
        //
    }
}
