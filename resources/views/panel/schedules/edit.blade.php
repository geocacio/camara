@extends('panel.index')

@section('pageTitle', 'Nova agenda')
@section('breadcrumb')
<li><a href="{{ route('schedules.index') }}">Orgãos</a></li>
<li><span>Nova agenda</span></li>
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

        <form action="{{ route('schedules.update', $schedule->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $schedule->title) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data e hora</label>
                        <input type="datetime-local" name="date" class="form-control" value="{{ old('date', $schedule->date) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Local</label>
                        <input type="text" name="local" class="form-control" value="{{ old('local', $schedule->local) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Tipo</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Reunião">Reunião</option>
                            <option value="Inauguração">Inauguração</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description', $schedule->description) }}</textarea>
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