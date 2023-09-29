@extends('panel.index')

@section('pageTitle', 'Novo Cargo')
@section('breadcrumb')
<li><a href="{{ route('offices.index') }}">Cargos</a></li>
<li><span>Novo Cargo</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif

        <form action="{{ route('offices.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="office" class="form-control" value="{{ old('office') }}" />
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

@section('js')

@include('panel.scripts')

@endsection