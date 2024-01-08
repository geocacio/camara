@extends('panel.index')

@section('pageTitle', 'Novo Funcionário')
@section('breadcrumb')
<li><a href="{{ route('employees.index') }}">Funcionários</a></li>
<li><span>Novo Funcionário</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif

        <form action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o cargo</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($offices as $office)
                            <option value="{{$office->id}}">{{$office->office}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CPF</label>
                        <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dependentes</label>
                        <input type="number" name="dependents" class="form-control" value="{{ old('dependents') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data de admissão</label>
                        <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date') }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Tipo de emprego</label>
                        <select name="employment_type" class="form-control">
                            <option value="Permanent">Efetivo</option>
                            <option value="Temporary">Temporario</option>
                            <option value="Contractor">Terceirizado</option>
                            <option value="Intern">Estagiário</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Status</label>
                        <select name="status" class="form-control">
                            <option value="Active">Ativo</option>
                            <option value="Inactive">Inativo</option>
                            <option value="Suspended">Suspenso</option>
                            <option value="On Leave">Em licença</option>
                            <option value="Terminated">Demitido</option>
                            <option value="Retired">Aposentado</option>
                            <option value="Transferred">Transferido</option>
                            <option value="In Training">Em treinamento</option>
                            <option value="Hiring Process">Em processo de contratação</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="secretary">Secretária</label>
                        <select name="secretary_id" class="form-control">
                            <option value="Active">Selecione</option>
                            @foreach($secretaries as $secretary)
                                <option value="{{ $secretary->id }}">{{ $secretary->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Imagem do Funcionário</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
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

@include('panel.scripts')

@endsection