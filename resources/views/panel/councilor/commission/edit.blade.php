@extends('panel.index')
@section('pageTitle', 'Atualizar Comissão')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><a href="{{ route('councilor-commissions.index', $councilor->slug) }}">Comissões</a></li>
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
        <form action="{{ route('councilor-commissions.update', ['councilor' => $councilor->slug, 'councilor_commission' => $councilor_commission->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="commission_id">Comissão</label>
                        <select name="commission_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($commissions->count() > 0)
                            @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}" {{ $commission->id == $councilor_commission->commission_id ? 'selected' : ''}}>{{ $commission->description }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="legislature_id">Legislatura</label>
                        <select name="legislature_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($legislatures->count() > 0)
                            @foreach($legislatures as $legislature)
                            <option value="{{ $legislature->id }}" {{ $legislature->id == $councilor_commission->legislature_id ? 'selected' : ''}}>{{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de Início</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $councilor_commission->start_date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de Fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $councilor_commission->end_date) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="office_id">Cargo</label>
                        <select name="office_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($offices->count() > 0)
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}" {{ $office->id == $councilor_commission->office_id ? 'selected' : ''}}>{{ $office->office }}</option>
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