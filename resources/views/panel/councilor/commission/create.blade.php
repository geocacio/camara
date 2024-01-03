@extends('panel.index')
@section('pageTitle', 'Nova Comissão')

@section('breadcrumb')
<li><a href="{{ route('councilors.index') }}">Vereadores</a></li>
<li><a href="{{ route('commissions.index', 'vereador') }}">Comissões</a></li>
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
        <form action="{{ route('councilor-commissions.store', $councilor->slug) }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="commission_id">Comissão</label>
                        <select name="commission_id" class="form-control">
                            <option value="">Selecione</option>
                            @if($commissions->count() > 0)
                            @foreach($commissions as $commission)
                            <option value="{{ $commission->id }}">{{ $commission->description }}</option>
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
                            <option value="{{ $legislature->id }}">{{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }}</option>
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
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data de Fim</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" />
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
                                    <option value="{{ $office->id }}">{{ $office->office }}</option>
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