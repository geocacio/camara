@extends('panel.index')

@section('pageTitle', 'Novo Arquivo')

@section('breadcrumb')
<li><a href="{{ route('agreements.index') }}">Convênios</a></li>
<li><a href="{{ route('agreements.file.index', $agreement->slug) }}">Arquivos</a></li>
<li><span>Novo</span></li>
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

        <form action="{{ route('agreements.file.store', $agreement->slug) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="file" accept="application/pdf" class="form-control">
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