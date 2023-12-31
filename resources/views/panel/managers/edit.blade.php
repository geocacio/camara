@extends('panel.index')
@section('pageTitle', 'Atualizar Gestor')

@section('breadcrumb')
<li><a href="{{ route('managers.index') }}">Gestores</a></li>
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
        <form action="{{ route('managers.update', $manager->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $manager->name) }}" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data de início</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $manager->start_date) }}" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Data de fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $manager->end_date) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Selecione o Cargo</label>
                <select name="office" class="form-control">
                    <option value="Prefeito">Prefeito</option>
                    <option value="Vice-prefeito">Vice-prefeito</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $manager->facebook) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $manager->instagram) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Biografia</label>
                <textarea name="biography" class="form-control">{{ old('biography', $manager->biography) }}</textarea>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Imagem do Gestor</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($manager->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$manager->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$manager->files[0]->file->id}}')">
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