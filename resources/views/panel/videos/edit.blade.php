@extends('panel.index')

@section('pageTitle', 'Atualizar Vídeo')
@section('breadcrumb')
<li><a href="{{ route('videos.index') }}">Vídeos</a></li>
<li><span>Atualizar Vídeo</span></li>
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

        <form action="{{ route('videos.update', $video->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $video->title) }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $video->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="title1">Selecione a Categoria</label>
                <select name="category" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories[0]->children as $category)
                    <option value="{{ $category->id}}" {{ $category->id == $video->categories[0]->category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title1">Selecione a fonte do vídeo</label>
                <select name="video_source" class="form-control" onchange="showVideoSource(event)">
                    <option value="">Selecione</option>
                    <option value="internal" {{ $video->video_source == 'internal' ? 'selected' : '' }}>Interno</option>
                    <option value="youtube" {{ $video->video_source == 'youtube' ? 'selected' : '' }}>youtube</option>
                    <option value="facebook" {{ $video->video_source == 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="instagram" {{ $video->video_source == 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="outros">Outros</option>
                </select>
            </div>
            <div class="container-video-source">
                <div class="source-external" style="display: {{ $video->video_source != 'internal' ? 'block' : 'none' }}">
                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url', $video->url) }}" />
                    </div>
                </div>

                <div class="source-internal" style="display: {{ $video->video_source == 'internal' ? 'block' : 'none' }}">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-input-file">
                                    <label for="logo">Vídeo</label>
                                    <input type="file" name="file" accept="video/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                    @if($myVideo)
                                    <div class="container-temp-file">
                                        <video autoplay muted loop class="video" preload="auto">
                                            <source type="video/mp4" src="{{ asset('storage/'.$myVideo->file->url) }}">
                                        </video>
                                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-input-file">
                                    <label for="logo">Thumbnail</label>
                                    <input type="file" name="thumbnail" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                    @if($myThumbnail)
                                    <div class="container-temp-file">
                                        <img class="image" src="{{ asset('storage/'.$myThumbnail->file->url) }}" />
                                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$myThumbnail->file->id}}')">
                                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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

@section('js')

@include('panel.scripts')

@endsection