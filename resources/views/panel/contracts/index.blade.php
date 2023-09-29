@extends('panel.index')
@section('pageTitle', 'Contratos')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('biddings.company.contracts.create', $bidding->slug) }}" class="btn-default">Novo</a>
        </div>

        @if($contracts && $contracts->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número</th>
                        <th>Empresa</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableAccordion">
                    @foreach($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        @if($contract->children->count() > 0)
                        <td class="cursor-pointer td-accordion" data-bs-toggle="collapse" data-bs-target="#accordion-{{$contract->id}}" aria-expanded="true" aria-controls="accordion-{{$contract->id}}">
                            <div class="d-flex align-items-center justify-content-between"><span>{{ $contract->number }}</span><i class="fa-sharp fa-solid fa-chevron-down"></i></div>
                        </td>
                        @else
                        <td>{{ $contract->number }}</td>
                        @endif
                        <td>{{ $contract->company->name }}</td>
                        <td class="actions">
                            <a href="{{ route('biddings.company.contracts.edit', ['bidding' => $bidding->slug, 'id' => $contract->id]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$contract->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$contract->id}}" class="modal fade modal-warning" role="dialog">
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
                                            document.getElementById('delete-form-{{ $contract->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $contract->id }}" action="{{ route('biddings.company.contracts.destroy', ['bidding' => $bidding->slug, 'id' => $contract->id]) }}" method="post" style="display: none;">
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
            <span>Ainda não existem Contratos cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
@endsection