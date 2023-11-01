@extends('panel.index')
@section('pageTitle', 'Página Papel da Câmara')
@section('breadcrumb')
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

        <form action="{{ route('role-chambers.update', $role_chamber->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', $role_chamber->title) }}" />
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea class="editor" name="description">{{ old('description', $role_chamber->description) }}</textarea>
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