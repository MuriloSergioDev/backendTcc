<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\Evento;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomologacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['eventos'];

        $role = auth()->user()->roles[0];

        $salas_homologadas = Sala::whereHas(
            'grupoSalas',
            function ($q) use ($role) {
                $q->where('role_id', $role->id);
            }
        )->get();

        $id_salas = array();

        foreach ($salas_homologadas as $salas_homologada) {
            array_push($id_salas,$salas_homologada->id);
        }        

        $eventos = Evento::where('status_id', 1)->whereIn('sala_id',$id_salas)->get();

        return view('controle.homologacao.index', compact($data));
    }

    public function deferir(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        try {
            $evento = Evento::find($id);
            $aux['status_id'] = 2;

            if ($evento->professor->email) {
                $contact = [
                    'subject' => 'Evento deferido',
                    'evento' => $evento,
                ];

                Mail::to($evento->professor->email)->send(new ContactFormMail($contact));
            }

            if ($evento->update($aux))
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }

    public function indeferir(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        try {
            $evento = Evento::find($id);
            $aux['status_id'] = 3;

            if ($evento->professor->email) {
                $contact = [
                    'subject' => 'Evento indeferido',
                    'evento' => $evento,
                ];

                Mail::to($evento->professor->email)->send(new ContactFormMail($contact));
            }

            if ($evento->update($aux))
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }
}
