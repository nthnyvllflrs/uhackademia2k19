<?php

namespace App\Http\Controllers;

use App\BarangayId;
use App\User;
use Illuminate\Http\Request;

class BarangayIdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        BarangayId::create(['brgy_id_number'=>2527, 'name'=>'FATIMA MERCY A ONRUBIA']);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BarangayId  $barangayId
     * @return \Illuminate\Http\Response
     */
    public function show(BarangayId $barangayId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BarangayId  $barangayId
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangayId $barangayId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BarangayId  $barangayId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangayId $barangayId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BarangayId  $barangayId
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangayId $barangayId)
    {
        //
    }
}
