@extends('panel.index')
@section('pageTitle', 'Página Papel do Vereador')
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

        <form action="{{ route('role-councilor.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control title" value="{{ old('title') }}" />
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea class="editor" name="description">{{ old('description') }}</textarea>
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