@extends('panel.index')
@section('pageTitle', 'Veiculos')
@section('breadcrumb')
<li><a href="{{ route('veiculos.index') }}">Veiculos</a></li>
<li><span>Editar Veiculos</span></li>
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
                        <input type="text" name="secretary_id" class="form-control" value="{{ old('secretary_id', $vehicle->secretary_id) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo do veículo</label>
                        <select name="situation" class="form-control">
                            <option value="Ativo" {{ $vehicle->situation == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="Inativo" {{ $vehicle->situation == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            <option value="Quebrado" {{ $vehicle->situation == 'Quebrado' ? 'selected' : '' }}>Quebrado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Modelo</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model', $vehicle->situation) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Marca</label>
                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $vehicle->brand) }}" />
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Placa</label>
                        <input type="text" name="plate" class="form-control" value="{{ old('plate', $vehicle->plate) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ano do veículo</label>
                        <input type="text" name="year" class="form-control" value="{{ old('year', $vehicle->year) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Veículo doação</label>
                        <select name="donation" class="form-control">
                            <option value="Sim" {{ $vehicle->donation == 'Sim' ? 'selected' : '' }}>Sim</option>
                            <option value="Não" {{ $vehicle->donation == 'Não' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo do veículo</label>
                        <select name="type" class="form-control">
                            <option value="Própio" {{ $vehicle->type == 'Própio' ? 'selected' : '' }}>Própio</option>
                            <option value="Locado" {{ $vehicle->type == 'Locado' ? 'selected' : '' }}>Locado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Finalidade do veículo</label>
                <input type="text" name="purpose_vehicle" class="form-control" value="{{ old('purpose_vehicle', $vehicle->purpose_vehicle) }}" />
            </div>
            
            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection