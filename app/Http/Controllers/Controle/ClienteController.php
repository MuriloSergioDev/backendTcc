<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Filial;
use App\Models\Genero;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['clientes'];

        $clientes = Cliente::get();

        return view('controle.cliente.index', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['filiais','generos'];

        $filiais = Filial::pluck('titulo', 'id')->toArray();
        $generos = Genero::pluck('titulo','id')->toArray();

        return view('controle.cliente.form',compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        $input = $request->all();

        try {
            $cliente = Cliente::create($input);

            if ($cliente) {
                return redirect()
                    ->route('controle.clientes.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }

            return redirect()
                ->route('controle.clientes.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()
                ->route('controle.clientes.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApi(StoreClienteRequest $request)
    {
        $input = $request->all();

        try {
            $cliente = Cliente::create($input);

            if ($cliente) {
                return response()->json([
                    'error' => false,
                    'msg' => 'Operação realizada com sucesso!',
                ], 200);
            }

            return response()->json([
                'error' => true,
                'msg' => 'Falha na operação!'
            ], 500);
        } catch (\Throwable $th) {
            // dd($th);
            return response()->json([
                'error' => true,
                'msg' => 'Falha na operação!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($filial_id)
    {
        $clientes = Cliente::where('filial_id',$filial_id)->get();

        return response()->json([
            'clientes' => $clientes,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $input = $request->all();
        $cliente = Cliente::find($input['id']);

        if ($cliente)
            return response()->json($cliente);

        return response()->json(['Erro' => true], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $data = ['cliente','filiais','generos'];

        $filiais = Filial::pluck('titulo', 'id')->toArray();
        $generos = Genero::pluck('titulo','id')->toArray();

        return view('controle.cliente.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $input = $request->all();

        try {

            if ($cliente->update($input)) {
                return redirect()
                    ->route('controle.clientes.index')
                    ->with('msg', 'Operação realizada com sucesso.')
                    ->with('error', false);
            }
            return redirect()
                ->route('controle.clientes.index')
                ->with('msg', 'Falha na operação.')
                ->with('error', true);
        } catch (\Throwable $th) {
            return redirect()
                ->route('controle.clientes.index')
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
            $deleteObj = Cliente::find($id)->delete();

            if ($deleteObj)
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
