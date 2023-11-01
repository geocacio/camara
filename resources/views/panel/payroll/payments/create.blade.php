@extends('panel.index')
@section('pageTitle', 'Novo pagamento')

@section('breadcrumb')
<li><a href="{{ route('payrolls.index') }}">Folhas de Pagamento</a></li>
<li><a href="{{ route('payrolls.show', $payroll->slug) }}">Pagamentos de {{ $payroll->competency->name }}/{{ $payroll->exercicy->name }}</a></li>
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
        <form action="{{ route('payments.store', $payroll->slug) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Selecione o Funcionário</label>
                        <select name="employee_id" class="form-control">
                            <option value="">Selecione</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id}}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Proventos</label>
                        <input type="text" name="earnings" class="form-control mask-currency" value="{{ old('earnings') }}" />
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descontos</label>
                        <input type="text" name="deductions" class="form-control mask-currency" value="{{ old('deductions') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Salário líquido</label>
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