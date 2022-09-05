@section('title', 'Administradores')
@extends('layouts.default')

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;">Usuário</a></li>
	</ol>

	<h1 class="page-header">Usuários</h1>

	<div class="row">
		<div style="width: 100vw">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Lista de Usuários</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				@include('controle.includes.alert.mensagem')
				<div class="panel-body">
					<div class="btn-group mr-5">
                        <div class="d-flex align-items-center justify-content-center mr-10 mb-3">
                            <a href="{{ route('controle.usuario.create') }}" class="btn p-l-40 p-r-40 btn-sm label label-green">
                                Cadastrar
                            </a>
                        </div>
                    </div>
					<table id="data-table-combine" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%"></th>
								<th width="1%">Foto</th>
								<th class="text-nowrap">Nome</th>
								<th class="text-nowrap">Grupo</th>
								<th class="text-nowrap">E-mail</th>
								<th class="text-nowrap">Data de cadastro e hora</th>
								<th class="text-nowrap">Opções</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($usuarios as $key => $usuario)
                            <tr class="odd gradeX">
                                <td>{{ 1+$key }}</td>
                                <td width="1%"><img src="/assets/img/user/user-12.jpg" class="img-rounded height-30" /></td>
                                <td>{{ $usuario->name}}</td>

								<td>
									@foreach ( $usuario->roles as $role )
										{{ $role->name }}
									@endforeach
								</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('controle.usuario.edit', $usuario->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                        Editar
                                    </a>

                                    <a href="{{ route('controle.usuario.delete', $usuario->id) }}"
                                        data-url="{{ route('controle.usuario.delete', $usuario->id) }}"
                                        class="btn btn-danger btn-sm atencao">
                                        <i class="fa fa-trash-alt"></i>
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
