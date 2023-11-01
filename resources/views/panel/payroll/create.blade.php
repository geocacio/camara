@extends('panel.index')
@section('pageTitle', 'Nova Folha de pagamento')

@section('breadcrumb')
<li><a href="{{ route('payrolls.index') }}">Folhas de pagamento</a></li>
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
        <form action="{{ route('payrolls.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Selecione o Exercício</label>
                        <select name="exercicy_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($exercicies->children as $exercicy)
                            <option value="{{ $exercicy->id}}">{{ $exercicy->name }}</option>
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
                            <option value="{{ $competency->id}}">{{ $competency->name }}</option>
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
                            <option value="{{ $typeLeaf->id}}">{{ $typeLeaf->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row displayEarnings">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Proventos</label>
                        <select name="calculate_earnings" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayEarnings')">
                            <option value="yes">Gerar valor automaticamente</option>
                            <option value="no">Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="form-group">
                        <label>Adicionar Proventos</label>
                        <input type="text" name="earnings" class="form-control mask-currency" value="{{ old('earnings') }}" />
                    </div>
                </div>
            </div>            

            <div class="row displayDeductions">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descontos</label>
                        <select name="calculate_deductions" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayDeductions')">
                            <option value="yes">Gerar valor automaticamente</option>
                            <option value="no">Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="form-group">
                        <label>Adicionar Descontos</label>
                        <input type="text" name="deductions" class="form-control mask-currency" value="{{ old('deductions') }}" />
                    </div>
                </div>
            </div>            

            <div class="row displayNetPay">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Valor Líquido</label>
                        <select name="calculate_net_pay" class="form-control change" onchange="splitAndDisplayMoreColumn(event, '.displayNetPay')">
                            <option value="yes">Gerar valor automaticamente</option>
                            <option value="no">Inserir valor manualmente</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="form-group">
                        <label>Adicionar Valor Líquido</label>
                        <input type="text" name="net_pay" class="form-control mask-currency" value="{{ old('net_pay') }}" />
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