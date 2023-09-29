@extends('panel.index')
@section('pageTitle', 'Licitações')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('biddings.create') }}" class="btn-default">Novo</a>
        </div>


        @if($biddings && $biddings->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-with-dropdown">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Número</th>
                        <th>Data da abertura</th>
                        <th>Valor estimado</th>
                        <th>Status</th>
                        <th class="text-center">Empresa</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($biddings as $bidding)
                    <tr>
                        <td>{{ $bidding->id }}</td>
                        <td>{{ $bidding->number }}</td>
                        <td>{{ $bidding->opening_date }}</td>
                        <td>{{ $bidding->estimated_value ? 'R$ '.number_format($bidding->estimated_value, 2, ',', '.') : '' }}</td>
                        <td>{{ $bidding->status }}</td>
                        <td class="actions text-center">
                            @if($bidding->company)
                            {{ $bidding->company->name }}
                            @else
                            <a href="{{ route('biddings.company.create', $bidding->slug) }}" class="link create"><i class="fa-solid fa-plus"></i></a>
                            @endif
                        </td>
                        <td class="actions text-right">

                            <div class="dropdown">
                                <a class="link create" href="#" role="button" id="dropdownMenuLink7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-gear"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if($bidding->company)
                                    <a class="dropdown-item" href="{{ route('biddings.company.contracts.index', $bidding->slug) }}">Contratos</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('biddings.progress.index', $bidding->slug) }}">Andamento</a>
                                    <a class="dropdown-item" href="{{ route('biddings.responsibilities.index', $bidding->slug) }}">Responsabilidades</a>
                                    <a class="dropdown-item" href="{{ route('biddings.publications.index', $bidding->slug) }}">Forma de Publicação</a>
                                    <a class="dropdown-item" href="{{ route('biddings.available.files.index', $bidding->slug) }}">Arquivos</a>
                                    <a class="dropdown-item" href="{{ route('biddings.edit', $bidding->slug) }}">Editar</a>
                                    <a class="dropdown-item" data-toggle="modal" data-target="#myModal{{$bidding->id}}" href="#">Excluir</a>
                                </div>
                            </div>
                            <!-- <a href="{{ route('biddings.edit', $bidding->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$bidding->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a> -->

                            <div id="myModal{{$bidding->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $bidding->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $bidding->id }}" action="{{ route('biddings.destroy', $bidding->slug) }}" method="post" style="display: none;">
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
            <span>Ainda não existem Licitações cadastradas.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
<script>
    const options = document.querySelectorAll('.btn-table-options');
    options.forEach(option => {
        option.addEventListener('click', e => {
            let menu = document.querySelector('div[aria-labelledby="' + e.target.getAttribute('id') + '"]');
            console.log(menu.classList.contains('show'));
            // e.target.closest('.table-responsive').
        });
    });
</script>
@endsection