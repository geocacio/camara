@extends('panel.index')
@section('pageTitle', 'Nova Categoria')
@section('breadcrumb')
<li><a href="{{ route('categories.index') }}">Categorias</a></li>
<li><span>Nova Categoria</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.update', $category->slug) }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" />
            </div>
            @if($categories && $categories->count() > 0)
            <div class="form-group">
                <label for="title1">Categoria pai</label>
                <select id="parent_id" name="type" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id}}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
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