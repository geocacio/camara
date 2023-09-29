@extends('panel.index')
@section('pageTitle', 'Orgãos')

@section('content')
<div class="card">
    <div class="card-body">

    @include(
    'panel.partials.headerCardWithSearch',
    ['withSearch' => true,
    'routerSearch' => 'organs.index',
    'clearRouterSearch' => ['route' => 'organs.index', 'params' => ['search' => '', 'perPage' => $perPage]],
    'routerNew' => 'organs.create'])

        @if($organs && $organs->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Orgão</th>
                        <th>Secretaria</th>
                        <th>Responsável</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organs as $organ)
                    <tr>
                        <td>{{ $organ->id }}</td>
                        <td>{{ $organ->name }}</td>
                        <td>{{ $organ->secretary->name }}</td>
                        <td>{{ $organ->employee->employee->name }}</td>
                        <td class="actions">
                            <a href="{{ route('organs.edit', $organ->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$organ->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$organ->id}}" class="modal fade modal-warning" role="dialog">
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
                                            @if($organ->departments->count() > 0)
                                            <div class="alert alert-danger text-center">Ao apagar este orgão, todos os departamentos e setores deste orgão também serão apagados!</div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $organ->id }}').submit();">
                                                Deletar
                                            </a>
                                            <form id="delete-form-{{ $organ->id }}" action="{{ route('organs.destroy', $organ->slug) }}" method="post" style="display: none;">
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
            <span>{{ $search != '' ? 'Nenhum resultado encontrado' : 'Ainda não existem Orgãos cadastrados.' }}</span>
        </div>
        @endif

    </div>

    @include('panel.partials.footerCardWithPagination', ['routePerPage' => 'organs.index', 'paginate' => $organs])
</div>
@endsection

@section('js')
@endsection