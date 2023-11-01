@extends('panel.index')
@section('pageTitle', 'Atualizar Convênio')

@section('breadcrumb')
<li><a href="{{ route('agreements.index') }}">Convênios</a></li>
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
        <form id="formAgreement"action="{{ route('agreements.update', $agreement->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Esfera</label>
                        <select name="sphere" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Municipal" {{ $agreement->sphere == 'Municipal' ? 'selected' : '' }}>Municipal</option>
                            <option value="Estadual" {{ $agreement->sphere == 'Estadual' ? 'selected' : '' }}>Estadual</option>
                            <option value="Federal" {{ $agreement->sphere == 'Federal' ? 'selected' : '' }}>Federal</option>
                            <option value="Iniciativa privada" {{ $agreement->sphere == 'Iniciativa privada' ? 'selected' : '' }}>Iniciativa privada</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Vigência</label>
                        <input type="date" name="validity" class="form-control" value="{{ old('validity', $agreement->validity) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Celebração</label>
                        <input type="date" name="celebration" class="form-control" value="{{ old('celebration', $agreement->celebration) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Objeto</label>
                <textarea name="object" class="form-control">{{ old('object', $agreement->object) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Conta bancária</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account', $agreement->bank_account) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número da conta</label>
                        <input type="number" name="instrument_number" class="form-control" value="{{ old('instrument_number', $agreement->instrument_number) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Contrapartida</label>
                        <input type="text" name="counterpart" class="form-control mask-currency" value="{{ old('counterpart', $agreement->counterpart) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Transferência</label>
                        <input type="text" name="transfer" class="form-control mask-currency" value="{{ old('transfer', $agreement->transfer) }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pactuada</label>
                        <input type="text" name="agreed" class="form-control mask-currency" value="{{ old('agreed', $agreement->agreed) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Concedente</label>
                        <input type="text" name="grantor" class="form-control" value="{{ old('grantor', $agreement->grantor) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Concedente responsável</label>
                        <input type="text" name="grantor_responsible" class="form-control" value="{{ old('grantor_responsible', $agreement->grantor_responsible) }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Convenente</label>
                        <input type="text" name="convenent" class="form-control" value="{{ old('convenent', $agreement->convenent) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Convenente responsável</label>
                        <input type="text" name="convenent_responsible" class="form-control" value="{{ old('convenent_responsible', $agreement->convenent_responsible) }}" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Justificação</label>
                <textarea name="justification" class="form-control">{{ old('justification', $agreement->justification) }}</textarea>
            </div>

            <div class="form-group">
                <label>Metas</label>
                <textarea name="goals" class="form-control">{{ old('goals', $agreement->goals) }}</textarea>
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