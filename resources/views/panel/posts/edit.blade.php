@extends('panel.index')
@section('pageTitle', 'Editar post')

@section('breadcrumb')
<li><a href="{{ route('posts.index') }}">Posts</a></li>
<li><span>{{ $post->title}}</span></li>
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

        <form action="{{ route('posts.update', $post->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control title" value="{{ old('title', $post->title) }}" />
            </div>

            <div class="form-group">
                <label for="title1">Categoria</label>
                <select id="parent_id" name="category" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id}}" {{ $cat->id == $category->id ? 'selected' : ''}}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="logo">Imagem destacada</label>
                <input type="file" name="featured_image" class="form-control" onchange="displayTempImages(event, 'conatiner-temp-image')">
                <div class="conatiner-temp-image mt-3 {{ $files->count() <= 0 ? 'hide' : ''}}">
                    @if($files->count() > 0)
                    <img class="image" src="{{ asset('storage/'.$post->files[0]->file->url) }}" />
                    <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$post->files[0]->file->id}}')">
                        <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea class="form-control" name="description">{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Content</label>
                <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
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

<!-- include summernote css/js -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#editor').summernote({
        placeholder: '',
        tabsize: 2,
        height: 100 
    });
});

@endsection