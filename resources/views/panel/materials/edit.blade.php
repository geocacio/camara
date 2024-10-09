@extends('panel.index')
@section('pageTitle', 'Atualizar Material')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Matérias</a></li>
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
        <form action="{{ route('materials.update', $material->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $material->date) }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types->count() > 0)
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $material->type_id ? 'selected' : ''}}>{{ $type->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="status">Situação</label>
                        <select name="status_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($situations->count() > 0)
                            @foreach($situations as $situation)
                            <option value="{{ $situation->id }}" {{ $situation->id == $material->status_id ? 'selected' : ''}}>{{ $situation->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="councilor_id">Vereador</label>
                        <select name="councilor_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($councilors->count() > 0)
                            @foreach($councilors as $councilor)
                            <option value="{{ $councilor->id }}" {{ $councilor->id == $material->councilor->id ? 'selected' : ''}}>{{ $councilor->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description', $material->description) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
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