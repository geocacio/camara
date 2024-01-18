@extends('panel.index')

@section('pageTitle', 'Atualizar Licitação')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><span>Atualizar Licitação</span></li>
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
                    <input type="hidden" name="bidding_slug" value="{{ $bidding->slug }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número</label>
                                <input type="text" name="number" class="form-control" value="{{ old('number', $bidding->number) }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data de abertura</label>
                                <input type="date" name="opening_date" class="form-control" value="{{ old('opening_date', $bidding->opening_date) }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title1">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Aberta" {{ $bidding->status == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                                    <option value="Fechada" {{ $bidding->status == 'Fechada' ? 'selected' : '' }}>Fechada</option>
                                    <option value="Em avaliação" {{ $bidding->status == 'Em avaliação' ? 'selected' : '' }}>Em avaliação</option>
                                    <option value="Homologada" {{ $bidding->status == 'Homologada' ? 'selected' : '' }}>Homologada</option>
                                    <option value="Revogada" {{ $bidding->status == 'Revogada' ? 'selected' : '' }}>Revogada</option>
                                    <option value="Anulada" {{ $bidding->status == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                                    <option value="Concluída" {{ $bidding->status == 'Concluída' ? 'selected' : '' }}>Concluída</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Valor estimado</label>
                                <input type="text" name="estimated_value" class="form-control mask-currency" value="{{ old('estimated_value', $bidding->estimated_value ? 'R$ '.number_format($bidding->estimated_value, 2, ',', '.') : '') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Objeto</label>
                        <textarea name="description" class="form-control">{{ old('description', $bidding->description) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title1">Modalidades</label>
                                <select name="modality" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($modalities[0]->children as $modality)
                                    <option value="{{ $modality->id}}" {{ in_array($modality->name, array_column($biddingCategories->toArray(), 'name')) ? 'selected' : '' }}>{{ $modality->name }}</option>
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
                                    <option value="{{ $exercicy->id}}" {{ in_array($exercicy->name, array_column($biddingCategories->toArray(), 'name')) ? 'selected' : '' }}>{{ $exercicy->name }}</option>
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
                                    <option value="{{ $type->id}}" {{$bidding->types->count() > 0 && $type->id == $bidding->types[0]->id ? 'selected' : ''}}>{{ $type->name }}</option>
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
                                    <option value="{{ $compety->id}}" {{ in_array($compety->name, array_column($biddingCategories->toArray(), 'name')) ? 'selected' : '' }}>{{ $compety->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $bidding->address) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $bidding->city) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $bidding->state) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>País</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', $bidding->country) }}" />
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
                                    @foreach($bidding->publicationForms as $publication)
                                    <tr>
                                        <td>{{ $publication->date }}</td>
                                        <td>{{ $publication->type }}</td>
                                        <td>{{ $publication->description }}</td>
                                        <td class="actions text-right">
                                            <a data-toggle="modal" data-target="#myModal{{$publication->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                                            <div id="myModal{{$publication->id}}" class="modal fade modal-warning" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <span class="icon" data-v-988dbcee=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon" data-v-988dbcee="">
                                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" data-v-988dbcee=""></polygon>
                                                                    <line x1="12" y1="8" x2="12" y2="12" data-v-988dbcee=""></line>
                                                                    <line x1="12" y1="16" x2="12.01" y2="16" data-v-988dbcee=""></line>
                                                                </svg></span>
                                                            <span class="title">Você tem certeza?</span>
                                                            <span class="message">Você realmente quer apagar este item?<br> Esta ação não poderá ser desfeita.</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $publication->id }}').submit();">
                                                                Deletar
                                                            </a>

                                                            <form id="delete-form-{{ $publication->id }}" action="{{ route('publications.destroy', $publication->slug) }}" method="post" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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
                                    @foreach($bidding->responsibilities as $responsibility)
                                    <tr>
                                        <td>{{ $responsibility->id }}</td>
                                        <td>{{ $responsibility->pivot->employee->id }}</td>
                                        <td>{{ $responsibility->pivot->employee->name }}</td>
                                        <td class="actions text-right">
                                            <a data-toggle="modal" data-target="#myModal{{$responsibility->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                                            <div id="myModal{{$responsibility->id}}" class="modal fade modal-warning" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <span class="icon" data-v-988dbcee=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon" data-v-988dbcee="">
                                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" data-v-988dbcee=""></polygon>
                                                                    <line x1="12" y1="8" x2="12" y2="12" data-v-988dbcee=""></line>
                                                                    <line x1="12" y1="16" x2="12.01" y2="16" data-v-988dbcee=""></line>
                                                                </svg></span>
                                                            <span class="title">Você tem certeza?</span>
                                                            <span class="message">Você realmente quer apagar este item?<br> Esta ação não poderá ser desfeita.</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $responsibility->id }}').submit();">
                                                                Deletar
                                                            </a>

                                                            <form id="delete-form-{{ $responsibility->id }}" action="{{ route('biddings.responsibility.destroy', ['bidding' => $bidding->slug ,'id' => $responsibility->id]) }}" method="post" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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
                        @php
                            use Illuminate\Support\Str;
                        @endphp
                        @foreach ($otherFiles as $otherFile)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="{{ Str::slug($otherFile->name) }}-tab" data-bs-toggle="tab" data-bs-target="#{{ Str::slug($otherFile->name) }}" type="button" role="tab" aria-controls="{{ Str::slug($otherFile->name) }}" aria-selected="false">{{ $otherFile->name }}</button>
                            </li>
                        @endforeach
                    </ul>
                    <span>
                        <button class="btn-plus-file" onclick="addNewTab()">+</button>
                    </span>
                    <div class="tab-content tabFileNew" id="myTabContent">
                        <div class="tab-pane fade text-center show active" id="authorization" role="tabpanel" aria-labelledby="authorization-tab">
                            <input type="file" name="authorization" id="file-authorization" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-authorization', 'authorization-tab', 'file-preview-authorization')">
                            <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-authorization').click();" style="display: {{ array_key_exists('File Authorization', $availableFiles) && !empty($availableFiles['File Authorization']) ? 'none' : 'block' }}"><i class="fa-solid fa-upload"></i></button>
                            <div id="file-preview-authorization"></div>
                            @if(!empty($availableFiles['File Authorization']))
                            <button type="button" class="btn-delete" id="delete-authorization" onclick="deleteFile('authorization', `{{ array_key_exists('File Authorization', $availableFiles) && !empty($availableFiles['File Authorization']) ? $availableFiles['File Authorization']->id : false }}`)" style="display: {{ array_key_exists('File Authorization', $availableFiles) && !empty($availableFiles['File Authorization']) ? 'block' : 'none'; }}">
                                <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                </svg>
                            </button>
                            <embed src="{{ asset('storage/'.$availableFiles['File Authorization']->url) }}" width="100%" height="600px" type="application/pdf">
                            @endif
                        </div>
                        <div class="tab-pane fade text-center" id="market-research" role="tabpanel" aria-labelledby="market-research-tab">
                            <input type="file" name="market_research" id="file-market-research" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-market-research', 'market-research-tab', 'file-preview-market-research')">
                            <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-market-research').click();" style="display: {{ !empty($availableFiles['File Market Research']) ? 'none' : 'block' }}"><i class="fa-solid fa-upload"></i></button>
                            <div id="file-preview-market-research"></div>
                            @if(!empty($availableFiles['File Market Research']))
                            <button type="button" class="btn-delete" id="delete-market-research" onclick="deleteFile('market-research', `{{ $availableFiles['File Market Research']->id }}`)" style="display: {{ !empty($availableFiles['File Market Research']) ? 'block' : none; }}">
                                <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                </svg>
                            </button>
                            <embed src="{{ asset('storage/'.$availableFiles['File Market Research']->url) }}" width="100%" height="600px" type="application/pdf">
                            @endif
                        </div>

                        
                        @foreach ($otherFiles as $otherFile)
                            <div class="tab-pane fade text-center" id="{{ Str::slug($otherFile->name) }}" role="tabpanel" aria-labelledby="{{ Str::slug($otherFile->name) }}-tab">
                                <input type="file" name="market_research" id="file-{{ Str::slug($otherFile->name) }}" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-{{ Str::slug($otherFile->name) }}', '{{ Str::slug($otherFile->name) }}-tab', 'file-preview-{{ Str::slug($otherFile->name) }}')">
                                <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-{{ Str::slug($otherFile->name) }}').click();" style="display: {{ !empty($otherFile->name) ? 'none' : 'block' }}"><i class="fa-solid fa-upload"></i></button>
                                <div id="file-preview-{{ Str::slug($otherFile->name) }}"></div>
                                @if(!empty($otherFile->name))
                                    <button type="button" class="btn-delete" id="delete-{{ Str::slug($otherFile->name) }}" onclick="deleteFile('{{ Str::slug($otherFile->name) }}', `{{ $otherFile->id }}`)" style="display: {{ !empty($otherFile->name) ? 'block' : 'none' }}">
                                        <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                                        </svg>
                                    </button>
                                    <embed src="{{ asset('storage/'.$otherFile->url) }}" width="100%" height="600px" type="application/pdf">
                                @endif
                            </div>
                        @endforeach
                    
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tabCompany" role="tabpanel" aria-labelledby="company-tab">

                <form id="formCompany">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $bidding->name) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input type="text" name="company_cnpj" class="form-control mask-cnpj" value="{{ old('company_cnpj', $bidding->cnpj) }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço</label>
                                <input type="text" name="company_address" class="form-control" value="{{ old('company_address', $bidding->address) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" name="company_city" class="form-control" value="{{ old('company_city', $bidding->city) }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="company_state" class="form-control" value="{{ old('company_state', $bidding->state) }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>País</label>
                                <input type="text" name="company_country" class="form-control" value="{{ old('country', $bidding->country) }}" />
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

<style>
    .btn-plus-file {
        background-color: #47565d;
        padding: 5px;
        border: none;
        color: #fff;
        border-radius: 3px;
    }

    .btn-del-tab {
        border: none;
        background-color: transparent;
        font-weight: 900;
        color: tomato;
    }
</style>


<script>
    let formArray = [];
    let responsibleArray = [];
    let files = [];
    let filesToRemove = [];

    document.addEventListener('DOMContentLoaded', () => {
        //Load data FormArray
        const tableRows = document.querySelectorAll('#tabPublication table tbody tr');

        tableRows.forEach(row => {
            const date = row.querySelector('td:nth-child(1)').textContent;
            const type = row.querySelector('td:nth-child(2)').textContent;
            const description = row.querySelector('td:nth-child(3)').textContent;

            const formData = {
                date: date,
                type: type,
                description: description
            };

            formArray.push(formData);
        });

        updateTable(formArray, '#tabPublication');

        //Load data responsibleArray
        const tableRows2 = document.querySelectorAll('#tabResponsible table tbody tr');

        tableRows2.forEach(row => {
            const name = row.querySelector('td:nth-child(1)').textContent;
            const id = row.querySelector('td:nth-child(2)').textContent;
            const agente = row.querySelector('td:nth-child(3)').textContent;

            const formData = {
                responsibility_id: name,
                employee_id: id,
                employee_name: agente
            };

            responsibleArray.push(formData);
        });

        updateTable(responsibleArray, '#tabResponsible');
    });

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
        biddingData.append('filesToRemove', JSON.stringify(filesToRemove));

        files.forEach(fileData => {
            const fileId = Object.keys(fileData)[0];
            const file = fileData[fileId].file;
            biddingData.append(fileId, file);
        });
        biddingData.append('_method', 'PUT');
        const biddingSlug = document.querySelector('input[name="bidding_slug"]').value;
        axios.post(`/panel/biddings/${biddingSlug}`, biddingData, {
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

    function deleteFile(name, id = false) {
        // Remover o arquivo da variável files
        files = files.filter(file => Object.keys(file)[0] !== `file-${name}`);

        const filePreview = document.getElementById(`file-preview-${name}`);
        const deleteButton = document.getElementById(`delete-${name}`);
        const fileInput = document.getElementById(`file-${name}`);
        const uploadButton = document.querySelector(`[onclick="document.getElementById('file-${name}').click();"]`);

        //remover o embed inicial
        document.querySelector('#' + name + ' embed').remove();

        // Limpar a visualização do arquivo e reexibir o botão e o input de upload
        filePreview.innerHTML = '';
        deleteButton.style.display = 'none';
        fileInput.value = '';
        fileInput.style.display = 'none';
        uploadButton.style.display = 'inline-block';

        if (id) {
            filesToRemove.push(id);
        }
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
        } else {
            organElement.innerHTML = '<option value="">Selecione</option>';
            organElement.closest('.col-md-6').style.display = 'none';
        }

    }

    //Se tiver um orgão ele exibe
    document.addEventListener("DOMContentLoaded", () => {
        const secretaries = {!!json_encode($secretaries) !!};
        const selectSecretary = document.querySelector('select[name="secretary_id"]');

        if (selectSecretary.value !== '') {
            showOrgans({
                target: selectSecretary
            }, secretaries);
        }
    });

    function addNewTab() {
        // Crie um novo ID único para a nova guia
        var newTabId = 'new-tab-' + Date.now();

        // Crie um novo item de navegação (li) para a nova guia
        var newNavItem = document.createElement('li');
        newNavItem.className = 'nav-item';
        newNavItem.setAttribute('role', 'presentation');

        // Crie um novo botão dentro do item de navegação
        var newTabButton = document.createElement('button');
        newTabButton.className = 'nav-link';
        newTabButton.setAttribute('type', 'button');
        newTabButton.setAttribute('role', 'tab');
        newTabButton.setAttribute('aria-selected', 'false');

        // Crie um input de texto para o nome da guia
        var tabNameInput = document.createElement('input');
        tabNameInput.setAttribute('type', 'text');
        tabNameInput.setAttribute('placeholder', 'Nome do arquivo');

        // Adicione o input de texto ao botão
        newTabButton.appendChild(tabNameInput);

        var deleteButton = document.createElement('button');
        deleteButton.innerText = 'Excluir';
        deleteButton.classList.add('btn-del-tab'); // Adiciona a classe "btn-del-tab" ao botão

        // Adicione um ouvinte de evento de clique ao botão de exclusão
        deleteButton.addEventListener('click', function () {
            // Remova a guia e seu conteúdo
            var tabContentArea = document.querySelector('.tabFileNew');
            var tabToRemove = document.getElementById(newTabId);

            if (tabContentArea && tabToRemove) {
                tabContentArea.removeChild(tabToRemove);

                // Remova o item de navegação
                var tabList = document.querySelector('.tab-vertical');
                tabList.removeChild(newNavItem);
            }
        });

        // Adicione o botão de exclusão ao item de navegação
        newNavItem.appendChild(deleteButton);


        // Adicione o botão de exclusão ao item de navegação
        newNavItem.appendChild(deleteButton);

        // Adicione o novo botão ao item de navegação
        newNavItem.appendChild(newTabButton);

        // Adicione o item de navegação à lista de guias
        var tabList = document.querySelector('.tab-vertical');
        tabList.appendChild(newNavItem);

        // Adicione o evento de clique ao botão
        newTabButton.addEventListener('click', function () {
            // Formate o texto para torná-lo adequado como parte do ID
            var formattedText = tabNameInput.value.trim().replace(/\s+/g, '-').toLowerCase();

            // Verifique se o nome é fornecido
            if (formattedText.length > 0) {
                // Atualize o ID da guia
                newTabId = formattedText;

                // Atualize os atributos do botão
                newTabButton.setAttribute('data-bs-toggle', 'tab');
                newTabButton.setAttribute('data-bs-target', '#' + newTabId);
                newTabButton.setAttribute('aria-controls', newTabId);

                // Atualize o nome da guia
                newTabButton.innerText = formattedText || 'Nova Guia';

                // Crie uma nova guia na área de conteúdo
                var newTabContent = document.createElement('div');
                newTabContent.className = 'tab-pane fade text-center';
                newTabContent.id = newTabId;
                newTabContent.setAttribute('role', 'tabpanel');
                newTabContent.innerHTML = `
                    <div>
                        <input type="file" name="new_tab_file" id="file-${newTabId}" style="display: none;" accept=".pdf" onchange="sendFile(event, 'file-${newTabId}', '${newTabId}', 'file-preview-${newTabId}')">
                        <button class="btn btn-primary btn-new-file text-white" onclick="document.getElementById('file-${newTabId}').click();"><i class="fa-solid fa-upload"></i></button>
                        <div id="file-preview-${newTabId}"></div>
                    </div>
                `;

                // Adicione a nova guia à área de conteúdo
                var tabContentArea = document.querySelector('.tabFileNew');
                tabContentArea.appendChild(newTabContent);

                // Ative a nova guia
                newTabButton.click();
            }
        });
        
        tabNameInput.addEventListener('keydown', function (event) {
            if (event.keyCode === 32) {
                // Adicione um espaço ao valor do input em vez de prevenir o comportamento padrão
                var cursorPosition = tabNameInput.selectionStart;
                var inputValue = tabNameInput.value;

                // Insira um espaço na posição do cursor
                tabNameInput.value = inputValue.substring(0, cursorPosition) + ' ' + inputValue.substring(cursorPosition);

                // Mova o cursor para a posição após o espaço
                tabNameInput.setSelectionRange(cursorPosition + 1, cursorPosition + 1);

                // Impedir o evento padrão para evitar a adição do espaço pelo navegador
                event.preventDefault();
            }
        });
    }

</script>

@endsection