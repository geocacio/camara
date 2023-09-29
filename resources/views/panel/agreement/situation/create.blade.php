@extends('panel.index')
@section('pageTitle', 'Novo Andamento')

@section('breadcrumb')
<li><a href="{{ route('agreements.index') }}">Convênios</a></li>
<li><a href="{{ route('agreements.situations', $agreement->slug) }}">Andamentos</a></li>
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
        <form action="{{ route('agreements.situations.store', $agreement->slug) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Situação</label>
                        <select name="situation" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Prestação de Contas">Prestação de Contas</option>
                            <option value="Aguardando">Aguardando</option>
                            <option value="Iniciado">Iniciado</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Andamento">Andamento</option>
                        </select>
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

<script>
    const form = document.querySelector('#formAgreement');
    form.addEventListener('submit', e => {
        e.preventDefault();
        let counterpart = form.querySelector('input[name="counterpart"]');
        counterpart.value = counterpart.value != '' ? counterpart.value : 'R$ 00,0';

        let transfer = form.querySelector('input[name="transfer"]');
        transfer.value = transfer.value != '' ? transfer.value : 'R$ 00,0';

        let agreed = form.querySelector('input[name="agreed"]');
        agreed.value = agreed.value != '' ? agreed.value : 'R$ 00,0';

        form.submit();
    });
</script>

@endsection