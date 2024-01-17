@extends('panel.index')

@section('pageTitle', 'Novo contrato')
@section('breadcrumb')
<li><a href="{{ route('biddings.company.contracts.index', $bidding->slug) }}">Contratos</a></li>
<li><span>Novo contrato</span></li>
@endsection
@section('content')
<div class="card">

    @if($types->count() <= 0) <div class="alert alert-danger">
        <ul>
            <li>É preciso ter pelo menos um tipo cadastrado! <a href="{{ route('subtypes.create', 'contracts') }}" class="link-alert alert-danger">Criar</a></li>
        </ul>
</div>
@endif

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

    <form action="{{ route('biddings.company.contracts.store', $bidding->slug) }}" method="post" enctype="multipart/form-data">
        @csrf

        @if($contract)
        <input type="hidden" name="parent_id" value="{{$contract->id}}">
        @endif

        <div class="row">
            
            <input type="hidden" name="company_id" value="{{$bidding->company->id}}">

            <div class="col-md-6">
                <div class="form-group">
                    <label>Número</label>
                    <input type="number" name="number" class="form-control" value="{{ old('number') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="title1">Tipo de contrato</label>
                    <select name="type" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                        <option value="">Selecione</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id}}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Data Inicial</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Data Final</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Valor total</label>
            <input type="text" name="total_value" class="form-control mask-currency" value="{{ old('total_value') }}" {{ $types->count() <= 0 ? 'disabled' : ''}} />
        </div>

        <div class="form-group">
            <label>Selecione um fiscal de contrato</label>
            <select name="inspector_id" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>
                <option value="">Selecione</option>
                @foreach ($inspectors as $inspector)
                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                @endforeach

            </select>
        </div>
        

        <div class="form-group">
            <label>Descrição</label>
            <textarea name="description" class="form-control" {{ $types->count() <= 0 ? 'disabled' : ''}}>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="logo">Arquivo</label>
            <input type="file" name="file" accept="application/pdf" class="form-control">
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