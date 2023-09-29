@extends('panel.index')
@section('pageTitle', 'Atualiza Vereador')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><span>Atualiza</span></li>
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
        <form action="#" method="post" enctype="multipart/form-data">
            @csrf
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
                        <label for="current_position">Cargo Atual</label>
                        <select name="current_position" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">Vice Presidente</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_bond">Vínculo atual</label>
                        <select name="current_bond" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">option</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Inicio do mandato</label>
                        <input type="date" name="start_mandate" class="form-control" value="{{ old('start_mandate', $councilor->start_mandate) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fim do mandato</label>
                        <input type="date" name="end_mandate" class="form-control" value="{{ old('end_mandate', $councilor->end_mandate) }}" />
                    </div>
                </div>
                <div class="col-md-4">
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