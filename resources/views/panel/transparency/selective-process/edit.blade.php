@extends('panel.index')
@section('pageTitle', 'Atualizar Processo Seletivo')

@section('breadcrumb')
<li><a href="{{ route('selective-process.index') }}">Processos Seletivos</a></li>
<li><span>Atualizar</span></li>
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
        <form action="{{ route('selective-process.update', $selective_process->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title1">Selecione o Exercício</label>
                <select name="exercicy_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($exercicies->children as $exercicy)
                    <option value="{{ $exercicy->id}}" {{ $exercicy->id == $selective_process->exercicy_id ? 'selected' : '' }}>{{ $exercicy->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description', $selective_process->description) }}" />
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
                </div>
                <div class="col-6 pt-30 container-all-files">
                    @if ($selective_process->files->count() > 0)
                    @foreach($selective_process->files as $currentFile)
                    @if (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx']))
                    
                    <div class="container-file">
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#file-{{ $currentFile->file->id }}">{{ $currentFile->file->name != '' ? $currentFile->file->name : pathinfo($currentFile->file->url, PATHINFO_FILENAME) }}</a>
                        <button class="btn-delete" onclick="deleteFile(event, 'container-file', '/panel/files/{{$currentFile->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @elseif (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']))
                    <div class="conatiner-temp-image mt-3 {{ $files->count() <= 0 ? 'hide' : ''}}">
                        <img class="image" src="{{ asset('storage/'.$currentFile->file->url) }}" />
                        <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$currentFile->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @endif

                    <div class="modal fade modal-preview-file" id="file-{{ $currentFile->file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($currentFile->file->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$currentFile->file->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($currentFile->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$currentFile->file->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @else
                    <span class="no-file-info">Nenhum arquivo encontrado.</span>
                    @endif
                </div>

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

@include('panel.scripts')

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