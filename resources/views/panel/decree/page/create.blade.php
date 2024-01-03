@extends('panel.index')
@section('pageTitle', 'Página de Decretos')

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
        <form action="{{ route('decrees.page.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon') }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title')}}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control title" autocomplete="off" value="{{ old('title') }}">
                    </div>
                </div>
            </div>
            

            <!-- <div class="form-group">
                <label>Text</label>
                <input type="text" name="text" class="form-control text" autocomplete="off" value="{{ old('text') }}">
            </div> -->
    
            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" checked>
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