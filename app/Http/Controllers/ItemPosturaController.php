<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemPosturaRequest;
use App\Http\Requests\UpdateItemPosturaRequest;
use App\Models\ItemPostura;

class ItemPosturaController extends Controller
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
     * @param  \App\Http\Requests\StoreItemPosturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemPosturaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemPostura  $itemPostura
     * @return \Illuminate\Http\Response
     */
    public function show(ItemPostura $itemPostura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemPostura  $itemPostura
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemPostura $itemPostura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemPosturaRequest  $request
     * @param  \App\Models\ItemPostura  $itemPostura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemPosturaRequest $request, ItemPostura $itemPostura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemPostura  $itemPostura
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemPostura $itemPostura)
    {
        //
    }
}
