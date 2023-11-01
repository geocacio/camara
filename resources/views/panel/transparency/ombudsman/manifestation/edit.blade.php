@extends('panel.index')

@section('pageTitle', 'Responder Manifestação')
@section('breadcrumb')
<li><a href="{{ route('ombudsman-feedback.index') }}">Manifestações</a></li>
<li><span>Responder Manifestação</span></li>
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

        <form action="{{ route('ombudsman-feedback.update', $ombudsmanFeedback->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pergunta</label>
                <input type="text" name="question" class="form-control" value="{{ old('question', $ombudsmanFeedback->message) }}" disabled/>
            </div>

            <div class="form-group">
                <label>Resposta</label>
                <textarea name="answer" class="form-control">{{ old('answer', $ombudsmanFeedback->answer) }}</textarea>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection