<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuadraRequest;
use App\Http\Requests\StoreSalaRequest;
use App\Http\Requests\UpdateQuadraRequest;
use App\Http\Requests\UpdateSalaRequest;
use App\Models\Bloco;
use App\Models\Filial;
use App\Models\Quadra;
use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $data = ['salas','blocos','bloco'];

        $querySala = Sala::query();

        $querySala->when(isset($input['titulo']), function ($q) use ($input) {
            return $q->where('titulo','like', '%'.$input['titulo']. '%');
        });

        $querySala->when(isset($input['bloco_id']), function ($q) use ($input) {
            return $q->where('bloco_id',$input['bloco_id']);
        });

        $salas = $querySala->paginate(10);

        $bloco = null;
        if(isset($input['bloco_id'])){
            $bloco = Bloco::find($input['bloco_id']);
        }

        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        return view('controle.sala.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['salas','blocos'];

        $salas = Sala::pluck('titulo', 'id')->toArray();
        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        return view('controle.sala.form',compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalaRequest $request)
    {
        $input = $request->all();

        try {
            $sala = Sala::create($input);

            if ($sala) {
                return redirect()
                    ->route('controle.salas.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.salas.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.salas.index')
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
    public function edit(Sala $sala)
    {
        $data = ['sala','blocos'];

        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        return view('controle.sala.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalaRequest $request, Sala $sala)
    {
        $input = $request->all();

        try {

            if ($sala->update($input)) {
                return redirect()
                    ->route('controle.salas.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.salas.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.salas.index')
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
            $deleteObj = Sala::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
