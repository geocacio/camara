@extends('panel.index')

@section('pageTitle', 'Atualizar Funcionário')
@section('breadcrumb')
<li><a href="{{ route('employees.index') }}">Funcionários</a></li>
<li><span>Atualizar Funcionário</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('employees.update', $employee->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o cargo</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($offices as $office)
                            <option value="{{$office->id}}" {{ $employee->office->id == $office->id ? 'selected' : ''}}>{{$office->office}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone', $employee->phone) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf', $employee->cpf) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dependentes</label>
                        <input type="number" name="dependents" class="form-control" value="{{ old('dependents', $employee->dependents) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data de admissão</label>
                        <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date', $employee->admission_date) }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Tipo de emprego</label>
                        <select name="employment_type" id="employment_type" class="form-control">
                            <option value="Permanent" {{ $employee->employment_type == 'Permanent' ? 'selected' : '' }}>Efetivo</option>
                            <option value="Temporary" {{ $employee->employment_type == 'Temporary' ? 'selected' : '' }}>Temporario</option>
                            <option value="Contractor" {{ $employee->employment_type == 'Contractor' ? 'selected' : '' }}>Terceirizado</option>
                            <option value="Intern" {{ $employee->employment_type == 'Intern' ? 'selected' : '' }}>Estagiário</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active" {{ $employee->status == 'Active' ? 'selected' : ''}}>Ativo</option>
                            <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : ''}}>Inativo</option>
                            <option value="Suspended" {{ $employee->status == 'Suspended' ? 'selected' : ''}}>Suspenso</option>
                            <option value="On Leave" {{ $employee->status == 'On Leave' ? 'selected' : ''}}>Em licença</option>
                            <option value="Terminated" {{ $employee->status == 'Terminated' ? 'selected' : ''}}>Demitido</option>
                            <option value="Retired" {{ $employee->status == 'Retired' ? 'selected' : ''}}>Aposentado</option>
                            <option value="Transferred" {{ $employee->status == 'Transferred' ? 'selected' : ''}}>Transferido</option>
                            <option value="In Training" {{ $employee->status == 'In Training' ? 'selected' : ''}}>Em treinamento</option>
                            <option value="Hiring Process" {{ $employee->status == 'Hiring Process' ? 'selected' : ''}}>Em processo de contratação</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div @if($employee->employment_type != 'Contractor') style="display: none" @endif class="row" id="terceirizado">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Credor</label>
                        <input type="text" name="credor" class="form-control" value="{{ old('credor', $employee->credor) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número do contrato</label>
                        <input type="number" name="contact_number" class="form-control" value="{{ old('contact_number', $employee->contact_number) }}" />
                    </div>
                </div>
            </div>


            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Imagem do Funcionário</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($employee->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$employee->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$employee->files[0]->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                        @endif
                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script>
    $(document).ready(function() {
        $('.mask-currency').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            precision: 2
        });
        $('.mask-quantity').maskMoney({
            precision: 2,
            thousands: '',
            decimal: '.'
        });
        $('.mask-cnpj').mask('00.000.000/0000-00');
        $('.mask-phone').mask('(00) 0000-0000');
        $('.mask-cep').mask('00000-000');
    });
</script>

@include('panel.scripts')

@endsection