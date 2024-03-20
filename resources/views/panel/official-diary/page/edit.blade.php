@extends('panel.index')
@section('pageTitle', 'Página de Diário')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        <li>{{ $errors->first() }}</li>
    </ul>
</div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('journal.page.update', $outsource->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon', $outsource->icon) }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title', $outsource->main_title) }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" value="{{ old('title', $outsource->title) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea type="text" name="description" class="form-control" autocomplete="off">{{ old('description', $outsource->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Grupo (onde será exibido no portal da transparência)</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione o grupo</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $outsource->groupContents && $outsource->groupContents->transparency_group_id && $group->id == $outsource->groupContents->transparency_group_id ? 'selected' : '' }}>{{ $group->title }} - {{ $group->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea id="editor" name="featured_description">{{ old('featured_description', $outsource->featured_description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" {{ $outsource->visibility == 'enabled' ? 'checked' : ''}}>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade modal-icon-list" id="modalIconList" tabindex="-1" role="dialog" aria-labelledby="iconListModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="iconListModalTitle">Escolha seu ícone</h5>
                <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('panel.partials.iconLists')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#editor').summernote({
        placeholder: '',
        tabsize: 2,
        height: 100 
    });
});
</script>

@endsection