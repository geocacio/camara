@extends('panel.index')
@section('pageTitle', 'Sessões')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right header-with-search">

            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Página</a>
                    <a class="dropdown-item" href="{{ route('sessions.create') }}">Novo</a>
                    <a class="dropdown-item" href="{{ route('subtypes.index', 'sessions') }}">Tipos</a>
                    <a class="dropdown-item" href="{{ route('subcategories.index', 'status') }}">Status</a>
                </div>
            </div>
        
        </div>


        @if($sessions && $sessions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->id }}</td>
                        <td>{{ date('d/m/Y', strtotime($session->date)) }}</td>
                        <td>{{ $session->status->name }}</td>
                        <td class="actions text-center">
                            <div class="btn-group dropleft">
                                <a class="link create" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('attendances.create', $session->slug) }}">Fazer chamada</a>
                                    <a class="dropdown-item" href="{{ route('sessions.edit', $session->slug) }}">Editar</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal-{{ $session->id }}" href="#">Excluir</a>
                                </div>

                                <div id="myModal-{{ $session->id }}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $session->id }}').submit();">
                                                    Deletar
                                                </a>

                                                <form id="delete-form-{{ $session->id }}" action="{{ route('sessions.destroy', $session->slug) }}" method="post" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
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
            <span>Ainda não existem sessões cadastradas.</span>
        </div>
        @endif

    </div>
    
</div>
@endsection

@section('js')
@endsection