@extends('panel.index')
@section('pageTitle', 'Vereadores')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right header-with-search">

            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('councilors.page') }}">Página</a>
                    <a class="dropdown-item" href="{{ route('councilors.create') }}">Novo</a>
                    <a class="dropdown-item" href="{{ route('subcategories.index', 'vinculo') }}">Vínculos</a>
                </div>
            </div>
        
        </div>


        @if($councilors && $councilors->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($councilors as $councilor)
                    <tr>
                        <td>{{ $councilor->id }}</td>
                        <td>
                            @if($councilor->files->count() > 0)
                            <img class="image-table" src="{{ asset('storage/'.$councilor->files[0]->file->url) }}" />
                            @endif
                        </td>
                        <td>{{ $councilor->name }}</td>
                        <td>{{ $councilor->email }}</td>
                        <td>{{ $councilor->phone }}</td>
                        <td class="actions text-center">
                            <div class="btn-group dropleft">
                                <a class="link create" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-gear"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('councilor.legislature.index', $councilor->slug) }}">Legislaturas</a>
                                    <a class="dropdown-item" href="{{ route('councilor-commissions.index', $councilor->slug) }}">Comissões</a>
                                    <a class="dropdown-item" href="{{ route('councilors.edit', $councilor->slug) }}">Editar</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal-{{$councilor->id}}" href="#">Excluir</a>
                                </div>

                                <div id="myModal-{{$councilor->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{$councilor->id}}').submit();">
                                                    Deletar
                                                </a>

                                                <form id="delete-form-{{$councilor->id}}" action="{{ route('councilors.destroy', $councilor->slug) }}" method="post" style="display: none;">
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
            <span>Ainda não existem Vereadores cadastrados.</span>
        </div>
        @endif

    </div>
    
</div>
@endsection

@section('js')
@endsection