@extends('panel.index')

@section('pageTitle', 'Atualizar contrato')
@section('breadcrumb')
<li><a href="{{ route('biddings.company.contracts.index', $bidding->slug) }}">Contratos</a></li>
<li><span>Atualizar contrato</span></li>
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

        <form action="{{ route('biddings.company.contracts.update', ['bidding' => $bidding->slug, 'id' => $contract->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            @if($contract)
            <input type="hidden" name="parent_id" value="{{$contract->parent_id}}">
            @endif

            <div class="row">                
                <input type="hidden" name="company_id" value="{{$bidding->company->id}}">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Tipo de contrato</label>
                        {{-- <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}" {{$type->id == $contract->types[0]->id ? 'selected' : ''}}>{{ $type->name }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="number" name="number" class="form-control" value="{{ old('number', $contract->number) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $contract->start_date) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $contract->end_date) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Valor total</label>
                <input type="text" name="total_value" class="form-control mask-currency" value="{{ old('total_value', $contract->total_value ? number_format($contract->total_value / 100, 2, ',', '.') : '') }}" />
            </div>

            <div class="form-group">
                <label>Selecione um fiscal de contrato</label>
                <select required name="inspector_id" class="form-control" {{ $types->count() <= 0 ? 'disabled' : '' }}>
                    <option value="">Selecione</option>
                    @foreach ($inspectors as $inspector)
                        <option value="{{ $inspector->id }}" {{ optional($inspector->inspectorContracts)->contract_id == $contract->id ? 'selected' : '' }}>
                            {{ $inspector->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $contract->description) }}</textarea>
            </div>

            
            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
                </div>
                <div class="col-6 pt-30 container-all-files">
                    @if ($contract->files->count() > 0)
                    {{-- @foreach($contract->files as $contract->files) --}}
                    @if (in_array(pathinfo($contract->files->file->url, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx']))
                    <div class="container-file">
                        <a href="#" class="btn btn-link" data-toggle="modal" data-target="#file-{{ $contract->files->file->id }}">{{ pathinfo($contract->files->file->url, PATHINFO_FILENAME) }}</a>
                        <button class="btn-delete" onclick="deleteFile(event, 'container-file', '/panel/files/{{$contract->files->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @elseif (in_array(pathinfo($contract->files->file->url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif', 'webp']))
                    <div class="conatiner-temp-image mt-3 {{ $contract->files->count() <= 0 ? 'hide' : ''}}">
                        <img class="image" src="{{ asset('storage/'.$contract->files->file->url) }}" />
                        <button class="btn-delete" onclick="deleteFile(event, 'conatiner-temp-image', '/panel/files/{{$contract->files->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                    </div>
                    @endif

                    <div class="modal fade modal-preview-file" id="file-{{ $contract->files->file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($contract->files->file->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$contract->files->file->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($contract->files->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$contract->files->file->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- @endforeach --}}
                    @else
                    <span class="no-file-info">Nenhum arquivo encontrado.</span>
                    @endif
                </div>

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

@endsection