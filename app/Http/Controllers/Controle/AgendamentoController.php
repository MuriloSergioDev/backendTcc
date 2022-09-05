<?php

namespace App\Http\Controllers\Controle;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventoRecorrenteRequest;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Models\Agendamento;
use App\Models\Bloco;
use App\Models\Evento;
use App\Models\EventoCliente;
use App\Models\Horario;
use App\Models\Professor;
use App\Models\Sala;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\ContactRecorrenteFormMail;
use App\Models\Feriado;
use App\Models\GrupoSala;
use App\Models\User;

class AgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $data = ['agendamentos', 'bloco', 'blocos', 'salas'];

        $bloco = null;
        if (isset($input['bloco_id'])) {
            $bloco = Bloco::find($input['bloco_id']);
        }

        $sala = null;
        if (isset($input['sala_id'])) {
            $sala = Sala::find($input['sala_id']);
        }

        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        $salas = Sala::pluck('titulo', 'id')->toArray();

        $queryAgendamento = Agendamento::query();

        $queryAgendamento->when(isset($input['titulo']), function ($q) use ($input) {
            return $q->where('titulo', 'like', '%' . $input['titulo'] . '%');
        });

        $queryAgendamento->when(isset($input['data_inicio']), function ($q) use ($input) {
            return $q->where('data_inicio', '>=', $input['data_inicio']);
        });

        $queryAgendamento->when(isset($input['data_fim']), function ($q) use ($input) {
            return $q->where('data_fim', '<=', $input['data_fim']);
        });

        $agendamentos = $queryAgendamento->paginate(25);

        return view('controle.agendamento.index', compact($data));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendario(Request $request)
    {
        ini_set("memory_limit", "-1");
        $input = $request->all();
        $data = ['blocos', 'salas', 'professores', 'bloco', 'sala_selecionada', 'tipos', 'professor'];

        $bloco = null;
        if (isset($input['bloco_id'])) {
            $bloco = Bloco::find($input['bloco_id']);
        }

        $professor = null;
        if (isset($input['professor_id'])) {
            $professor = Professor::find($input['professor_id']);
        }


        if (isset($input['sala_id'])) {
            $sala_selecionada = Sala::find($input['sala_id']);
        } else {
            $sala_selecionada = null;
        }

        $querySala = Sala::query();

        $querySala->when(isset($bloco), function ($q) use ($bloco) {
            return $q->where('bloco_id', $bloco->id);
        });

        $salas = $querySala->pluck('titulo', 'id')->toArray();
        $professores = Professor::pluck('nome', 'id')->toArray();

        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        $tipos = Tipo::pluck('titulo', 'id')->toArray();

        return view('controle.agendamento.calendario', compact($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['tipos', 'blocos', 'professores'];

        $blocos = Bloco::pluck('titulo', 'id')->toArray();
        $tipos = Tipo::pluck('titulo', 'id')->toArray();
        $professores = Professor::pluck('nome', 'id')->toArray();

        return view('controle.agendamento.form', compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventoRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {

            if (strtotime($input['horario_inicial']) >= strtotime($input['horario_final'])) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Horário inicial não pode ser menor ou igual ao final!'
                ], 202);
            }

            $agendamento_aux['titulo'] = $input['title'];
            $agendamento_aux['data_inicio'] = $input['data_inicio'];
            $agendamento_aux['data_fim'] = $input['data_fim'];
            $agendamento_aux['status_id'] = 1;
            $agendamento = Agendamento::create($agendamento_aux);

            $input['agendamento_id'] =  $agendamento->id;

            $input['start'] = $input['data_inicio'] . ' ' . $input['horario_inicial'];
            $input['end'] = $input['data_fim'] . ' ' . $input['horario_final'];
            $sala = Sala::find($input['sala_id']);

            $input['backgroundColor'] = $sala->backgroundColor;

            $evento = Evento::where('bloco_id', $input['bloco_id'])
                ->where('sala_id', $input['sala_id'])
                ->where(function ($query) use ($input) {
                    $query->whereBetween('start', [$input['start'], $input['end']])
                        ->orWhereBetween('end', [$input['start'], $input['end']])
                        ->orWhere(function ($q) use ($input) {
                            $q->where('start', '<=', $input['end'])
                                ->where('end', '>=', $input['start']);
                        });
                })
                ->first();

            if (!isset($evento)) {
                $sala_homologadas = GrupoSala::where('sala_id', $input['sala_id'])->get();
                if (!isset($sala_homologadas) || count($sala_homologadas) == 0) {
                    $input['status_id'] = 2;
                }
                $novo_evento = Evento::create($input);

                $professor = Professor::find($input['professor_id']);

                //Manda email para professor responsável
                if ($professor->email and isset($sala_homologadas)) {
                    $contact = [
                        'subject' => 'Evento em homologação',
                        'evento' => $novo_evento,
                    ];

                    Mail::to($professor->email)->send(new ContactFormMail($contact));
                } else if ($professor->email) {
                    $contact = [
                        'subject' => 'Evento deferido',
                        'evento' => $novo_evento,
                    ];

                    Mail::to($professor->email)->send(new ContactFormMail($contact));
                }

                //Manda email para todos usuários homologadores dessa sala se houver
                if (isset($sala_homologadas) and count($sala_homologadas)>0) {
                    foreach ($sala_homologadas as $sala_homologada) {
                        $homologadores = User::whereHas(
                            'roles',
                            function ($q) use ($sala_homologada) {
                                $q->where('id', $sala_homologada->role_id);
                            }
                        )->get();

                        foreach ($homologadores as $homologador) {
                            if ($homologador->email) {
                                $contact = [
                                    'subject' => 'Nova solicitação de evento',
                                    'evento' => $novo_evento,
                                ];

                                Mail::to($homologador->email)->send(new ContactFormMail($contact));
                            }
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'error' => false,
                    'msg' => 'Operação realizada com sucesso!'
                ], 201);
            }

            return response()->json([
                'error' => true,
                'msg' => 'Horário já alocado!',
                'evento' => $evento
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json([
                'error' => true,
                'msg' => 'Falha na operação!'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRecorrente(StoreEventoRecorrenteRequest $request)
    {
        $input = $request->all();

        $feriados = array();

        if (isset($input['agendamento_id']) and isset($input['alterar_antigos']) and $input['alterar_antigos'] == true) {

            $eventos = Evento::where('agendamento_id', $input['agendamento_id'])->get();

            foreach ($eventos as $evento) {
                $evento->delete();
            }
        }

        $mondays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this monday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $mondays[] = $date->format('Y-m-d');
        }

        $tuesdays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this tuesday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $tuesdays[] = $date->format('Y-m-d');
        }

        $wednesdays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this wednesday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $wednesdays[] = $date->format('Y-m-d');
        }

        $thursdays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this thursday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $thursdays[] = $date->format('Y-m-d');
        }

        $fridays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this friday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $fridays[] = $date->format('Y-m-d');
        }

        $saturdays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this saturday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $saturdays[] = $date->format('Y-m-d');
        }

        $sundays = [];
        $startDate = Carbon::parse($input['data_inicio'])->modify('this sunday');
        $endDate = Carbon::parse($input['data_fim']);

        for ($date = $startDate; $date->lte($endDate); $date->addWeek()) {
            $sundays[] = $date->format('Y-m-d');
        }

        //Verifica se nenhum dos dias selecionados está presente no periodo selecionado
        if (!((count($mondays) and in_array(1, $input['dia_semana']))
            or (count($tuesdays) and in_array(2, $input['dia_semana']))
            or (count($wednesdays) and in_array(3, $input['dia_semana']))
            or (count($thursdays) and in_array(4, $input['dia_semana']))
            or (count($fridays) and in_array(5, $input['dia_semana']))
            or (count($saturdays) and in_array(6, $input['dia_semana']))
            or (count($sundays) and in_array(7, $input['dia_semana'])))) {
            return response()->json([
                'error' => true,
                'msg' => 'Não há no período selecionado o dia da semana indicado!'
            ], 202);
        }

        $dias_da_semana = ['1' => $mondays, '2' => $tuesdays, '3' => $wednesdays, '4' => $thursdays, '5' => $fridays, '6' => $saturdays, '7' => $sundays];
        DB::beginTransaction();
        try {
            $sala_homologadas = GrupoSala::where('sala_id', $input['sala_id'])->get();

            $agendamento_aux['titulo'] = $input['title'];
            $agendamento_aux['descricao'] = $input['description'];
            $agendamento_aux['data_inicio'] = $input['data_inicio'];
            $agendamento_aux['data_fim'] = $input['data_fim'];
            if (isset($input['agendamento_id'])) {
                $agendamento = Agendamento::find($input['agendamento_id']);
                $agendamento->update($agendamento_aux);
            } else {
                $agendamento = Agendamento::create($agendamento_aux);
            }
            foreach ($dias_da_semana as $key => $dia_da_semana) {
                if (in_array($key, $input['dia_semana'])) {
                    foreach ($dia_da_semana as $dia) {

                        if ($input['horario_inicial_' . $key] == $input['horario_final_' . $key]) {
                            DB::rollBack();
                            return response()->json([
                                'error' => true,
                                'msg' => 'Horário inicial não pode ser igual ao final!'
                            ], 202);
                        }

                        $input['start'] = $dia . ' ' . $input['horario_inicial_' . $key];
                        $input['end'] = $dia . ' ' . $input['horario_final_' . $key];

                        $sala = Sala::find($input['sala_id']);

                        $input['backgroundColor'] = $sala->backgroundColor;

                        $evento = Evento::where('bloco_id', $input['bloco_id'])
                            ->where('sala_id', $input['sala_id'])
                            ->where(function ($query) use ($input) {
                                $query->whereBetween('start', [$input['start'], $input['end']])
                                    ->orWhereBetween('end', [$input['start'], $input['end']])
                                    ->orWhere(function ($q) use ($input) {
                                        $q->where('start', '<=', $input['end'])
                                            ->where('end', '>=', $input['start']);
                                    });
                            })
                            ->first();

                        if (!isset($evento)) {
                            $input['agendamento_id'] =  $agendamento->id;

                            $feriado = Feriado::where('data', $dia)->first();
                            if (!isset($feriado)) {
                                if (!isset($sala_homologadas) || count($sala_homologadas) == 0) {
                                    $input['status_id'] = 2;
                                }
                                $novo_evento = Evento::create($input);
                            }else{                                
                                array_push($feriados,$feriado);
                            }
                        } else {
                            DB::rollBack();
                            return response()->json([
                                'error' => true,
                                'msg' => 'Horário já alocado!',
                                'evento' => $evento
                            ], 200);
                        }
                    }
                }
            }

            $professor = Professor::find($input['professor_id']);

            if ($professor->email and isset($sala_homologadas)) {
                $contact = [
                    'subject' => 'Eventos em homologação',
                    'agendamento' => $agendamento,
                    'input' => $input,
                    'dias_da_semana' => $dias_da_semana
                ];

                Mail::to($professor->email)->send(new ContactRecorrenteFormMail($contact));
            } else if ($professor->email) {
                $contact = [
                    'subject' => 'Eventos deferidos',
                    'agendamento' => $agendamento,
                    'input' => $input,
                    'dias_da_semana' => $dias_da_semana
                ];

                Mail::to($professor->email)->send(new ContactRecorrenteFormMail($contact));
            }


            //Manda email para todos usuários homologadores dessa sala se houver
            if (isset($sala_homologadas) and count($sala_homologadas)>0) {

                foreach ($sala_homologadas as $sala_homologada) {
                    $homologadores = User::whereHas(
                        'roles',
                        function ($q) use ($sala_homologada) {
                            $q->where('id', $sala_homologada->role_id);
                        }
                    )->get();

                    foreach ($homologadores as $homologador) {
                        if ($homologador->email) {
                            $contact = [
                                'subject' => 'Nova solicitação de evento',
                                'agendamento' => $agendamento,
                                'input' => $input,
                                'dias_da_semana' => $dias_da_semana
                            ];

                            Mail::to($homologador->email)->send(new ContactRecorrenteFormMail($contact));
                        }
                    }
                }
            }

            DB::commit();
            return response()->json([
                'error' => false,
                'msg' => 'Operação realizada com sucesso!',
                'feriados' => $feriados
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
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
    public function show($bloco_id = null, $sala_id = null, $professor_id = null)
    {

        $query = Evento::query();

        $query->when(isset($bloco_id) && $bloco_id != 0, function ($q) use ($bloco_id) {
            return $q->where('bloco_id', $bloco_id);
        });

        $query->when(isset($sala_id) && $sala_id != 0, function ($q) use ($sala_id) {
            return $q->where('sala_id', $sala_id);
        });

        $query->when(isset($professor_id) && $professor_id != 0, function ($q) use ($professor_id) {
            return $q->where('professor_id', $professor_id);
        });

        $eventos = $query->with('professor', 'tipo', 'sala', 'bloco')->where('status_id', 2)->get();
        return response()->json($eventos);
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
        $evento = Evento::with('tipo')->find($input['id']);

        if ($evento)
            return response()->json($evento);

        return response()->json(['Erro' => true], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamento $agendamento)
    {
        $data = ['tipos', 'blocos', 'agendamento', 'eventos', 'professores'];

        $blocos = Bloco::pluck('titulo', 'id')->toArray();

        $eventos = Evento::where('agendamento_id', $agendamento->id)->get();

        $tipos = Tipo::pluck('titulo', 'id')->toArray();

        $professores = Professor::pluck('nome', 'id')->toArray();

        return view('controle.agendamento.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventoRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {

            if ($input['horario_inicial'] == $input['horario_final']) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Horário inicial não pode ser igual ao final!'
                ], 202);
            }

            $id = $input['id'];

            $input['start'] = $input['data_inicio'] . ' ' . $input['horario_inicial'];
            $input['end'] = $input['data_fim'] . ' ' . $input['horario_final'];

            $sala = Sala::find($input['sala_id']);

            $input['backgroundColor'] = $sala->backgroundColor;

            $eventoAlocado = Evento::where('bloco_id', $input['bloco_id'])
                ->where('sala_id', $input['sala_id'])
                ->where(function ($query) use ($input) {
                    $query->whereBetween('start', [$input['start'], $input['end']])
                        ->orWhereBetween('end', [$input['start'], $input['end']])
                        ->orWhere(function ($q) use ($input) {
                            $q->where('start', '<=', $input['end'])
                                ->where('end', '>=', $input['start']);
                        });
                })
                ->first();

            if (isset($eventoAlocado) && $eventoAlocado->id != $input['id']) {
                DB::rollback();
                return response()->json([
                    'error' => true,
                    'msg' => 'Horário já alocado!',
                    'evento' => $eventoAlocado
                ], 200);
            }

            $evento = Evento::find($id);

            if ($evento->update($input)) {

                DB::commit();
                return response()->json([
                    'error' => false,
                    'msg' => 'Operação realizada com sucesso!'
                ], 201);
            }

            DB::rollback();
            return response()->json([
                'error' => true,
                'msg' => 'Erro ao atualizar!'
            ], 500);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return response()->json([
                'error' => true,
                'msg' => 'Falha na operação!'
            ], 500);
        }
    }

    public function updateData(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $evento = Evento::find($input['id']);

            $data_horario_start = explode(' ', $evento->start);
            $hora_inicial = substr($data_horario_start[1], 0, -3);

            $data_horario_end = explode(' ', $evento->end);
            $hora_final = substr($data_horario_end[1], 0, -3);

            $input['start'] = $input['data_inicio'] . ' ' . $hora_inicial;
            $input['end'] = $input['data_fim'] . ' ' . $hora_final;


            $eventoAlocado = Evento::where('bloco_id', $evento->bloco_id)
                ->where('sala_id', $evento->sala_id)
                ->where(function ($query) use ($input) {
                    $query->whereBetween('start', [$input['start'], $input['end']])
                        ->orWhereBetween('end', [$input['start'], $input['end']])
                        ->orWhere(function ($q) use ($input) {
                            $q->where('start', '<=', $input['end'])
                                ->where('end', '>=', $input['start']);
                        });
                })
                ->first();

            if ($eventoAlocado && $eventoAlocado->id != $evento->id) {
                return response()->json([
                    'error' => true,
                    'msg' => 'Horário já alocado!',
                    'evento' => $eventoAlocado
                ], 200);
            }

            $evento->update($input);

            DB::commit();
            return response()->json([
                'error' => false,
                'msg' => 'Operação realizada com sucesso!'
            ], 202);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return response()->json([
                'error' => true,
                'msg' => 'Falha na operação!'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvento(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        try {
            $deleteObj = Evento::find($id);
            $evento = $deleteObj;

            if ($deleteObj->delete()) {
                $professor = Professor::find($evento->professor_id);

                if ($professor->email) {
                    $contact = [
                        'subject' => 'Evento desmarcado',
                        'evento' => $evento,
                    ];

                    Mail::to($professor->email)->send(new ContactFormMail($contact));
                }
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);
            }

            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            // dd($th);
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
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

        DB::beginTransaction();
        try {
            $agendamento = Agendamento::find($id);

            $eventos = Evento::where('agendamento_id', $agendamento->id)->get();

            foreach ($eventos as $evento) {
                $evento->delete();
            }

            if ($agendamento->delete()) {
                DB::commit();
                return response()->json(['error' => false, 'message' => 'Operação realizada com sucesso!'], 204);
            }

            DB::rollback();
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
        }
    }

    public function getTipo(Request $request)
    {
        $input = $request->all();

        $tipo = Tipo::find($input['id']);

        if ($tipo)
            return response()->json(['error' => false, 'tipo' => $tipo], 200);

        return response()->json(['error' => true, 'message' => 'Falha na operação'], 400);
    }

    public function verificaDisponibilidadeDia(Request $request)
    {
        // $input = $request->all();

        // $sala_id = $input['sala_id'];

        // $data_atual = date('Y-m-d', strtotime($input['data_celula']));

        // $query = Evento::query();

        // $query->when(isset($sala_id), function ($q) use ($sala_id) {
        //     return $q->where('sala_id', $sala_id);
        // });

        // $start = $data_atual . ' ' . $horario->hora_inicial;
        // $end = $data_atual . ' ' . $horario->hora_final;

        // $evento = $query->whereBetween('start', [$start, $end])
        //     ->first();

        // if (!isset($evento)) {
        //     return response()->json(['disponibilidade' => true, 'data' => $data_atual]);
        //     break;
        // }

        // return response()->json(['disponibilidade' => false, 'data' => $data_atual]);
    }
}
