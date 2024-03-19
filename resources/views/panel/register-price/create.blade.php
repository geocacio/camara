@extends('panel.index')
@section('pageTitle', 'Nova ATA de Registro de Preço')

@section('breadcrumb')
{{-- <li><a href="{{ route('register-price.index') }}">Registro de Preço</a></li> --}}
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        <li>{{ $errors->first() }}</li>
    </ul>
</div>
@endif

<div class="card-body">
    <form action="{{ route('register-price.store', $bidding->slug) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Data de Validade</label>
                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Exercício</label>
                    <select name="exercicio_id" class="form-control">
                        <option value="">Selecione</option>
                        @foreach($exercicies[0]->children as $exercicie)
                            <option value="{{ $exercicie->id}}">{{ $exercicie->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Data de assinatura</label>
                    <input type="date" name="signature_date" class="form-control" value="{{ old('signature_date') }}" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_id">Credor</label>
                    <select id="company_id" name="company_id" class="form-control">
                        @foreach($bidding->companies as $company)
                            <option value="{{ $company->id }}" data-company="{{ json_encode($bidding->company) }}">
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="file" class="form-control">
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