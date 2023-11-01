@extends('panel.index')
@section('pageTitle', 'Editando Destinatário')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><a href="{{ route('recipients.index', $material->slug) }}">Destinatários</a></li>
<li><span>{{ $recipient->name }}</span></li>
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
        <form action="{{ route('recipients.update',  ['material' => $material->slug, 'recipient' => $recipient->slug]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $recipient->name) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Posição</label>
                        <input type="text" name="position" class="form-control" value="{{ old('position', $recipient->position) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Organização</label>
                        <input type="text" name="organization" class="form-control" value="{{ old('organization', $recipient->organization) }}" />
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