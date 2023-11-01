@extends('panel.index')
@section('pageTitle', 'Pagamentos de '. $payroll->competency->name.'/'.$payroll->exercicy->name)

@section('breadcrumb')
<li><a href="{{ route('payrolls.index') }}">Folhas de Pagamento</a></li>
<li><span>Pagamentos de {{ $payroll->competency->name }}/{{ $payroll->exercicy->name }}</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('payments.create', $payroll->slug) }}">Novo</a>
                    <a class="dropdown-item" href="{{ route('payments.export.model', $payroll->slug) }}">Exportar modelo</a>
                    <a class="dropdown-item" href="{{ route('payments.export', $payroll->slug) }}">Exportar dados</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalImport">Importar dados</a>
                </div>
            </div>
        </div>

        @if($payroll->payments && $payroll->payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Funcionário</th>
                        <th>Proventos</th>
                        <th>Descontos</th>
                        <th>Líquido</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payroll->payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->employee->name }}</td>
                        <td>{{ $payment->earnings }}</td>
                        <td>{{ $payment->deductions }}</td>
                        <td>{{ $payment->net_pay }}</td>
                        <td class="actions">
                            <a href="{{ route('payments.edit', ['payroll' => $payroll->slug, 'payment' => $payment->slug]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$payment->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$payment->id}}" class="modal fade modal-warning" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <span class="icon" data-v-988dbcee=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon" data-v-988dbcee="">
                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" data-v-988dbcee=""></polygon>
                                                    <line x1="12" y1="8" x2="12" y2="12" data-v-988dbcee=""></line>
                                                    <line x1="12" y1="16" x2="12.01" y2="16" data-v-988dbcee=""></line>
                                                </svg></span>
                                            <span class="title">Você tem certeza?</span>
                                            <span class="message">Você realmente quer apagar este item?<br> Esta ação não poderá ser desfeita.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $payment->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $payment->id }}" action="{{ route('payments.destroy', ['payroll' => $payroll->slug, 'payment' => $payment->slug]) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>Ainda não existem Pagamentos cadastradas.</span>
        </div>
        @endif

    </div>
</div>

<div id="modalImport" class="modal fade modal-import" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <!-- <span class="icon">
                    <i class="fa-solid fa-upload"></i>
                </span> -->

                <span class="title">Importar dados</span>

                <form id="formImport" action="{{ route('payments.import', $payroll->slug) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Selecione o arquivo para importação</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>

                <a href="#" class="btn btn-import" onclick="event.preventDefault();
                    document.getElementById('formImport').submit();">
                    <i class="fa-solid fa-upload"></i> Importar
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
@endsection