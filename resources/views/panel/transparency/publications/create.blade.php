@extends('panel.index')
@section('pageTitle', 'Nova publicação')

@section('breadcrumb')
<li><a href="{{ route('all-publications.index') }}">Publicações</a></li>
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
        @if($secretaries->count() > 0)
        <form action="{{ route('all-publications.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o grupo</label>
                        <select name="group_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($groups->children as $group)
                            <option value="{{ $group->id}}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o tipo</label>
                        <select name="type_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione a competência</label>
                        <select name="competency_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($competencies->children as $competency)
                            <option value="{{ $competency->id}}">{{ $competency->name }}</option>
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}" />
            </div>

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="file" accept="application/pdf" class="form-control" multiple>
            </div>

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" checked>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

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