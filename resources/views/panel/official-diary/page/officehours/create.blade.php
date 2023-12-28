@extends('panel.index')
@section('pageTitle', 'Página de expediente')

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
        <form action="{{ route('diary.expedient.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Periodicidade</label>
                        <input type="text" name="frequency" class="form-control" autocomplete="off" value="{{ old('frequency') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome do responsável</label>
                        <input type="text" name="responsible_name" class="form-control" autocomplete="off" value="{{ old('responsible_name') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cargo do responsável</label>
                        <input type="text" name="responsible_position" class="form-control" autocomplete="off" value="{{ old('responsible_position') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome da entidade</label>
                        <input type="text" name="entity_name" class="form-control" autocomplete="off" value="{{ old('entity_name') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="entity_address" class="form-control" autocomplete="off" value="{{ old('entity_address') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="entity_zip_code" class="form-control" autocomplete="off" value="{{ old('entity_zip_code') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" name="entity_cnpj" class="form-control" autocomplete="off" value="{{ old('entity_cnpj') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="entity_email" class="form-control" autocomplete="off" value="{{ old('entity_email') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="entity_phone" class="form-control" autocomplete="off" value="{{ old('entity_phone') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Acervo</label>
                        <textarea name="information" class="form-control" autocomplete="off">{{ old('information') }}</textarea>
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