@extends('panel.index')
@section('pageTitle', 'Página de apresentação do Diário')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        <li>{{ $errors->first() }}</li>
    </ul>
</div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('presentation.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Conteúdo</label>
                <textarea id="editor" name="presentation" class="form-control">{{ isset($presentation) ? old('presentation', $presentation->presentation) : old('presentation') }}</textarea>
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
</script>

@endsection