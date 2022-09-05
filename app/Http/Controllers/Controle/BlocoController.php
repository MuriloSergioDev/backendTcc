<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlocoRequest;
use App\Http\Requests\StoreFilialRequest;
use App\Http\Requests\UpdateFilialRequest;
use App\Models\Bloco;
use Illuminate\Http\Request;

class BlocoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['blocos'];
        $blocos = Bloco::get();
        return view('controle.bloco.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('controle.bloco.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlocoRequest $request)
    {
        $input = $request->all();

        try {
            $bloco = Bloco::create($input);

            if ($bloco) {
                return redirect()
                    ->route('controle.bloco.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.bloco.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.bloco.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $input = $request->all();

        $bloco = Bloco::with('salas')->find($input['bloco_id']);

        return response()->json(['bloco' => $bloco]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bloco $bloco)
    {
        $data = ['bloco'];

        return view('controle.bloco.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFilialRequest $request, Bloco $bloco)
    {
        $input = $request->all();

        try {

            if ($bloco->update($input)) {
                return redirect()
                    ->route('controle.bloco.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.bloco.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.bloco.index')
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
            $deleteObj = Bloco::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
