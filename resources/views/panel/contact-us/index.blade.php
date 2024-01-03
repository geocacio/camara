@extends('panel.index')
@section('pageTitle', 'Página de Contato')

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
        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control" autocomplete="off" value="{{ old('telefone') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>HORÁRIO DE ATENDIMENTO</label>
                        <input type="text" name="opening_hours" class="form-control" autocomplete="off" value="{{ old('opening_hours') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" autocomplete="off" value="{{ old('email') }}">
            </div>

            {{-- <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="status" value="1" class="toggle-input">
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div> --}}

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