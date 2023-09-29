@extends('panel.index')
@section('pageTitle', 'Secretarias')

@section('content')
<div class="card">
    @include(
    'panel.partials.headerCardWithSearch',
    ['withSearch' => true,
    'routerSearch' => 'secretaries.index',
    'clearRouterSearch' => ['route' => 'secretaries.index', 'params' => ['search' => '', 'perPage' => $perPage]],
    'routerNew' => 'secretaries.create'])
    
    <div class="card-body">

        @if($secretaries && $secretaries->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Nome</th>
                        <th>Responsável</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($secretaries as $secretary)
                    <tr>
                        <td>{{ $secretary->id }}</td>
                        <td>
                            @if($secretary->files && $secretary->files->count() > 0)
                            <img class="image-table" src="{{ asset('storage/'.$secretary->files[0]->file->url) }}" />
                            @endif
                        </td>
                        <td>{{ $secretary->name }}</td>
                        <td>{{ $secretary->responsible && $secretary->responsible->employee->name ? $secretary->responsible->employee->name : '' }}</td>
                        <td class="actions">
                            <a href="{{ route('secretaries.edit', $secretary->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$secretary->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$secretary->id}}" class="modal fade modal-warning" role="dialog">
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
                                            @if($secretary->organs->count() > 0)
                                            <div class="alert alert-danger text-center">Ao apagar esta secretaria, todos os orgãos, departamentos e setores desta secretaria também serão apagados!</div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $secretary->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $secretary->id }}" action="{{ route('secretaries.destroy', $secretary->slug) }}" method="post" style="display: none;">
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
            <span>{{ $search != '' ? 'Nenhum resultado encontrado' : 'Ainda não existem secretarias cadastrados.' }} </span>
        </div>
        @endif

    </div>

    @include('panel.partials.footerCardWithPagination', ['routePerPage' => 'secretaries.index', 'paginate' => $secretaries])

</div>
@endsection

@section('js')
@endsection