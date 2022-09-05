@php
$sidebarClass = !empty($sidebarTransparent) ? 'sidebar-transparent' : '';
@endphp

<style>
    .page-sidebar-minified .sidebar-minify-btn i:before {
        content: '\f101' !important;
    }

</style>

<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile"
                style="background-image: url({{ asset('storage/background_image/' . $config->config['layout']['background_image']) }})">
                <a href="{{ route('dashboard') }}">
                    <div class="image">
                        @if (isset(Auth::user()->imagem))
                            <img src="{{ route('imagem.render', 'user/p/' . Auth::user()->imagem) }}"
                                alt="{{ Auth::user()->name }}" />
                        @else
                            <img src="{{ asset('assets/img/user/user-12.jpg') }}" alt="" />
                        @endif
                    </div>
                    <div class="info">
                        {{ Auth::user()->name }}
                    </div>
                </a>
            </li>
        </ul>

        <ul class="nav">
            <li class="nav-header">Navegação</li>


            <li class="has-sub {{ strpos(Route::currentRouteName(), 'bredidashboard::dashboard') === 0 ? 'active' : '' }}">
                <a href="{{ route('bredidashboard::dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>



            @can('Alterar feriado')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.feriados.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.feriados.index') }}">
                        <i class="fas fa-glass-cheers"></i>
                        <span>Feriados</span>
                    </a>
                </li>
            @endcan

            @can('Alterar bloco')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.bloco.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.bloco.index') }}">
                        <i class="fas fa-hotel"></i>
                        <span>Bloco</span>
                    </a>
                </li>
            @endcan

            @can('Alterar sala')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.salas.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.salas.index') }}">
                        <i class="fas fa-school"></i>
                        <span>Salas</span>
                    </a>
                </li>
            @endcan

            @can('Alterar professor')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.professor.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.professor.index') }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Professores</span>
                    </a>
                </li>
            @endcan

            @can('Alterar agendamento tipo')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.tipos.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.tipos.index') }}">
                        <i class="fas fa-bookmark"></i>
                        <span>Tipos de agendamento</span>
                    </a>
                </li>
            @endcan

            @can('Alterar homologacao')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.homologacao.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.homologacao.index') }}">
                        <i class="fas fa-check-square"></i>
                        <span>Homologação</span>
                    </a>
                </li>
            @endcan

            @can('Visualizar agendamento')
                <li
                    class="has-sub {{ strpos(Route::currentRouteName(), 'controle.agendamentos.') === 0 || strpos(Route::currentRouteName(), 'controle.calendario.') === 0 ? 'active' : '' }}">
                    <a href="javascript:;">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Atividades</span>
                    </a>
                    <ul class="sub-menu">
                        <li
                            class="has-sub {{ strpos(Route::currentRouteName(), 'controle.agendamentos.calendario') === 0 ? 'active' : '' }}">
                            <a href="{{ route('controle.agendamentos.calendario') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Calendário</span>
                            </a>
                        </li>
                        <li
                            class="has-sub {{ strpos(Route::currentRouteName(), 'controle.agendamentos.index') === 0 || strpos(Route::currentRouteName(), 'controle.agendamentos.create') === 0 ? 'active' : '' }}">
                            <a href="{{ route('controle.agendamentos.index') }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Agendamentos</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('Visualizar usuário')
                <li
                    class="has-sub {{ strpos(Route::currentRouteName(), 'controle.usuario.') === 0 || strpos(Route::currentRouteName(), 'controle.roles.') === 0 ? 'active' : '' }}">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-lock"></i>
                        <span>Controle de Acesso</span>
                    </a>
                    <ul class="sub-menu">
                        <li
                            class="has-sub {{ strpos(Route::currentRouteName(), 'controle.usuario.') === 0 ? 'active' : '' }}">
                            <a href="{{ route('controle.usuario.index') }}">
                                <i class="fas fa-user"></i>
                                <span>Usuários</span>
                            </a>
                        </li>
                        <li
                            class="has-sub {{ strpos(Route::currentRouteName(), 'controle.roles.') === 0 ? 'active' : '' }}">
                            <a href="{{ route('controle.roles.index') }}">
                                <i class="fas fa-user-friends"></i>
                                <span>Grupo de usuários</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('Alterar config')
                <li class="has-sub {{ strpos(Route::currentRouteName(), 'controle.config.') === 0 ? 'active' : '' }}">
                    <a href="{{ route('controle.config.edit') }}">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
            @endcan

            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a></li>
        </ul>
    </div>
</div>
