@extends('panel.index')
@section('pageTitle', 'Atualizar Vereador')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><span>Atualizar</span></li>
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
        <form action="{{ route('councilors.update', $councilor->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $councilor->name) }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Apelido</label>
                        <input type="text" name="surname" class="form-control" value="{{ old('surname', $councilor->surname) }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $councilor->email) }}"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="phone" name="phone" class="form-control" value="{{ old('phone', $councilor->phone) }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="office_id">Cargo Atual</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id }}" {{ $office->id == $councilor->office_id ? 'selected' : '' }}>{{ $office->office }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bond_id">Vínculo atual</label>
                        <select name="bond_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($bonds->children as $bond)
                            <option value="{{ $bond->id }}" {{ $bond->id == $councilor->bond_id ? 'selected' : '' }}>{{ $bond->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Inicio do vínculo</label>
                        <input type="date" name="start_bond" class="form-control" value="{{ old('start_bond', $councilor->start_bond) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de Nascimento</label>
                        <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $councilor->birth_date) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Biografia</label>
                <textarea name="biography" class="form-control">{{ old('biography', $councilor->biography) }}</textarea>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Foto do Vereador</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($councilor->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$councilor->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$councilor->files[0]->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                        @endif
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