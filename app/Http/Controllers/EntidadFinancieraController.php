<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntidadFinancieraRequest;
use App\Http\Requests\UpdateEntidadFinancieraRequest;
use App\Models\EntidadFinanciera;

class EntidadFinancieraController extends Controller
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
     * @param  \App\Http\Requests\StoreEntidadFinancieraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntidadFinancieraRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function show(EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function edit(EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEntidadFinancieraRequest  $request
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntidadFinancieraRequest $request, EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntidadFinanciera $entidadFinanciera)
    {
        //
    }
}
