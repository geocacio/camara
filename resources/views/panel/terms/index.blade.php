@extends('panel.index')
@section('pageTitle', 'Atualizar termos de uso')
@section('breadcrumb')
    <li><a href="{{ route('terms-use.create') }}">Termos de uso do sistema</a></li>
    <li><span>Atualizar termos</span></li>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('terms-use.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Ativado/Desativado</label>
                    <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                        <div class="toggle-switch cmt-4">
                            <input type="checkbox" id="checklist" name="show" value="1" class="toggle-input" {{optional($term)->show == 1 ? 'checked' : ''}}>
                            <label for="checklist" class="toggle-label no-margin"></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Conteúdo</label>
                    <textarea id="publication" name="content">{{ old('content', optional($term)->content) }}</textarea>
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