@extends('panel.index')

@section('pageTitle', $category->name)
@section('breadcrumb')
<li><a href="{{ route('subcategories.index', $category->slug) }}">{{ $category->name }}</a></li>
<li><span>Novo</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif
        
        <form action="{{ route('subcategories.store') }}" method="post">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $category->id }}">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
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