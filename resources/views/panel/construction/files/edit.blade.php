@extends('panel.index')

@section('pageTitle', 'Atualizar Arquivo')

@section('breadcrumb')
<li><a href="{{ route('constructions.index') }}">Convênios</a></li>
<li><a href="{{ route('constructions.file.index', $construction->slug) }}">Arquivos</a></li>
<li><span>Atualizar</span></li>
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

        <form action="{{ route('constructions.file.update', ['construction' => $construction->slug, 'file' => $file->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $file->name) }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $file->description) }}</textarea>
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