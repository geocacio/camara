@extends('panel.index')
@section('pageTitle', 'Atualizar link')

@section('breadcrumb')
<li><a href="{{ route('links.index') }}">Links</a></li>
<li><span>Atualizar link</span></li>
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

        <form method="post" action="{{ route('links.update', $link->slug) }}">
            {{ csrf_field() }}
            @method('put')
            <div class="form-group">
                <label class="cursor-pointer" for="toggle">Ativar/Desativar</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="toggle" name="visibility" value="{{ $link->visibility }}" class="toggle-input" {{ $link->visibility === 'enabled' ? 'checked' : '' }}>
                    <label for="toggle" class="toggle-label"></label>
                </div>
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control icon" value="{{ old('name', $link->name) }}">
            </div>

            <div class="form-group">
                <label>Ícone</label>
                <input type="text" name="icon" class="form-control icon" value="{{ old('icon', $link->icon) }}" onfocus="getIconInputValues(event)">
            </div>

            <div class="form-group">
                <label for="title1">Tipo</label>
                <select id="select_type" name="type" class="form-control">
                    @if($link->target_type == 'page')
                    <option value="page">Página</option>
                    @else
                    <option value="link" {{ $link->type == 'link' ? 'selected' : '' }}>Link</option>
                    <option value="dropdown" {{ $link->type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                    @endif
                </select>
            </div>

            @if($menus && $menus->count() > 0)
            <div class="form-group">
                <label for="title1">Menu (opcional)</label>
                <select name="menus[]" class="form-control" multiple>
                    <option>Nenhum</option>
                    @foreach($menus as $menu)
                    <option value="{{ $menu->id }}" {{ in_array( $link->id, array_column($menu->links->toArray(), 'id') ) ? 'selected' : '' }}>{{ $menu->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group" style="display: {{ $link->type == 'dropdown' ? 'block' : 'none' }}">
                <label for="title1">Selecione os links do dropdown</label>
                <select id="select_links" name="parent[]" class="form-control" multiple>
                    @foreach($links as $value)
                    <option value="{{ $value['id'] }}" {{ in_array($value['id'], $dropdown) ? 'selected' : '' }}>{{ $value['name'] ? $value['name'] : $value['icon'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Url</label>
                <input type="url" name="url" class="form-control icon" value="{{ old('url', $link->url ? $link->url : $link->slug) }}" {{ !$link->url ? 'disabled' : ''}}>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('select_type');
        const parentSelect = document.getElementById('select_links');
        const url = document.querySelector('[type="url"]');
        const datadropdown = typeSelect.value == 'dropdown' ? url.value : '';
        const dataLink = typeSelect.value == 'link' ? url.value : '';

        typeSelect.addEventListener('change', function() {
            if (typeSelect.value == 'dropdown') {
                parentSelect.closest('.form-group').style.display = 'block';
                url.disabled = true;
                url.value = datadropdown;
            } else {
                parentSelect.closest('.form-group').style.display = 'none';
                url.closest('.form-group').style.display = 'block';
                url.disabled = false;
                url.value = dataLink;
            }
        });
    });
</script>
@endsection