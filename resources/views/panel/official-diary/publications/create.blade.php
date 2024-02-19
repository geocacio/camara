@extends('panel.index')
@section('pageTitle', 'Nova publicação')
@section('breadcrumb')
<li><a href="{{ route('official-diary.index') }}">Diários</a></li>
<li><a href="{{ route('publications.index', $official_diary->id) }}">Publicações</a></li>
<li><span>Nova publicação</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('publications.store', $official_diary->id) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    @if($summaries && $summaries->count() > 0)
                    <div class="form-group">
                        <label for="title1">Selecione a categoria</label>
                        <select name="summary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($summaries->children as $summary)
                            <option value="{{ $summary->id}}">{{ $summary->name }}</option>
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
                            <option value="1">Uma coluna</option>
                            <option value="2">Duas colunas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
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