@extends('panel.index')
@section('pageTitle', 'Atualizar Folha de pagamento')

@section('breadcrumb')
<li><a href="{{ route('payrolls.index') }}">Folhas de pagamento</a></li>
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
        <form action="{{ route('payrolls.update', $payroll->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Selecione o Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}" {{ $exercicy->id == $payroll->exercicy->id ? 'selected' : '' }}>{{ $exercicy->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Selecione a Competência</label>
                        <select name="competency_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($competencies->children as $competency)
                            <option value="{{ $competency->id}}" {{ $competency->id == $payroll->competency->id ? 'selected' : '' }}>{{ $competency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Selecione o Tipo de folha</label>
                        <select name="type_leaf_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($typeLeafs->children as $typeLeaf)
                            <option value="{{ $typeLeaf->id}}" {{ $typeLeaf->id == $payroll->typeLeaf->id ? 'selected' : '' }}>{{ $typeLeaf->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row displayEarnings">
                <div class="{{ $payroll->calculate_earnings == 'yes' ? 'col-md-12' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Proventos</label>
                        <select name="calculate_earnings" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayEarnings')">
                            <option value="yes" {{ $payroll->calculate_earnings == 'yes' ? 'selected' : ''}}>Gerar valor automaticamente</option>
                            <option value="no" {{ $payroll->calculate_earnings == 'no' ? 'selected' : ''}}>Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="{{ $payroll->calculate_earnings == 'yes' ? 'col-md-6 d-none' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Adicionar Proventos</label>
                        <input type="text" name="earnings" class="form-control mask-currency" value="{{ old('earnings', $payroll->earnings) }}" />
                    </div>
                </div>
            </div>

            <div class="row displayDeductions">
                <div class="{{ $payroll->calculate_deductions == 'yes' ? 'col-md-12' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Descontos</label>
                        <select name="calculate_deductions" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayDeductions')">
                            <option value="yes" {{ $payroll->calculate_deductions == 'yes' ? 'selected' : ''}}>Gerar valor automaticamente</option>
                            <option value="no" {{ $payroll->calculate_deductions == 'no' ? 'selected' : ''}}>Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="{{ $payroll->calculate_deductions == 'yes' ? 'col-md-6 d-none' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Adicionar Descontos</label>
                        <input type="text" name="deductions" class="form-control mask-currency" value="{{ old('deductions', $payroll->deductions) }}" />
                    </div>
                </div>
            </div>

            <div class="row displayNetPay">
                <div class="{{ $payroll->calculate_net_pay == 'yes' ? 'col-md-12' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Valor Líquido</label>
                        <select name="calculate_net_pay" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayNetPay')">
                            <option value="yes" {{ $payroll->calculate_net_pay == 'yes' ? 'selected' : ''}}>Gerar valor automaticamente</option>
                            <option value="no" {{ $payroll->calculate_net_pay == 'no' ? 'selected' : ''}}>Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="{{ $payroll->calculate_net_pay == 'yes' ? 'col-md-6 d-none' : 'col-md-6'}}">
                    <div class="form-group">
                        <label>Adicionar Valor Líquido</label>
                        <input type="text" name="net_pay" class="form-control mask-currency" value="{{ old('net_pay', $payroll->net_pay) }}" />
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