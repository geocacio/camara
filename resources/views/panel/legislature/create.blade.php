@extends('panel.index')
@section('pageTitle', 'Nova Legislatura')

@section('breadcrumb')
<li><a href="{{ route('legislatures.index') }}">Legislaturas</a></li>
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
        <form action="{{ route('legislatures.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de início</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" />
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