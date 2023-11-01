@extends('panel.index')

@section('pageTitle', 'Novo Progresso')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><a href="{{ route('biddings.progress.index', $bidding->slug) }}">Progressos</a></li>
<li><span>Novo Progresso</span></li>
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

        <form action="{{ route('progress.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bidding_id" value="{{$bidding->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data e hora</label>
                        <input type="datetime-local" name="datetime" class="form-control" value="{{ old('datetime') }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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