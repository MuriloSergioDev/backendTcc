@section('title', 'Administradores')
@extends('layouts.default')

@section('content')

    <h1 class="page-header">Grupo de Usuários</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de Grupo de Usuário</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>



        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="panel-body">
            <div class="btn-group mr-5">
                <div class="d-flex align-items-center justify-content-center mr-10 mb-3">
                    <a href="{{ route('controle.roles.create') }}" class="btn p-l-40 p-r-40 btn-sm label label-green">
                        Cadastrar
                    </a>
                </div>
            </div>
            <table id="data-table-combine" class="table table-striped table-bordered table-td-valign-middle">
            <tr>
                <th width="1%"></th>
				<th width="1%">Foto</th>
                <th>Nome</th>
                <th class="text-nowrap">Data inicio edição</th>
				<th class="text-nowrap">Data fim edição</th>
                <th width="280px">Opções</th>
            </tr>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td width="1%"><img src="/assets/img/user/user-12.jpg" class="img-rounded height-30"></td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->data_inicio ?? ''}}</td>
					<td>{{ $role->data_fim ?? ''}}</td>

                    @if ($role->name != 'Administrador')

                    <td>
                        <a href="{{ route('controle.roles.edit', $role->id) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>

                        <a href="{{ route('controle.roles.delete', $role->id) }}"
                            class="btn btn-danger btn-sm atencao">
                            <i class="fa fa-trash-alt"></i>
                            Excluir
                        </a>
                    </td>
                    @else
                    <td>

                    </td>
                    @endif
                </tr>
            @endforeach
        </table>

    </div>

    {{-- {!! $roles->render() !!} --}}

@endsection
