@extends('panel.index')
@section('pageTitle', 'Progressos')

@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><span>Progressos</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('biddings.progress.create', $bidding->slug) }}" class="btn-default">Novo</a>
        </div>

        @if($progress && $progress->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Progresso</th>
                        <th>Data e hora</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progress as $pro)
                    <tr>
                        <td>{{ $pro->id }}</td>
                        <td>{{ $pro->title }}</td>
                        <td>{{ $pro->datetime }}</td>
                        <td class="actions text-right">
                            <a href="{{ route('biddings.progress.edit', ['progress' => $pro->slug, 'bidding' => $bidding->slug]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$pro->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$pro->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $pro->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $pro->id }}" action="{{ route('biddings.progress.destroy', ['progress' => $pro->slug, 'bidding' => $bidding->slug]) }}" method="post" style="display: none;">
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
            <span>Ainda não existem Progressos cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
@endsection