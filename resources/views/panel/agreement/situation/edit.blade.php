@extends('panel.index')
@section('pageTitle', 'Atualizar Andamento')

@section('breadcrumb')
<li><a href="{{ route('agreements.index') }}">Convênios</a></li>
<li><a href="{{ route('agreements.situations', $agreement->slug) }}">Andamentos</a></li>
<li><span>Atualizar</span></li>
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
        <form action="{{ route('agreements.situations.update', ['agreement' => $agreement->slug, 'general_progress' => $general_progress->id]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $general_progress->date) }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Situação</label>
                        <select name="situation" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Prestação de Contas" {{ $general_progress->sitation == 'Prestação de Contas' ? 'selected' : '' }}>Prestação de Contas</option>
                            <option value="Aguardando" {{ $general_progress->situation == 'Aguardando' ? 'selected' : '' }}>Aguardando</option>
                            <option value="Iniciado" {{ $general_progress->situation == 'Iniciado' ? 'selected' : '' }}>Iniciado</option>
                            <option value="Finalizado" {{ $general_progress->situation == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            <option value="Andamento" {{ $general_progress->situation == 'Andamento' ? 'selected' : '' }}>Andamento</option>
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