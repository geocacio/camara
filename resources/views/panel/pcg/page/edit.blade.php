@extends('panel.index')
@section('pageTitle', 'Página de PCG')

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
        <form action="{{ route('pcg.page.update', $pcgPage->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon', $pcgPage->icon) }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title', $pcgPage->main_title) }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" value="{{ old('title', $pcgPage->title) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Text</label>
                <input type="text" name="description" class="form-control" autocomplete="off" value="{{ old('description', $pcgPage->description) }}">
            </div>

            <div class="form-group">
                <label>Grupo (onde será exibido no portal da transparência)</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione o grupo</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $pcgPage->groupContents && $pcgPage->groupContents->transparency_group_id && $group->id == $pcgPage->groupContents->transparency_group_id ? 'selected' : '' }}>{{ $group->title }} - {{ $group->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label>Tipo de link</label>
                        <select name="link_type" id="link_type" class="form-control">
                            <option value="">Selecione se o link é Interno ou Externo</option>
                            <option value="internal" {{ old('link_type', $pcgPage->link_type) == 'internal' ? 'selected' : '' }}>Interno</option>
                            <option value="external" {{ old('link_type', $pcgPage->link_type) == 'external' ? 'selected' : '' }}>Externo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md" id="external_link_div" @if($pcgPage->link_type == ''  || $pcgPage->link_type == 'internal') style="display: none;"@endif>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="url" class="form-control" autocomplete="off" value="{{ old('link', $pcgPage->url) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" {{ $pcgPage->visibility == 'enabled' ? 'checked' : ''}}>
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

@endsection