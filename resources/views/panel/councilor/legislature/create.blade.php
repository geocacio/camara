@extends('panel.index')
@section('pageTitle', 'Nova Legislatura')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><a href="{{ route('councilor.legislature.index', $councilor->slug) }}">{{ $councilor->name }}</a></li>
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
                        <label for="legislature_id">Legislatura</label>
                        <select name="legislature_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($legislatures->count() > 0)
                            @foreach($legislatures as $legislature)
                            <option value="{{$legislature->id}}">{{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }}</option>
                            @endforeach
                            @endif
                        </select>
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