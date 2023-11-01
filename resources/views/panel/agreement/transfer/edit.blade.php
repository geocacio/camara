@extends('panel.index')

@section('pageTitle', 'Atualizar Repasse')

@section('breadcrumb')
<li><a href="{{ route('agreements.index') }}">Convênios</a></li>
<li><a href="{{ route('agreements.transfer.index', $agreement->slug) }}">Repasses</a></li>
<li><span>Atualizar</span></li>
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

        <form action="{{ route('agreements.transfer.update', ['agreement' => $agreement->slug, 'transfer' => $transfer->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label>Data pagamento Proponente</label>
                        <input type="date" name="date_proponent" class="form-control" value="{{ old('date_proponent', $transfer->date_proponent) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor proponente</label>
                        <input type="text" name="value_proponent" class="form-control mask-currency" value="{{ old('value_proponent', $transfer->value_proponent) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label>Data pagamento Concedente</label>
                        <input type="date" name="date_concedent" class="form-control" value="{{ old('date_concedent', $transfer->date_concedent) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Valor concedente</label>
                        <input type="text" name="value_concedent" class="form-control mask-currency" value="{{ old('value_concedent', $transfer->value_concedent) }}" />
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