@extends('panel.index')
@section('pageTitle', 'Novo link')

@section('breadcrumb')
<li><a href="{{ route('links.index') }}">Links</a></li>
<li><span>Novo link</span></li>
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

        <form method="post" action="{{ route('links.store') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control icon" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Ícone</label>
                <input type="text" name="icon" class="form-control icon" value="{{ old('icon') }}" onfocus="getIconInputValues(event)">
            </div>
            
            <div class="form-group">
                <label for="title1">Tipo</label>
                <select name="type" id="select_type" class="form-control">
                    <option value="link">Link</option>
                    <option value="dropdown">Dropdown</option>
                </select>
            </div>

            @if($menus && $menus->count() > 0)
            <div class="form-group">
                <label for="title1">Menu (opcional)</label>
                <select name="menus[]" class="form-control" multiple>
                    <option selected>Selecione</option>
                    @foreach($menus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-group" style="display: none;">
                <label for="title1">Selecione os links do dropdown</label>
                <select id="select_links" name="parent[]" class="form-control" multiple>
                    @foreach($links as $link)
                    <option value="{{ $link->id }}">{{ $link['name'] ? $link['name'] : $link['icon'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Url</label>
                <input type="url" name="url" class="form-control icon" value="{{ old('url') }}">
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

        typeSelect.addEventListener('change', function() {
            if (typeSelect.value == 'dropdown') {
                parentSelect.closest('.form-group').style.display = 'block';
                url.disabled = true;
            } else {
                parentSelect.closest('.form-group').style.display = 'none';
                url.closest('.form-group').style.display = 'block';
                url.disabled = false;
            }
        });
    });
</script>
@endsection