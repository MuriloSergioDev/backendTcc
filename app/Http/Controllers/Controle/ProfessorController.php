<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfessorRequest;
use App\Http\Requests\UpdateProfessorRequest;
use App\Models\Filial;
use App\Models\Genero;
use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $data = ['professores'];        

        $queryProfessor = Professor::query();

        $queryProfessor->when(isset($input['nome']), function ($q) use ($input) {
            return $q->where('nome','like', '%'.$input['nome']. '%');
        });

        $professores = $queryProfessor->paginate(20);

        return view('controle.professor.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];

        return view('controle.professor.form',compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessorRequest $request)
    {
        $input = $request->all();

        try {
            $professor = Professor::create($input);

            if ($professor) {
                return redirect()
                    ->route('controle.professor.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.professor.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()
                ->route('controle.professor.index')
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
    public function edit(Professor $professor)
    {
        $data = ['professor'];

        return view('controle.professor.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessorRequest $request, Professor $professor)
    {
        $input = $request->all();

        try {

            if ($professor->update($input)) {
                return redirect()
                    ->route('controle.professor.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.professor.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.professor.index')
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
            $deleteObj = Professor::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
