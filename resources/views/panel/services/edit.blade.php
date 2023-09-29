@extends('panel.index')
@section('pageTitle', 'Novo Serviço')

@section('breadcrumb')
<li><a href="{{ route('services.index') }}">Serviços</a></li>
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

        <form action="{{ route('services.update', $service->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon', $service->icon) }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control title" autocomplete="off" value="{{ old('title', $service->title) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Text</label>
                        <input type="text" name="text" class="form-control text" autocomplete="off" value="{{ old('text', $service->text) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="type" class="form-control" onchange="displayUrl(event)">
                            <option value="">Selecione</option>
                            <option value="internal" {{ $service->type == 'internal' ? 'selected' : '' }}>Interno</option>
                            <option value="external" {{ $service->type == 'external' ? 'selected' : '' }}>Externo</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="{{ $service->type == 'external' ? 'display: block' : 'display: none;' }}">
                    <div class="form-group">
                        <label>Url</label>
                        <input type="url" class="form-control input-url" autocomplete="off" value="{{ old('url', $service->url) }}">
                    </div>
                </div>
                <div class="col-md-6" style="{{ $service->type == 'internal' ? 'display: block' : 'display: none;' }}">
                    <div class="form-group">
                        <label>Url</label>
                        <select class="form-control input-url">
                            <option value="">Selecione</option>
                            @foreach($serviceList as $item)
                            <option value="{{$item->route}}" {{ $item->route == $service->url ? 'selected' : ''}}>{{$item->page}}</option>
                            @endforeach
                        </select>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const getModal = document.getElementById('modalIconList');
        const lists = getModal.querySelectorAll('.list-icons li');
        const btnClose = getModal.querySelector('.close');

        lists.forEach(li => {
            li.addEventListener('click', ({
                target
            }) => {
                const inputName = document.getElementById('modalIconList').getAttribute('inputName');
                const currentInput = document.querySelector('input[name="' + inputName + '"]');
                currentInput.value = target.querySelector('i').className;
                btnClose.click();
            })
        });
    })

    function getIconInputValues({
        target
    }) {
        const getModal = document.getElementById('modalIconList');
        getModal.setAttribute('inputName', target.getAttribute('name'))
        let modal = new bootstrap.Modal(getModal);
        modal.show();
    }

    function displayUrl({
        target
    }) {
        if (target.value == 'external') {
            console.log('laele', document.querySelector('input[name="url"]'));
            document.querySelector('input[name="url"]').closest('.row').style.display = 'block';
        } else {
            document.querySelector('input[name="url"]').closest('.row').style.display = 'none';
        }
    }
</script>
@endsection