@extends('panel.index')
@section('pageTitle', 'Vouchers')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div class="card-header text-right header-with-search">
            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('vouchers.index') }}">Página</a>
                    <a class="dropdown-item" href="{{ route('vouchers.create') }}">Novo</a>
                </div>
            </div>
        </div>

        @if($vouchers && $vouchers->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número do Voucher</th>
                        <th>Data</th>
                        <th>Fornecedor</th>
                        <th>Valor</th>
                        <th>Organização</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td>{{ $voucher->voucher_number }}</td>
                        <td>{{ date('d/m/Y', strtotime($voucher->voucher_date)) }}</td>
                        <td>{{ $voucher->supplier }}</td>
                        <td>{{ number_format($voucher->amount, 2, ',', '.') }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $voucher->organization)) }}</td>
                        <td class="actions text-center">
                            <div class="dropdown">
                                <a class="link create" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('expenses.index', $voucher->id) }}">Pagamentos</a>
                                    <a class="dropdown-item" href="{{ route('liquidation.index', $voucher->id) }}">Liquidações</a>
                                    <a class="dropdown-item" href="{{ route('vouchers.edit', $voucher->id) }}">Editar</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal{{$voucher->id}}" href="#">Excluir</a>
                                </div>
                            </div>

                            <div id="deleteModal-{{ $voucher->id }}" class="modal fade modal-warning" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <span class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon">
                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                                </svg>
                                            </span>
                                            <span class="title">Você tem certeza?</span>
                                            <span class="message">Você realmente quer apagar este voucher?<br> Esta ação não poderá ser desfeita.</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('delete-form-{{ $voucher->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $voucher->id }}" action="{{ route('vouchers.destroy', $voucher->id) }}" method="post" style="display: none;">
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
            <span>Ainda não existem vouchers cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
@endsection
