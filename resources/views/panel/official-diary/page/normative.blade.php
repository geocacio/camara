@extends('panel.index')
@section('pageTitle', 'Página de Normativas')

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
        <form action="{{ route('normative.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="container">

                <div class="form-normative">
                    <div class="form-group">
                        <label for="logo">Arquivo</label>
                        <input type="file" name="files[]" accept="application/pdf" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Descrição do documentos</label>
                        <textarea name="descriptions[]" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
                <button type="button" id="addLawBtn">Adicionar outra lei</button>

                <div class="form-footer text-right">
                    <button type="submit" class="btn-submit-default">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('js')

@include('panel.scripts')
<script>
    $(document).ready(function() {
        $('#addLawBtn').click(function() {
            var newForm = $('.form-normative').first().clone();
            newForm.find('input[type="file"]').val(''); // Clear file input
            newForm.find('textarea').val(''); // Clear description textarea
            $('#container').append(newForm);
        });
    });
</script>
@endsection
