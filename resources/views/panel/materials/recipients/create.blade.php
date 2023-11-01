@extends('panel.index')
@section('pageTitle', 'Novo Destinatário')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><a href="{{ route('recipients.index', $material->slug) }}">Destinatários</a></li>
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
        <form action="{{ route('recipients.store', $material->slug) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Posição</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Organização</label>
                        <input type="text" name="organization" class="form-control" value="{{ old('organization') }}" />
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection