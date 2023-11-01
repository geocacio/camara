@extends('panel.index')

@section('pageTitle', 'Atualizar contrato')
@section('breadcrumb')
<li><a href="{{ route('biddings.company.contracts.index', $bidding->slug) }}">Contratos</a></li>
<li><span>Atualizar contrato</span></li>
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

        <form action="{{ route('biddings.company.contracts.update', ['bidding' => $bidding->slug, 'id' => $contract->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            @if($contract)
            <input type="hidden" name="parent_id" value="{{$contract->parent_id}}">
            @endif

            <div class="row">                
                <input type="hidden" name="company_id" value="{{$bidding->company->id}}">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Tipo de contrato</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{$type->id == $contract->types[0]->id ? 'selected' : ''}}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="number" name="number" class="form-control" value="{{ old('number', $contract->number) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $contract->start_date) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $contract->end_date) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Valor total</label>
                <input type="text" name="total_value" class="form-control mask-currency" value="{{ old('total_value', $contract->total_value ? number_format($contract->total_value / 100, 2, ',', '.') : '') }}" />
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