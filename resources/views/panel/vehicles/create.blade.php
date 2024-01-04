@extends('panel.index')
@section('pageTitle', 'Novo Usuário')
@section('breadcrumb')
<li><a href="{{ route('veiculos.index') }}">Usuários</a></li>
<li><span>Novo Usuário</span></li>
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
        
        <form action="{{ route('veiculos.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Secretária</label>
                        <input type="text" name="secretary_id" class="form-control" value="{{ old('secretary_id') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo do veículo</label>
                        <select name="situation" class="form-control">
                            <option value="Ativo" {{ old('situation') == 1 ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ old('situation') == 0 ? 'selected' : '' }}>Inativo</option>
                            <option value="Quebrado" {{ old('situation') == 0 ? 'selected' : '' }}>Quebrado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Modelo</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" />
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Placa</label>
                        <input type="text" name="plate" class="form-control" value="{{ old('plate') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ano do veículo</label>
                        <input type="text" name="year" class="form-control" value="{{ old('year') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Veículo doação</label>
                        <select name="donation" class="form-control">
                            <option value="Sim" {{ old('donation') == 'Sim' ? 'selected' : '' }}>Sim</option>
                            <option value="Não" {{ old('donation') == 'Não' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo do veículo</label>
                        <select name="type" class="form-control">
                            <option value="Própio" {{ old('type') == 'Própio' ? 'selected' : '' }}>Própio</option>
                            <option value="Locado" {{ old('type') == 'Locado' ? 'selected' : '' }}>Locado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Finalidade do veículo</label>
                <input type="text" name="purpose_vehicle" class="form-control" value="{{ old('purpose_vehicle') }}" />
            </div>
            
            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection