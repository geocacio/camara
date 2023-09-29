@extends('panel.index')

@section('pageTitle', 'Pesquisa de Satisfação')

@section('breadcrumb')
<li><a href="{{ route('ombudsman-survey.index') }}">Pesquisa de satisfação</a></li>
<li><span>Página</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('ombudsman.survey.page.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Título Principal</label>
                <input type="text" name="main_title" class="form-control" value="{{ old('main_title', $ombudsman_survey->main_title) }}" />
            </div>
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $ombudsman_survey->title) }}" />
            </div>
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $ombudsman_survey->description) }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection