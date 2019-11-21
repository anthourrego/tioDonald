<?php

namespace App\Http\Controllers;

use App\Pisos;
use Illuminate\Http\Request;

class PisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mesas = Pisos::with('Mesas')->get();
        return $mesas;
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
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function show(Pisos $pisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pisos $pisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pisos $pisos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pisos  $pisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pisos $pisos)
    {
        //
    }

    public function listaPisos(){
        $pisos = Pisos::where("estado", 1)->get();

        if (!empty($pisos)) {
            $resp = array("success" => true,
                         "mensaje" => $pisos);
        }else{
            $resp = array("success" => false,
                          "mensaje" => "No hay datos");
        }
        return $resp;
    }
}
