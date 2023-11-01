@extends('panel.index')
@section('pageTitle', 'Departamentos')

@section('content')
<div class="card">
    <div class="card-body">

    @include(
    'panel.partials.headerCardWithSearch',
    ['withSearch' => true,
    'routerSearch' => 'departments.index',
    'clearRouterSearch' => ['route' => 'departments.index', 'params' => ['search' => '', 'perPage' => $perPage]],
    'routerNew' => 'departments.create'])

        @if($departments && $departments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Secretaria</th>
                        <th>Orgão</th>
                        <th>Responsável</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->id }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->secretary->name }}</td>
                        <td>{{ $department->organ ? $department->organ->name : ''}}</td>
                        <td>{{ $department->employee ? $department->employee->employee->name : '' }}</td>
                        <td class="actions">
                            <a href="{{ route('departments.edit', $department->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$department->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$department->id}}" class="modal fade modal-warning" role="dialog">
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
                                            @if($department->sectors->count() > 0)
                                            <div class="alert alert-danger text-center">Ao apagar este departamento todos os setores deste departamento também serão apagados!</div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $department->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $department->id }}" action="{{ route('departments.destroy', $department->slug) }}" method="post" style="display: none;">
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
            <span>{{ $search != '' ? 'Nenhum resultado encontrado' : 'Ainda não existem departamentos cadastrados.' }}</span>
        </div>
        @endif

    </div>

    @include('panel.partials.footerCardWithPagination', ['routePerPage' => 'departments.index', 'paginate' => $departments])

</div>
@endsection

@section('js')
@endsection