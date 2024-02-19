@extends('panel.index')
@section('pageTitle', 'Criar post')
@section('breadcrumb')
<li><a href="{{ route('posts.index') }}">Posts</a></li>
<li><span>Novo post</span></li>
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

        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control title" value="{{ old('title') }}" />
            </div>

            <div class="form-group">
                <label for="title1">Categoria</label>
                <select id="parent_id" name="category" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id}}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="logo">Imagem destacada</label>
                <input type="file" name="featured_image" class="form-control" onchange="displayTempImages(event, 'conatiner-temp-image')">
                <div class="conatiner-temp-image mt-3 hide">
                    <img class="image" src="" style="width: 100px" />
                    <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image')">
                        <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea id="editor" name="content">{{ old('content') }}</textarea>
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