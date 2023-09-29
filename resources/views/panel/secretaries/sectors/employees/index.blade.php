@extends('panel.index')
@section('pageTitle', 'Funcionários')
@section('breadcrumb')
<li><a href="{{ route('sectors.index') }}">Setores</a></li>
<li><span>Funcionários</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('sectors.employees.create', $sector->slug) }}" class="btn-default">Novo</a>
            <a href="{{ route('sectors.employees.create2', $sector->slug) }}" class="btn-default">Atualizar lista</a>
        </div>

        @if($employees && $employees->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employeeContent)
                    <tr>
                        <td>{{ $employeeContent->employee->id }}</td>                        
                        <td>
                            @if($employeeContent->employee->files && $employeeContent->employee->files->count() > 0)
                            <img class="image-table" src="{{ asset('storage/'.$employeeContent->employee->files[0]->file->url) }}" />
                            @endif
                        </td>
                        <td>{{ $employeeContent->employee->name }}</td>
                        <td>{{ $employeeContent->employee->office->office }}</td>
                        <td>{{ $employeeContent->employee->employment_type }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-table-options btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __($employeeContent->employee->status) }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Active')">Ativo</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Inactive')">Inativo</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Suspended')">Suspenso</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'On Leave')">Em licença</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Terminated')">Demitido</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Retired')">Aposentado</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Transferred')">Transferido</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'In Training')">Em treinamento</a>
                                    <a class="dropdown-item" href="#" onclick="sendNewStatus(event, 'change-satus-{{$employeeContent->employee->id}}', 'Hiring Process')">Em processo de contratação</a>
                                </div>
                            </div>

                            <form id="change-satus-{{$employeeContent->employee->id}}" action="{{ route('sectors.employee.changeStatus', ['sector' => $sector->slug, 'id' => $employeeContent->employee->id])}}" method="post" style="display: none;">@csrf</form>

                        </td>
                        <td class="actions text-right">
                            <a href="{{ route('sectors.employees.edit', ['sector' => $sector->slug, 'id' => $employeeContent->id]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$employeeContent->employee->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$employeeContent->employee->id}}" class="modal fade modal-warning" role="dialog">
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
                                            <span class="message">Você realmente remover este usuário deste setor?<br> Esta ação não poderá ser desfeita.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $employeeContent->employee->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $employeeContent->employee->id }}" action="{{ route('sectors.employees.destroy', ['sector' => $sector->slug, 'id' => $employeeContent->employee->id]) }}" method="post" style="display: none;">
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
            <span>Ainda não existem funcionários cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
<script>
    function sendNewStatus(e, form, value) {
        e.preventDefault();
        const currentForm = document.getElementById(form);
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'status';
        input.value = value;

        currentForm.appendChild(input);
        currentForm.submit();
    }
</script>
@endsection