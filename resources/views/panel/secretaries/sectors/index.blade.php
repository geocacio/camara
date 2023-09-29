@extends('panel.index')
@section('pageTitle', 'Setores')

@section('content')
<div class="card">
    <div class="card-body no-padding-bottom">

        @include('panel.partials.headerCardWithSearch', ['withSearch' => true, 'routerSearch' => 'sectors.index', 'clearRouterSearch' => ['route' => 'sectors.index', 'params' => ['search' => '', 'perPage' => $perPage]], 'routerNew' => 'sectors.create'])

        @if($sectors && $sectors->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped no-margin-bottom table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Secretaria</th>
                        <th>Orgão</th>
                        <th>Departamento</th>
                        <th>Responsável</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sectors as $sector)
                    <tr>
                        <td>{{ $sector->id }}</td>
                        <td>{{ $sector->name }}</td>
                        <td>{{ $sector->department->secretary->name }}</td>
                        <td>{{ $sector->department->organ ? $sector->department->organ->name : '' }}</td>
                        <td>{{ $sector->department->name }}</td>
                        <td>{{ $sector->responsible && $sector->responsible->employee->name ? $sector->responsible->employee->name : '' }}</td>
                        <td class="actions text-right">
                            <div class="dropdown">
                                <button class="btn btn-table-options btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opções
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('sectors.employees.index', $sector->slug) }}">Funcionários</a>
                                    <a class="dropdown-item" href="{{ route('sectors.edit', $sector->slug) }}">Editar</a>
                                    <a data-toggle="modal" data-target="#myModal{{$sector->id}}" class="dropdown-item cursor-pointer">Excluir</a>
                                </div>
                            </div>

                            <div id="myModal{{$sector->id}}" class="modal fade modal-warning" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <span class="icon" data-v-988dbcee=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon" data-v-988dbcee="">
                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" data-v-988dbcee=""></polygon>
                                                    <line x1="12" y1="8" x2="12" y2="12" data-v-988dbcee=""></line>
                                                    <line x1="12" y1="16" x2="12.01" y2="16" data-v-988dbcee=""></line>
                                                </svg></span>
                                            <span class="title">Você tem certeza?</span>
                                            <span class="message">Você realmente quer apagar este item?<br> Esta ação não poderá ser desfeita.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $sector->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $sector->id }}" action="{{ route('sectors.destroy', $sector->slug) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>{{ $search != '' ? 'Nenhum resultado encontrado' : 'Ainda não existem Setores cadastrados.' }}</span>
        </div>
        @endif

    </div>
    
    @include('panel.partials.footerCardWithPagination', ['routePerPage' => 'sectors.index', 'paginate' => $sectors])

</div>
@endsection

@section('js')
@endsection