<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Models\Sala;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];         

        return view('controle.dashboard.index', compact($data));
    }

    public function salas()
    {        

        $bloco1_salas = Sala::with('eventos')->where('bloco_id',1)->get();
        $bloco2_salas = Sala::with('eventos')->where('bloco_id',2)->get();        

        return response()->json(['bloco1_salas' => $bloco1_salas, 'bloco2_salas' => $bloco2_salas], 200);
    }

    public function salaDetalhe($id)
    {        
        try {
            $sala = Sala::find($id);
            return response()->json(['sala' => $sala], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Not Found!'], 404);
        }              
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
