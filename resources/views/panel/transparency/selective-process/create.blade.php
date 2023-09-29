@extends('panel.index')
@section('pageTitle', 'Novo Processo Seletivo')

@section('breadcrumb')
<li><a href="{{ route('selective-process.index') }}">Processos Seletivos</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')

<div class="card">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
    @endif

    <div class="card-body">
        <form action="{{ route('selective-process.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title1">Selecione o Exercício</label>
                <select name="exercicy_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($exercicies->children as $exercicy)
                    <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}" />
            </div>

            <div class="form-group">
                <label for="logo">Arquivos</label>
                <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
            </div>

            <div id="custom-name-fields"></div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script>
    // Função para adicionar campos de entrada de nome personalizado
    function addCustomNameInput(file) {
        const formGroup = document.createElement("div");
        formGroup.classList.add('form-group');


        const input = document.createElement("input");
        input.classList.add('form-control');
        input.type = "text";
        input.name = "custom_names[]";
        input.placeholder = "Nome do arquivo";
        input.value = file.name;

        const label = document.createElement('label');
        label.innerHTML = "Nome do arquivo <strong>"+file.name+"</strong>";

        formGroup.appendChild(label);
        formGroup.appendChild(input);

        const customNameContainer = document.getElementById("custom-name-fields");
        customNameContainer.appendChild(formGroup);
    }

    // Função para lidar com a seleção de arquivos
    function handleFileSelect(event) {
        var files = event.target.files;

        // Limpar campos de entrada de nome personalizado existentes
        var customNameContainer = document.getElementById("custom-name-fields");
        customNameContainer.innerHTML = "";

        // Adicionar campos de entrada de nome para cada arquivo selecionado
        for (var i = 0; i < files.length; i++) {
            addCustomNameInput(files[i]);
        }
    }

    // Adicionar um ouvinte de evento de alteração ao campo de entrada de arquivo
    var fileInput = document.querySelector('input[type="file"]');
    fileInput.addEventListener("change", handleFileSelect);
</script>


@endsection