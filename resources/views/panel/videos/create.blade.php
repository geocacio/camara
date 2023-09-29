@extends('panel.index')

@section('pageTitle', 'Novo Vídeo')
@section('breadcrumb')
<li><a href="{{ route('videos.index') }}">Vídeos</a></li>
<li><span>Novo Vídeo</span></li>
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

        <form action="{{ route('videos.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="title1">Selecione a Categoria</label>
                <select name="category" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories[0]->children as $category)
                    <option value="{{ $category->id}}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title1">Selecione a fonte do vídeo</label>
                <select name="video_source" class="form-control" onchange="showVideoSource(event)">
                    <option value="">Selecione</option>
                    <option value="internal">Interno</option>
                    <option value="youtube">youtube</option>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="outros">Outros</option>
                </select>
            </div>
            <div class="container-video-source">
                <div class="source-external">
                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url') }}" />
                    </div>
                </div>

                <div class="source-internal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-input-file">
                                    <label for="logo">Vídeo</label>
                                    <input type="file" name="file" accept="video/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                    <div class="container-temp-file">

                                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-input-file">
                                    <label for="logo">Thumbnail</label>
                                    <input type="file" name="thumbnail" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                    <div class="container-temp-file">
                                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                    </div>
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