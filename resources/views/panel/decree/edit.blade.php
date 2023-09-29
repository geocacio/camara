@extends('panel.index')
@section('pageTitle', 'Atualizar Decreto')

@section('breadcrumb')
<li><a href="{{ route('decrees.index') }}">Decretos</a></li>
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
        <form action="{{ route('decrees.update', $decree->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="number" name="number" class="form-control" value="{{ old('number', $decree->number) }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $decree->date) }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="title1">Selecione o Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies[0]->children as $exercicy)
                            <option value="{{ $exercicy->id}}" {{ in_array($exercicy->name, array_column($decreeCategories->toArray(), 'name')) ? 'selected' : '' }}>{{ $exercicy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o tipo</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{$type->id == $decree->types[0]->id ? 'selected' : ''}}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o Grupo</label>
                        <select name="group_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($groups[0]->children as $group)
                            <option value="{{ $group->id}}" {{ in_array($group->name, array_column($decreeCategories->toArray(), 'name')) ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
                </div>
                <div class="col-6 pt-30 container-all-files">
                    @if ($files->count() > 0)
                    @foreach($files as $currentFile)
                    @if (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx']))
                    <div class="container-file">
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#file-{{ $currentFile->file->id }}">{{ pathinfo($currentFile->file->url, PATHINFO_FILENAME) }}</a>
                        <button class="btn-delete" onclick="deleteFile(event, 'container-file', '/panel/files/{{$currentFile->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @elseif (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']))
                    <div class="conatiner-temp-image mt-3 {{ $files->count() <= 0 ? 'hide' : ''}}">
                        <img class="image" src="{{ asset('storage/'.$currentFile->file->url) }}" />
                        <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$currentFile->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @endif

                    <div class="modal fade modal-preview-file" id="file-{{ $currentFile->file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($currentFile->file->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$currentFile->file->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$currentFile->file->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @else
                    <span class="no-file-info">Nenhum arquivo encontrado.</span>
                    @endif
                </div>

            </div>
            
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $decree->description, $decree->description) }}</textarea>
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