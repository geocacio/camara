@extends('panel.index')
@section('pageTitle', 'Fiscais')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right header-with-search">

            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('fiscais.create') }}">Novo</a>
                </div>
            </div>
        </div>


        @if($inspectors && $inspectors->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Data de inicio</th>
                        <th>Data de fim</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspectors as $inspector)
                    
                    <tr>
                        <td>{{ $inspector->name }}</td>
                        <td>{{ $inspector->type }}</td>
                        <td>{{ date('d/m/Y', strtotime($inspector->start_date)) }}</td>
                        <td>@if(!empty($inspector->end_date)) {{ date('d/m/Y', strtotime($inspector->end_date)) }}@endif</td>
                        <td class="actions text-center">
                            <a href="{{ route('fiscais.edit', $inspector->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                        
                            <a data-toggle="modal" data-target="#myModal-{{ $inspector->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                        
                            <div id="myModal-{{$inspector->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $inspector->slug }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $inspector->slug }}" action="{{ route('fiscais.destroy', $inspector->slug) }}" method="post" style="display: none;">
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
            <span>Ainda não existem fiscais cadastrados.</span>
        </div>
        @endif

    </div>
    
</div>
@endsection

@section('js')
@endsection