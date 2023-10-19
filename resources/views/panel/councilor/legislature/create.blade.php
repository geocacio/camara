@extends('panel.index')
@section('pageTitle', 'Nova Legislatura de '.$councilor->name)

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
        <form action="{{ route('councilor.legislature.store', $councilor->slug) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-2">
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
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="office_id">Cargo Atual</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->office }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="bond_id">Vínculo atual</label>
                        <select name="bond_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($bonds->children as $bond)
                            <option value="{{ $bond->id }}">{{ $bond->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Período inicial</label>
                        <input type="date" name="first_period" class="form-control" value="{{ old('first_period') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Período final</label>
                        <input type="date" name="final_period" class="form-control" value="{{ old('final_period') }}" />
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