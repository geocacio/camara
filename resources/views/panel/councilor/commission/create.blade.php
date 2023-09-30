@extends('panel.index')
@section('pageTitle', 'Nova Comissão')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><a href="{{ route('commissions.index', 'vereador') }}">Comissões</a></li>
<li><span>Nova</span></li>
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
        <form action="#" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="office">Cargo</label>
                        <select name="office" class="form-control">
                            <option value="">Selecione</option>
                            <option value="">Vice Presidente</option>
                            <option value="">Vereador (a)</option>
                            <option value="">1º Secretário</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de criação</label>
                        <input type="date" name="creation_date" class="form-control" value="{{ old('creation_date') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de conclusão</label>
                        <input type="date" name="conclusion_date" class="form-control" value="{{ old('conclusion_date') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Informação</label>
                        <textarea name="information" class="form-control">{{ old('information') }}</textarea>
                    </div>
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