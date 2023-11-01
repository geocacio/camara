@extends('panel.index')
@section('pageTitle', 'Nova publicação')

@section('breadcrumb')
<li><a href="{{ route('all-publications.index') }}">Publicações</a></li>
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
        <form action="{{ route('all-publications.update', $publication->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o grupo</label>
                        <select name="group_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($groups->children as $group)
                            <option value="{{ $group->id}}" {{ $group->id == $publication->group_id ? 'selected' : '' }}>{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{ $type->id == $publication->type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione a competência</label>
                        <select name="competency_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($competencies->children as $competency)
                            <option value="{{ $competency->id}}" {{ $competency->id == $publication->competency_id ? 'selected' : '' }}>{{ $competency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione a Secretaria</label>
                        <select name="secretary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($secretaries as $secretary)
                            <option value="{{ $secretary->id}}" {{ $secretary->id == $publication->secretary_id ? 'selected' : '' }}>{{ $secretary->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}" {{ $exercicy->id == $publication->exercicy_id ? 'selected' : '' }}>{{ $exercicy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="number" class="form-control" value="{{ old('number', $publication->number) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $publication->title) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $publication->description) }}" />
            </div>

            <!-- <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
            </div> -->

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" {{ $publication->visibility == 'enabled' ? 'checked' : ''}}>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
                </div>
                <div class="col-6 pt-30 container-all-files">
                    @if ($publication->files->count() > 0)
                        @if (in_array(pathinfo($publication->files[0]->file->url, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx']))
                            <div class="container-file">
                                <a href="#" class="btn btn-link" data-toggle="modal" data-target="#file-publication">{{ pathinfo($publication->files[0]->file->url, PATHINFO_FILENAME) }}</a>
                                <button class="btn-delete" onclick="deleteFile(event, 'container-file', '/panel/files/{{$publication->files[0]->file->id}}')">
                                    <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                    </svg>
                                </button>
                            </div>
                        @elseif (in_array(pathinfo($publication->files[0]->file->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']))
                            <div class="conatiner-temp-image mt-3 {{ $files->count() <= 0 ? 'hide' : ''}}">
                                <img class="image" src="{{ asset('storage/'.$publication->files[0]->file->url) }}" />
                                <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$publication->files[0]->file->id}}')">
                                    <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <div class="modal fade modal-preview-file" id="file-publication" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if (pathinfo($publication->files[0]->file->url, PATHINFO_EXTENSION) === 'pdf')
                                        <embed src="{{ asset('storage/'.$publication->files[0]->file->url) }}" width="100%" height="500px" type="application/pdf">
                                        @elseif (in_array(pathinfo($publication->files[0]->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$publication->files[0]->file->url)) }}" width="100%" height="500px"></iframe>
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