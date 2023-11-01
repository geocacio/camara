@extends('panel.index')

@section('pageTitle', 'Atualizar contrato')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Convênios</a></li>
<li><a href="{{ route('constructions.contracts.index', $construction->slug) }}">Contratos</a></li>
<li><span>Atualizar</span></li>
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

        <form action="{{ route('constructions.contracts.update', ['construction' => $construction->slug, 'contract' => $contract->slug]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Tipo de contrato</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{ $contract->types[0]->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor total</label>
                        <input type="text" name="total_value" class="form-control mask-currency" value="{{ old('total_value', $contract->total_value) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $contract->start_date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $contract->end_date) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $contract->description) }}</textarea>
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