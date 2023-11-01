@extends('panel.index')

@section('pageTitle', 'Portal da Transparência')

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

        <form action="{{ route('transparency.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', isset($transparencyPortal->title) ? $transparencyPortal->title : '') }}" />
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', isset($transparencyPortal->description) ? $transparencyPortal->description : '') }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection