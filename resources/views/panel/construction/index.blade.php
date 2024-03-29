@extends('panel.index')
@section('pageTitle', 'Obras')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right">
            
            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('constructions.page') }}">Página</a>
                    <a class="dropdown-item" href="{{ route('constructions.create') }}">Novo</a>
                    <a class="dropdown-item" href="{{ route('subtypes.index', 'constructions') }}">Tipos</a>
                    <a class="dropdown-item" href="{{ route('no-construction.create') }}">Não há obras</a>
                </div>
            </div>
        
        </div>


        @if($constructions && $constructions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Data</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($constructions as $construction)
                    <tr>
                        <td>{{ $construction->id }}</td>
                        <td>{{ Str::limit($construction->title, 30, '...') }}</td>
                        <td>{{ Str::limit($construction->description, 50, '...') }}</td>
                        <td>{{ $construction->date }}</td>
                        <td class="actions text-center">
                            <div class="btn-group dropleft">
                                <a class="link create" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('measurements.index', $construction->slug) }}">Medições</a>
                                    <a class="dropdown-item" href="{{ route('art.index', $construction->slug) }}">ART</a>
                                    <a class="dropdown-item" href="{{ route('constructions.contracts.index', $construction->slug) }}">Contratos</a>
                                    <a class="dropdown-item" href="{{ route('constructions.progress.index', $construction->slug) }}">Andamentos</a>
                                    <a class="dropdown-item" href="{{ route('constructions.file.index', $construction->slug) }}">Arquivos</a>
                                    <a class="dropdown-item" href="{{ route('constructions.edit', $construction->slug) }}">Editar</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal-{{ $construction->id }}" href="#">Excluir</a>
                                </div>

                                <div id="myModal-{{ $construction->id }}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $construction->id }}').submit();">
                                                    Deletar
                                                </a>

                                                <form id="delete-form-{{ $construction->id }}" action="{{ route('constructions.destroy', $construction->slug) }}" method="post" style="display: none;">
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
            <span>Ainda não existem constuções cadastradas.</span>
        </div>
        @endif

    </div>
    
</div>
@endsection

@section('js')
@endsection