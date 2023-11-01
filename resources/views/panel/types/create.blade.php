@extends('panel.index')
@section('pageTitle', 'Novo Tipo')
@section('breadcrumb')
<li><a href="{{in_array($type->slug, $directoryBreadcrumb) ? '/panel/transparency/'.$type->slug : '/panel/'.$type->slug }}">{{ ucfirst($type->slug) }}</a></li>
<li><a href="{{ route('subtypes.index', $type->slug) }}">Tipos</a></li>
<li><span>Novo Tipo</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('types.store') }}" method="post">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $type->id }}">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection