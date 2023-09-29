@extends('panel.index')
@section('pageTitle', 'Página eSIC')

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
        <form action="{{ route('esic.update', $esicPage->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon', $esicPage->icon) }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title', $esicPage->main_title) }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" value="{{ old('title', $esicPage->title) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Text</label>
                <input type="text" name="description" class="form-control" autocomplete="off" value="{{ old('description', $esicPage->description) }}">
            </div>

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" {{ $esicPage->visibility == 'enabled' ? 'checked' : ''}}>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Grupo (onde será exibido no portal da transparência)</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione o grupo</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $esicPage->groupContents && $esicPage->groupContents->transparency_group_id && $group->id == $esicPage->groupContents->transparency_group_id ? 'selected' : '' }}>{{ $group->title }} - {{ $group->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gestor</label>
                        <input type="text" name="manager" class="form-control" autocomplete="off" value="{{ old('manager', $sic ? $sic->manager : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control" autocomplete="off" value="{{ old('phone', $sic ? $sic->phone : '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" autocomplete="off" value="{{ old('email', $sic ? $sic->email : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control mask-cep" autocomplete="off" value="{{ old('cep', $sic ? $sic->cep : '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="street" class="form-control" autocomplete="off" value="{{ old('street', $sic ? $sic->street : '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="number" class="form-control" autocomplete="off" value="{{ old('number', $sic ? $sic->number : '') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Complemento</label>
                        <input type="text" name="complement" class="form-control" autocomplete="off" value="{{ old('complement', $sic ? $sic->complement : '') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="neighborhood" class="form-control" autocomplete="off" value="{{ old('neighborhood', $sic ? $sic->neighborhood : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                        <label>Horário de atendimento</label>
                        <input type="text" name="opening_hours" class="form-control" autocomplete="off" value="{{ old('opening_hours', $sic ? $sic->opening_hours : '') }}">
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