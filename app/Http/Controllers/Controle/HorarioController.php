<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHorarioRequest;
use App\Http\Requests\UpdateHorarioRequest;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['horarios'];

        $horarios = Horario::get();

        return view('controle.horario.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        return view('controle.horario.form',compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHorarioRequest $request)
    {
        $input = $request->all();

        try {
            $horario = Horario::create($input);

            if ($horario) {
                return redirect()
                    ->route('controle.horarios.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.horarios.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.horarios.index')
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
    public function recuperaTodosHorariosDia(Request $request)
    {

        $input = $request->all();

        $input['start'] = $input['data_remarcacao'] . ' 00:00:00';
        $input['end'] = $input['data_remarcacao'] . ' 23:59:59';

        // dd($input);

        // $horarios = Horario::with('eventos')->where('filial_id',$input['filial_id'])->whereHas('eventos', function($query) use ($input){
        //     return $query->whereDate('start', '>=',$input['start'])->whereDate('end','<=', $input['end']);
        // })->get();

        // $horarios = Horario::with('eventos')->where('filial_id',$input['filial_id'])->whereRelation('eventos', 'start', '>=',$input['start'])->whereRelation('eventos', 'end', '<=',$input['end'])->get();

        $horarios = Horario::where('filial_id',$input['filial_id'])->with('eventos.tipo','eventos.eventoClientes')->with(['eventos' => function ($query) use ($input){
            $query->where('start', '>=', $input['start'])->where('end', '<=', $input['end']);
            $query->where('filial_id',$input['filial_id']);
            $query->where('quadra_id',$input['quadra_id']);
        }])->get();

        return response()->json($horarios);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Horario $horario)
    {
        $data = ['horario'];

        return view('controle.horario.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHorarioRequest $request, Horario $horario)
    {
        $input = $request->all();

        try {

            if ($horario->update($input)) {
                return redirect()
                    ->route('controle.horarios.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.horarios.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.horarios.index')
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
            $deleteObj = Horario::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
