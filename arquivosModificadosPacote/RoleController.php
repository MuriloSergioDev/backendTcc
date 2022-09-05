<?php

namespace Brediweb\BrediDashboard\Http\Controllers;

use App\Models\GrupoSala;
use App\Models\Sala;
use Brediweb\BrediDashboard\Http\Requests\RoleStoreRequest;
use Brediweb\BrediDashboard\Http\Requests\RoleUpdateRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'ASC')->paginate(5);
        return view('controle.roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ['permission', 'salas'];
        $permission = Permission::get();
        $salas = Sala::pluck('titulo', 'id')->toArray();
        return view('controle.roles.form', compact($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $input = $request->all();
        $role = Role::create(['name' => $request->input('name'), 'data_inicio' => $request->input('data_inicio'), 'data_fim' => $request->input('data_fim'), 'guard_name' => 'web']);
        $role->syncPermissions($request->input('permission'));

        $aux['role_id'] = $role->id;        
        foreach ($input['sala_id'] as $sala_id) {
            $aux['sala_id'] = $sala_id;
            GrupoSala::create($aux);
        }        

        return redirect()->route('controle.roles.index')
            ->with('success', 'Operação realizada com sucesso.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('controle.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ['permission', 'salas', 'role', 'rolePermissions','grupoSalas'];
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();                
        $salas = Sala::pluck('titulo', 'id')->toArray();
        $grupoSalas = GrupoSala::with('sala')->where('role_id',$role->id)->get();

        return view('controle.roles.form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $input = $request->all();
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->data_inicio = $request->input('data_inicio');
        $role->data_fim = $request->input('data_fim');
        $role->save();

        $grupoSalaExistente = GrupoSala::where('role_id', $role->id)->get();

        //Remove os não presentes na requisição
        foreach ($grupoSalaExistente as $grupoSala) {
            if (!(in_array($grupoSala->id, $input['sala_id']))) {                
                $grupoSala->delete();                
            }
        }

        $aux['role_id'] = $role->id;        
        foreach ($input['sala_id'] as $sala_id) {
            $salaExistente = GrupoSala::where('role_id',$role->id)->where('sala_id',$sala_id)->first();
            if (!$salaExistente) {                
                $aux['sala_id'] = $sala_id;
                GrupoSala::create($aux);
            }
        }

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('controle.roles.index')
            ->with('success', 'Operação realizada com sucesso.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('controle.roles.index')
            ->with('success', 'Operação realizada com sucesso.');
    }
}
