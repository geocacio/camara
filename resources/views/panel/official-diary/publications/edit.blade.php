@extends('panel.index')
@section('pageTitle', 'Atualizar publicação')
@section('breadcrumb')
<li><a href="{{ route('official-diary.index') }}">Diários</a></li>
<li><a href="{{ route('publications.index', $official_diary->id) }}">Publicações</a></li>
<li><span>Atualizar publicação</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('publications.update', ['official_diary' => $official_diary->id, 'publication' => $publication->slug]) }}" enctype="multipart/form-data" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="form-group">
                    <label for="logo">Enviar diário assinado</label>
                    <input type="file" name="signedDiary" accept="application/pdf" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    @if($summaries && $summaries->count() > 0)
                    <div class="form-group">
                        <label for="title1">Selecione a categoria</label>
                        <select name="summary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($summaries->children as $summary)
                            <option value="{{ $summary->id}}" {{ $publication->summary->id == $summary->id ? 'selected' : '' }}>{{ $summary->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Forma de exibição</label>
                        <select name="column" class="form-control">
                            <option value="">Selecione</option>
                            <option value="1" {{ $publication->column == 1 ? 'selected' : '' }}>Uma coluna</option>
                            <option value="2" {{ $publication->column == 2 ? 'selected' : '' }}>Duas colunas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $publication->title) }}" />
            </div>

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea id="editor" name="content">{{ old('content', $publication->content) }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
    document.addEventListener("DOMContentLoaded", () => {
        tinymce.init({
            selector: '#publication',
            plugins: 'advcode casechange lists powerpaste table',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify',
            menubar: false
        });
    });

    function displayTempImages(e, container) {
        var reader = new FileReader();
        var img = document.querySelector('.' + container).querySelector('.image');
        document.querySelector('.' + container).classList.remove('hide');
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function(e) {
            img.src = e.target.result;
        }
    }

    function deleteFile(e, container) {
        e.preventDefault();
        document.querySelector('.' + container).classList.add('hide');
        var img = document.querySelector('.' + container).querySelector('.image');
        img.src = '';

        // Limpar o valor do campo files
        var input = document.querySelector('[name="featured_image"]');
        input.value = '';
    }
</script>
@endsection