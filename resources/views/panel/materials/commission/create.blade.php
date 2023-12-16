@extends('panel.index')
@section('pageTitle', 'Adicionar Material à comissão')

@section('breadcrumb')
<li><a href="{{ route('materials.index') }}">Materiais</a></li>
<li><a href="{{ route('material-commissions.index', $material->slug) }}">Comissões</a></li>
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
        <form action="{{ route('material-commissions.store', $material->slug) }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="commission_id">Comissão</label>
                        <select name="commission_id" class="form-control">
                            <option value="">Selecione</option>
                           @if($commissions->count() > 0)
                            @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}">{{ $commission->description }}</option>
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