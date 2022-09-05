<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeriadoRequest;
use App\Http\Requests\UpdateFeriadoRequest;
use App\Models\Feriado;
use Illuminate\Http\Request;

class FeriadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['feriados'];
        $feriados = Feriado::get();
        return view('controle.feriado.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('controle.feriado.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeriadoRequest $request)
    {
        $input = $request->all();

        try {
            $feriado = Feriado::create($input);

            if ($feriado) {
                return redirect()
                    ->route('controle.feriados.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.feriados.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.feriados.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Feriado $feriado)
    {
        $data = ['feriado'];

        return view('controle.feriado.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeriadoRequest $request, Feriado $feriado)
    {
        $input = $request->all();

        try {

            if ($feriado->update($input)) {
                return redirect()
                    ->route('controle.feriados.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.feriados.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.feriados.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        try {
            $deleteObj = Feriado::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }

    public function show(Request $request)
    {
        $input = $request->all();

        $data = date('Y-m-d', strtotime($input['data_celula']));

        $feriado = Feriado::where('data', $data)->get();

        if (isset($feriado) && count($feriado) > 0) {
            return response()->json(['disponibilidade' => false, 'feriado' => $feriado]);
        }

        return response()->json(['disponibilidade' => true, 'feriado' => $feriado]);
    }
}
