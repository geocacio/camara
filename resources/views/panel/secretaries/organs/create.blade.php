@extends('panel.index')

@section('pageTitle', 'Novo Orgão')
@section('breadcrumb')
<li><a href="{{ route('organs.index') }}">Orgãos</a></li>
<li><span>Novo Orgão</span></li>
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

        <form action="{{ route('organs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Selecione o Responsável</label>
                        <select name="responsible" class="form-control">
                            <option value="">Selecione</option>
                            foreach(responsibles[0]->children as responsible)
                            <option value=" responsible->id"> responsible->name</option>
                            endforeach
                        </select>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Selecione a Secretaria</label>
                        <select name="secretary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($secretaries as $secretary)
                            <option value="{{$secretary->id}}">{{$secretary->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="title1">Selecione o Responsável</label>
                        <select name="employee_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control mask-cnpj" value="{{ old('cnpj') }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone 1</label>
                        <input type="text" name="phone1" class="form-control mask-phone" value="{{ old('phone1') }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone 2</label>
                        <input type="text" name="phone2" class="form-control mask-phone" value="{{ old('phone2') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="zip_code" class="form-control mask-cep" value="{{ old('zip_code') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Horário de atendimento</label>
                        <input type="text" name="business_hours" class="form-control" value="{{ old('business_hours') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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