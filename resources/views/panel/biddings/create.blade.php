@extends('panel.index')

@section('pageTitle', 'Nova Licitação')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><span>Nova Licitação</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="bidding-tab" data-bs-toggle="tab" data-bs-target="#tabBidding" type="button" role="tab" aria-controls="tabBidding" aria-selected="true">Principal</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="publication-tab" data-bs-toggle="tab" data-bs-target="#tabPublication" type="button" role="tab" aria-controls="tabPublication" aria-selected="true">Formas de publicação</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="responsible-tab" data-bs-toggle="tab" data-bs-target="#tabResponsible" type="button" role="tab" aria-controls="tabResponsible" aria-selected="true">Responsáveis</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#tabFiles" type="button" role="tab" aria-controls="tabFiles" aria-selected="true">Arquivos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#tabCompany" type="button" role="tab" aria-controls="tabCompany" aria-selected="true">Empresa</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tabBidding" role="tabpanel" aria-labelledby="bidding-tab">
                <form id="biddingSubmit">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número</label>
                                <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data de abertura</label>
                                <input type="date" name="opening_date" class="form-control" value="{{ old('opening_date') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title1">Selecione a Secretaria</label>
                                <select name="secretary_id" class="form-control" onchange="showOrgans(event, {{ $secretaries }})">
                                    <option value="">Selecione</option>
                                    @if($secretaries)
                                    @foreach($secretaries as $secretary)
                                    <option value="{{$secretary->id}}">{{$secretary->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" style="display: none;">
                            <div class="form-group">
                                <label for="title1">Selecione o orgão</label>
                                <select name="organ_id" class="form-control"></select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title1">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Aberta">Aberta</option>
                                    <option value="Fechada">Fechada</option>
                                    <option value="Em avaliação">Em avaliação</option>
                                    <option value="Homologada">Homologada</option>
                                    <option value="Revogada">Revogada</option>
                                    <option value="Anulada">Anulada</option>
                                    <option value="Concluída">Concluída</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Valor estimado</label>
                                <input type="text" name="estimated_value" class="form-control mask-currency" value="{{ old('estimated_value') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Objeto</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title1">Modalidades</label>
                                <select name="modality" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($modalities[0]->children as $modality)
                                    <option value="{{ $modality->id}}">{{ $modality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title1">Selecione o Exercício</label>
                                <select name="exercicy" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($exercicies[0]->children as $exercicy)
                                    <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title1">Selecione o tipo</label>
                                <select name="type" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id}}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title1">Tipos de concorrência</label>
                                <select name="compety" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($competings[0]->children as $compety)
                                    <option value="{{ $compety->id}}">{{ $compety->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>País</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="tabPublication" role="tabpanel" aria-labelledby="publication-tab">
                <div class="card">
                    <div class="card-body">

                        <div class="card-header text-right">
                            <a href="#" class="btn-default" data-toggle="modal" data-target="#publicationFormModal">Novo</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabResponsible" role="tabpanel" aria-labelledby="responsible-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header text-right">
                            <a href="#" class="btn-default" data-toggle="modal" data-target="#responsibleFormModal">Novo</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Responsabilidade</th>
                                        <th>#</th>
                                        <th>Agente</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabFiles" role="tabpanel" aria-labelledby="files-tab">
                <div class="container-tab-vertical">
                    <ul class="nav nav-tabs tab-vertical" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="authorization-tab" data-bs-toggle="tab" data-bs-target="#authorization" type="button" role="tab" aria-controls="authorization" aria-selected="true">Autorização</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="market-research-tab" data-bs-toggle="tab" data-bs-target="#market-research" type="button" role="tab" aria-controls="market-research" aria-selected="false">Pesquisa de mercado</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade text-center show active" id="authorization" role="tabpanel" aria-labelledby="authorization-tab">
                            <input type="file" name="authorization" id="file-authorization" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-authorization', 'authorization-tab', 'file-preview-authorization')">
                            <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-authorization').click();"><i class="fa-solid fa-upload"></i></button>
                            <div id="file-preview-authorization"></div>
                            <button type="button" class="btn-delete" id="delete-authorization" onclick="deleteFile('authorization')" style="display: none;">
                                <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="tab-pane fade text-center" id="market-research" role="tabpanel" aria-labelledby="market-research-tab">
                            <input type="file" name="market_research" id="file-market-research" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-market-research', 'market-research-tab', 'file-preview-market-research')">
                            <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-market-research').click();"><i class="fa-solid fa-upload"></i></button>
                            <div id="file-preview-market-research"></div>
                            <button type="button" class="btn-delete" id="delete-market-research" onclick="deleteFile('market-research')" style="display: none;">
                                <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabCompany" role="tabpanel" aria-labelledby="company-tab">

                <form id="formCompany">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input type="text" name="company_cnpj" class="form-control mask-cnpj" value="{{ old('company_cnpj') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" name="company_city" class="form-control" value="{{ old('company_city') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="company_state" class="form-control" value="{{ old('company_state') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>País</label>
                                <input type="text" name="company_country" class="form-control" value="{{ old('country') }}" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="form-footer text-right">
            <button type="button" class="btn-submit-default" onclick="submitBiddingForm()">Guardar</button>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade modal-lg" id="publicationFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Nova forma de publicação</h5>
                    <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="publicationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Data da publicação</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="type" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="DIÁRIO OFICIAL DO MUNICÍPIO">DIÁRIO OFICIAL DO MUNICÍPIO</option>
                                        <option value="JORNAL DE GRANDE CIRCULAÇÃO">JORNAL DE GRANDE CIRCULAÇÃO</option>
                                        <option value="DIÁRIO OFICIAL DA UNIÃO">DIÁRIO OFICIAL DA UNIÃO</option>
                                        <option value="DIÁRIO OFICIAL DO ESTADO">DIÁRIO OFICIAL DO ESTADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-footer text-right">
                        <button type="button" class="btn-submit-default" onclick="newPublicationForm('publicationForm', 'publicationFormModal', 'formArray')">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="responsibleFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Novo Responsável</h5>
                    <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ResponsibilityForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Responsabilidade</label>
                                    <select name="responsibility_id" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($responsibilities[0]->children as $responsibility)
                                        <option value="{{ $responsibility->id }}">{{ $responsibility->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Responsável</label>
                                    <select name="employee_id" class="form-control" onchange="updateResponsibleSelect(this)">
                                        <option value="">Selecione</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id}}">{{ $employee->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="employee_name" value="">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-footer text-right">
                        <button type="button" class="btn-submit-default" onclick="newPublicationForm('ResponsibilityForm', 'responsibleFormModal', 'responsibleArray')">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')

@include('panel.scripts')

<script>
    let formArray = [];
    let responsibleArray = [];
    let files = [];

    function submitBiddingForm() {
        const biddingForm = document.getElementById('biddingSubmit');
        const biddingData = new FormData(biddingForm);

        const companyForm = document.getElementById('formCompany');
        const companyData = new FormData(companyForm);

        // Adicionar os dados da empresa ao FormData da licitação
        for (let pair of companyData.entries()) {
            biddingData.append(pair[0], pair[1]);
        }

        biddingData.append('responsibilities', JSON.stringify(responsibleArray));
        biddingData.append('publications', JSON.stringify(formArray));

        files.forEach(fileData => {
            const fileId = Object.keys(fileData)[0];
            const file = fileData[fileId].file;
            biddingData.append(fileId, file);
        });

        axios.post('/panel/biddings', biddingData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                window.location.href = '/panel/biddings';
            })
            .catch(error => console.log('erro ao tentar criar nova licitação'));
    }

    function newPublicationForm(form, modal, array) {
        const formData = document.getElementById(form);
        const data = new FormData(formData);
        const formValues = Object.fromEntries(data.entries());

        if (array == 'formArray') {
            formArray.push(formValues);
            updateTable(formArray, '#tabPublication');
        } else if (array == 'responsibleArray') {
            responsibleArray.push(formValues);
            updateTable(responsibleArray, '#tabResponsible');
        }

        // Limpar os campos do formulário
        formData.reset();

        const currentModal = document.getElementById(modal);
        currentModal.querySelector('.close').click();
    }

    const updateTable = (array, parentTable) => {
        // Limpar a tabela
        const tableBody = document.querySelector(parentTable + ' table tbody');
        tableBody.innerHTML = '';

        // Preencher a tabela com os dados atualizados
        array.forEach((formValues, index) => {
            const row = document.createElement('tr');

            // Adicionar as células com os valores do formulário
            Object.values(formValues).forEach(value => {
                const cell = document.createElement('td');
                cell.textContent = value;
                row.appendChild(cell);
            });

            // Adicionar a célula com o botão de exclusão
            const deleteCell = document.createElement('td');
            deleteCell.classList.add('text-right', 'actions');
            const deleteButton = document.createElement('a');
            deleteButton.classList.add('link', 'delete');
            deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
            deleteButton.addEventListener('click', () => removeItem(array, parentTable, index)); // Chama a função removeItem() ao clicar no botão
            deleteCell.appendChild(deleteButton);
            row.appendChild(deleteCell);

            tableBody.appendChild(row);
        });
    }

    const removeItem = (array, parentTable, index) => {
        if (parentTable == '#tabPublication') {
            formArray.splice(index, 1);
            updateTable(array, '#tabPublication');
        } else if (parentTable == '#tabResponsible') {
            responsibleArray.splice(index, 1);
            updateTable(responsibleArray, '#tabResponsible');
        }
    }

    const sendFile = ({target}, fileId, btnId, filePreviewId) => {
        const file = target.files[0];

        if (file.type !== 'application/pdf') {
            alert('Por favor, selecione um arquivo PDF.');
            return;
        }

        const button = document.getElementById(btnId);
        const buttonName = button.innerText;

        const fileData = {
            [target.id]: {
                name: buttonName,
                file: file,
            }
        };
        // Adicionar o arquivo na variável files
        files.push(fileData);

        const reader = new FileReader();

        reader.onload = (event) => {
            const fileContent = event.target.result;

            const filePreview = document.getElementById(filePreviewId);

            // Exibir o PDF usando a tag <embed>
            filePreview.innerHTML = `<embed src="${fileContent}" width="100%" height="600px" type="application/pdf">`;
        };

        reader.readAsDataURL(file); // Ler o conteúdo do arquivo como uma URL de dados (data URL)

        // Ocultar o botão e o input de upload
        const fileInput = document.getElementById(fileId);
        const uploadButton = document.querySelector(`[onclick="document.getElementById('${fileId}').click();"]`);
        fileInput.style.display = 'none';
        uploadButton.style.display = 'none';

        //exibir botão de remover arquivo
        const btnDelete = target.closest('.tab-pane').querySelector('.btn-delete').style.display = 'block';
    };

    function deleteFile(name) {
        // Remover o arquivo da variável files
        files = files.filter(file => Object.keys(file)[0] !== `file-${name}`);

        const filePreview = document.getElementById(`file-preview-${name}`);
        const deleteButton = document.getElementById(`delete-${name}`);
        const fileInput = document.getElementById(`file-${name}`);
        const uploadButton = document.querySelector(`[onclick="document.getElementById('file-${name}').click();"]`);

        // Limpar a visualização do arquivo e reexibir o botão e o input de upload
        filePreview.innerHTML = '';
        deleteButton.style.display = 'none';
        fileInput.value = '';
        fileInput.style.display = 'none';
        uploadButton.style.display = 'inline-block';
    }

    function updateResponsibleSelect(selectElement) {
        var selectedText = selectElement.options[selectElement.selectedIndex].text;
        var employeeNameInput = document.querySelector('input[name="employee_name"]');
        employeeNameInput.value = selectedText;
    }
    

    function showOrgans({target}, data) {
        const organs = target.value != '' ? data.find(secretary => target.value == secretary.id).organs : [];
        const organElement = document.querySelector('select[name="organ_id"]');
        if (organs.length > 0) {
            organElement.closest('.col-md-6').style.display = 'block';
            organElement.innerHTML = '';

            organs.forEach((organ, index) => {
                const newOption = document.createElement('option');
                newOption.value = organ.id;
                newOption.text = organ.name;

                organElement.appendChild(newOption);
            });
        }else{
            organElement.innerHTML = '';
            organElement.closest('.col-md-6').style.display = 'none';
        }

    }
    
</script>

@endsection