@extends('panel.index')
@section('pageTitle', 'Destinatários')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><span>Destinatários</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right header-with-search">
            <a href="{{ route('recipients.create', $material->slug) }}" class="btn-default">Novo</a>
        </div>


        @if($material->recipients && $material->recipients->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Posição</th>
                        <th>Organização</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($material->recipients as $recipient)
                    <tr>
                        <td>{{ $recipient->id}}</td>
                        <td>{{ $recipient->name}}</td>
                        <td>{{ $recipient->position}}</td>
                        <td>{{ $recipient->organization}}</td>
                        <td class="actions">
                            <a href="{{ route('recipients.edit', ['material' => $material->slug,'recipient' => $recipient->slug]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal-{{$recipient->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal-{{$recipient->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{$recipient->id}}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{$recipient->id}}" action="{{ route('recipients.destroy', ['material' => $material->slug,'recipient' => $recipient->slug]) }}" method="post" style="display: none;">
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
            <span>Ainda não existem destinatários cadastrados.</span>
        </div>
        @endif

    </div>
    
</div>
@endsection

@section('js')
@endsection