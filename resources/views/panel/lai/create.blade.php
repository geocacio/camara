@extends('panel.index')

@section('pageTitle', 'Página Lai')

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

        <form action="{{ route('lai.update', $lai->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon') }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Grupo (onde será exibido no portal da transparência)</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione o grupo</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->title }} - {{ $group->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Regulamentação da lai estadual (url)</label>
                        <input type="url" name="state_lai" class="form-control" value="{{ old('state_lai') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Regulamentação da lai federal (url)</label>
                        <input type="url" name="federal_lai" class="form-control" value="{{ old('federal_lai') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Explicação da LAI</label>
                        <textarea name="description_lai" class="form-control">{{ old('description_lai') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade modal-icon-list" id="modalIconList" tabindex="-1" role="dialog" aria-labelledby="iconListModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="iconListModalTitle">Escolha seu ícone</h5>
                <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('panel.partials.iconLists')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection