@extends('panel.index')
@section('pageTitle', 'Atualizar Sessão')

@section('breadcrumb')
<li><a href="{{ route('sessions.index') }}">Sessões</a></li>
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
        <form action="{{ route('sessions.update', $session->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $session->date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_id">Tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($types)
                            @foreach($types->children as $type)
                            <option value="{{ $type->id}}" {{ $session->types[0]->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_id">Status</label>
                        <select name="status_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($status)
                            @foreach($status->children as $statu)
                            <option value="{{ $statu->id }}" {{ $statu->id == $session->status_id ? 'selected' : '' }}>{{ $statu->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exercicy_id">Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($exercicies)
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id }}" {{ $exercicy->id == $session->exercicy_id ? 'selected' : '' }}>{{ $exercicy->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            @php
                $expectedFiles = ['ata', 'pauta']; 
                $existingFileNames = $session->files->pluck('file.name')->toArray();
            @endphp

            <div class="col-12 pt-30 container-all-files">
                @foreach($session->files as $file)
                    <div class="form-group" id="file-container-{{ $file->file->id }}">
                        <div class="form-control">
                            <div style="display: flex; align-items: center; justify-content: space-between">
                                <a href="{{ asset('storage/'.$file->file->url) }}" target="_blank">
                                    Visualizar {{ $file->file->name }}
                                </a>
                                <button type="button" onclick="deleteFile({{ $file->file->id }})" class="btn btn-danger btn-sm ml-2">
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach($expectedFiles as $expectedFile)
                    @if(!in_array($expectedFile, $existingFileNames))
                        <div class="form-group">
                            <label for="{{ $expectedFile }}">Arquivo {{ ucfirst($expectedFile) }}</label>
                            <input type="file" name="{{ $expectedFile }}" accept="application/pdf" class="form-control mt-2">
                        </div>
                    @endif
                @endforeach
            </div>
            
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $session->description) }}</textarea>
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
<script>
function deleteFile(fileId) {
    if (confirm('Tem certeza de que deseja deletar este arquivo?')) {
        fetch(`/panel/files/${fileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);

            // Ocultar o elemento do arquivo deletado no DOM
            const fileContainer = document.getElementById(`file-container-${fileId}`);
            if (fileContainer) {
                fileContainer.style.display = 'none';
            }

            // Adicionar label e input para o upload do arquivo excluído
            const uploadContainer = document.querySelector('.container-all-files');
            const formGroup = document.createElement('div');
            formGroup.classList.add('form-group');

            const label = document.createElement('label');
            label.setAttribute('for', data.file_name);
            label.textContent = `Arquivo ${data.file_name.charAt(0).toUpperCase() + data.file_name.slice(1)}`;

            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = data.file_name;
            newInput.accept = 'application/pdf';
            newInput.classList.add('form-control', 'mt-2');

            formGroup.appendChild(label);
            formGroup.appendChild(newInput);
            uploadContainer.appendChild(formGroup);
        })
        .catch(error => console.error('Erro:', error));
    }
}

</script>
@endsection