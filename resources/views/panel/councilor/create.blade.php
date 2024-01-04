@extends('panel.index')
@section('pageTitle', 'Novo Vereador')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
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
        <form action="{{ route('councilors.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Apelido</label>
                        <input type="text" name="surname" class="form-control" value="{{ old('surname') }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="phone" name="phone" class="form-control mask-phone" value="{{ old('phone') }}"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data de Nascimento</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Naturalidade</label>
                        <input type="text" name="naturalness" class="form-control" value="{{ old('naturalness') }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="party_affiliation_id">Filiação partidária</label>
                        <select name="party_affiliation_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($affiliations as $affiliation)
                            <option value="{{ $affiliation->id }}">{{ $affiliation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data da filiação</label>
                        <input type="date" name="affiliation_date" class="form-control" value="{{ old('affiliation_date') }}" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Biografia</label>
                <textarea name="biography" class="form-control">{{ old('biography') }}</textarea>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Foto do Vereador</label>
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