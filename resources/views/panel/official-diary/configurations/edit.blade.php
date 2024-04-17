@extends('panel.index')

@section('pageTitle', 'Configurações do Diário Oficial')

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

        <form action="{{ route('configure-official-diary.update', $configure->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $configure->title) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Subtítulo</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $configure->subtitle) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Primeiro texto</label>
                        <input type="text" name="text_one" class="form-control" value="{{ old('text_one', $configure->text_one) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Segundo texto</label>
                        <input type="text" name="text_two" class="form-control" value="{{ old('text_two', $configure->text_two) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Terceiro texto</label>
                        <input type="text" name="text_three" class="form-control" value="{{ old('text_three', $configure->text_three) }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Títul do rodapé</label>
                        <input type="text" name="footer_title" class="form-control" value="{{ old('footer_title', $configure->footer_title) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Texto do rodapé</label>
                        <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $configure->footer_text) }}" />
                    </div>
                </div>
            </div>

            {{-- <div class="form-group">
                <label>Normativas</label>
                <textarea name="normatives" class="form-control">{{ old('normatives', $configure->normatives) }}</textarea>
            </div> --}}

            <div class="form-group">
                <label>Apresentação</label>
                <textarea name="presentation" class="form-control">{{ old('presentation', $configure->presentation) }}</textarea>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Logo</label>
                    <input type="file" name="file" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($configure->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$configure->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$configure->files[0]->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                        @endif
                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
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