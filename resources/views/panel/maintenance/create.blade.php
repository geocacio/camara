@extends('panel.index')
@section('pageTitle', 'Novo Alerta')

@section('breadcrumb')
<li><a href="{{ route('maintenance.index') }}">Alertas</a></li>
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
        <form action="{{ route('maintenance.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="logo">Título</label>
                <input type="text" name="title" placeholder="Título" value="{{ old('title') }}" class="form-control">
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Texto</label>
                        <textarea name="text" class="form-control">{{ old('text') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="logo">Mais informações</label>
                <input type="text" name="more_info" placeholder="Mais informações" value="{{ old('more_info') }}" class="form-control">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>De:</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label>Até:</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" />
                        </div>
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