@extends('panel.index')
@section('pageTitle', 'Novo Subescritor')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><a href="{{ route('authors.index', $material->slug) }}">Subescritores</a></li>
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
        <form action="{{ route('authors.store', $material->slug) }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="councilor_id">Vereador</label>
                        <select name="councilor_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($councilors->count() > 0)
                            @foreach($councilors as $councilor)
                            <option value="{{ $councilor->id }}">{{ $councilor->name }}</option>
                            @endforeach
                            @endif
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
@endsection