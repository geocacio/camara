@extends('panel.index')
@section('pageTitle', 'Editar ATA de Registro de Preço')

@section('breadcrumb')
    <li><a href="{{ route('register-price.index') }}">Registro de Preço</a></li>
    <li><span>Editar</span></li>
@endsection

@section('content')
    <div class="card">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('register-price.update', $register_price->slug) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data de assinatura</label>
                            <input type="date" name="signature_date" class="form-control" value="{{ old('signature_date', $register_price->signature_date) }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data de Validade</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $register_price->expiry_date) }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Exercício</label>
                            <select name="exercicio_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach($exercicies[0]->children as $exercicie)
                                    <option value="{{ $exercicie->id }}" {{ $exercicie->id == $register_price->exercicio_id ? 'selected' : '' }}>
                                        {{ $exercicie->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title1">Credor</label>
                            <select name="company_id" class="form-control">
                                <option value="">Selecione</option>
                                @foreach($bidding->companies as $company)
                                    <option value="{{ $company->id }}" {{ $company->id == $register_price->company_id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Objeto</label>
                            <textarea name="object" class="form-control">{{ old('object', $register_price->object) }}</textarea>
                        </div>
                    </div>      
                </div>

                <div class="form-group">
                    <label for="file">Arquivo</label>
                    <input type="file" id="file" name="file" class="form-control">
                    @if ($register_price->files && $register_price->files[0]->file)
                        <b>Arquivo atual: {{ $register_price->files[0]->file->name }}</b>
                    @endif
                </div>
                

                <div class="form-footer text-right">
                    <button type="submit" class="btn-submit-default">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    @include('panel.scripts')
@endsection
