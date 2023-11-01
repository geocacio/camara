@extends('panel.index')
@section('pageTitle', 'Nova portaria')

@section('breadcrumb')
<li><a href="{{ route('ordinances.index') }}">Portarias</a></li>
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
        <form action="{{ route('ordinances.store') }}" method="post" enctype="multipart/form-data">
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
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
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
                        <label for="title1">Selecione o tipo</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id}}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
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

            <div class="form-group">
                <label for="logo">Arquivo</label>
                <input type="file" name="files[]" accept="application/pdf" class="form-control" multiple>
            </div>
            <div class="form-group">
                <label>Detalhes</label>
                <textarea name="detail" class="form-control">{{ old('detail') }}</textarea>
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