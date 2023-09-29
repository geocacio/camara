@extends('panel.index')

@section('pageTitle', 'Atualizar Serviço')

@section('breadcrumb')
<li><a href="{{ route('external-links.index') }}">Serviços externos</a></li>
<li><span>Atualizar Serviço</span></li>
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

        <form action="{{ route('external-links.update', $external_link->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon', $external_link->icon) }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $external_link->title) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="title1">Selecione o Grupo</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id}}" {{ $group->id == $external_link->groupContents->transparency_group_id ? 'selected' : ''}}>{{ $group->title }} - {{ Str::limit($group->description, 71, '...') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>URL</label>
                <input type="url" name="url" class="form-control" value="{{ old('url', $external_link->url) }}" />
            </div>

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" {{ $external_link->visibility == 'enabled' ? 'checked' : ''}}>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $external_link->description) }}</textarea>
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