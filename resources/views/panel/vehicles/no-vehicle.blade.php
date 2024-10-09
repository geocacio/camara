@extends('panel.index')
@section('pageTitle', 'Período sem Veiculos')
@section('breadcrumb')
<li><a href="{{ route('veiculos.index') }}">Veiculos</a></li>
<li><span>Período sem Veiculos</span></li>
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
        
        <form action="{{ route('no-veiculos.update', $info->id ) }}" method="post" enctype="multipart/form-data">
            @csrf
        
            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
                </div>

                <div class="col-6">
                    <label for="logo">Periodo</label>
                    <input type="text" name="periodo" value="{{ $info ? $info->periodo : old('periodo') }}"  class="form-control mask-period">
                </div>

                <div class="col-6 pt-30 container-all-files">
                    @if ($currentFile != null)
                    @if (in_array(pathinfo($currentFile->url, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx']))
                    <div class="container-file">
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#file-{{ $currentFile->id }}">{{ pathinfo($currentFile->url, PATHINFO_FILENAME) }}</a>
                        <button class="btn-delete" onclick="deleteFile(event, 'container-file', '/panel/files/{{$currentFile->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @elseif (in_array(pathinfo($currentFile->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']))
                    <div class="conatiner-temp-image mt-3 {{ $files->count() <= 0 ? 'hide' : ''}}">
                        <img class="image" src="{{ asset('storage/'.$currentFile->url) }}" />
                        <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$currentFile->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @endif

                    <div class="modal fade modal-preview-file" id="file-{{ $currentFile->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($currentFile->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$currentFile->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($currentFile->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$currentFile->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                    <span class="no-file-info">Nenhum arquivo encontrado.</span>
                    @endif
                </div>

            </div>
        
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ $info ? $info->description : old('description') }}</textarea>
            </div>
            
            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
        
    </div>
</div>
@endsection
