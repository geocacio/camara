@extends('panel.index')
@section('pageTitle', 'Atualizar Subescritor')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><a href="{{ route('authors.index', $material->slug) }}">Subescritores</a></li>
<li><span>Atualizar</span></li>
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
        <form action="{{ route('authors.update', ['material' => $material->slug, 'author' => $author->id]) }}" method="post">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="councilor_id">Vereador</label>
                        <select name="councilor_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($councilors->count() > 0)
                            @foreach($councilors as $councilor)
                            <option value="{{ $councilor->id }}" {{ $councilor->id == $author->councilor_id ? 'selected' : '' }}>{{ $councilor->name }}</option>
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