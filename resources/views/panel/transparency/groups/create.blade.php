@extends('panel.index')

@section('pageTitle', 'Novo grupo')

@section('breadcrumb')
<li><a href="{{ route('transparency.groups.index') }}">Grupos</a></li>
<li><span>Novo grupo</span></li>
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

        <form action="{{ route('transparency.groups.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
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