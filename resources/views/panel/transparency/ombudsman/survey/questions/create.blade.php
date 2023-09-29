@extends('panel.index')
@section('pageTitle', 'Adicionar Pergunta')

@section('breadcrumb')
<li><a href="{{ route('ombudsman-survey.index') }}">Pesquisa de satisfação</a></li>
<li><a href="{{ route('ombudsman-survey-questions.index') }}">Perguntas</a></li>
<li><span>Adicionar Pergunta</span></li>
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

        <form class="form-multple-items" action="{{ route('ombudsman-survey-questions.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label>Pergunta</label>
                <input type="text" name="question_text" class="form-control" autocomplete="off" value="{{ old('question_text') }}">
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection