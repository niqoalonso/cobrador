<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoPagoRequest;
use App\Http\Requests\UpdateTipoPagoRequest;
use App\Models\TipoPago;

class TipoPagoController extends Controller
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
     * @param  \App\Http\Requests\StoreTipoPagoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoPagoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function show(TipoPago $tipoPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoPago $tipoPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoPagoRequest  $request
     * @param  \App\Models\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoPagoRequest $request, TipoPago $tipoPago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoPago  $tipoPago
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoPago $tipoPago)
    {
        //
    }
}
