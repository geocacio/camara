@extends('panel.index')
@section('pageTitle', 'Página das Diárias')

@section('breadcrumb')
<li><a href="{{ route('dailies.index') }}">Diárias</a></li>
<li><span>Novo</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($secretaries->count() > 0)
        <form action="{{ route('dailies.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Data da portaria</label>
                        <input type="date" name="ordinance_date" class="form-control" value="{{ old('ordinance_date') }}" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Agente</label>
                        <input type="text" name="agent" class="form-control" value="{{ old('agent') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o Cargo</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id}}">{{ $office->office }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione a Secretaria</label>
                        <select name="secretary_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($secretaries as $secretary)
                            <option value="{{ $secretary->id}}">{{ $secretary->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Orgão/Emissão</label>
                        <input type="text" name="organization_company" class="form-control" value="{{ old('organization_company') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Início da viagem</label>
                        <input type="date" name="trip_start" class="form-control" value="{{ old('trip_start') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fim da viagem</label>
                        <input type="date" name="trip_end" class="form-control" value="{{ old('trip_end') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data quitação</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor unitário</label>
                        <input type="text" name="unit_price" class="form-control mask-currency" value="{{ old('unit_price') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Quantidade</label>
                        <input type="text" name="quantity" class="form-control mask-quantity" value="{{ old('quantity') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Valor total</label>
                        <input type="text" name="amount" class="form-control mask-currency" value="{{ old('amount') }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Justificativa</label>
                <textarea name="justification" class="form-control">{{ old('justification') }}</textarea>
            </div>
            <div class="form-group">
                <label>Histórico</label>
                <textarea name="historic" class="form-control">{{ old('historic') }}</textarea>
            </div>
            <div class="form-group">
                <label>Artigo da Lei</label>
                <textarea name="information" class="form-control">{{ old('information') }}</textarea>
            </div>


            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
            </div>
            
            <div id="custom-name-fields"></div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
        @else
        <div class="no-data">
            <span>Você precisa ter pelomenos uma secretaria cadastrada!</span>
            <a href="{{ route('secretaries.create') }}" class="link">Criar</a>
        </div>
        @endif
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