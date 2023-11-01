@extends('panel.index')
@section('pageTitle', 'Solicitações')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <!-- <a href="{{ route('solicitations.create') }}" class="btn-default">Novo</a> -->
        </div>

        @if($solicitations && $solicitations->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Protocolo</th>
                        <th>Situação</th>
                        <th>Prazo</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitations as $solicitation)
                    <tr>
                        <td>{{ $solicitation->id }}</td>
                        <td>{{ $solicitation->protocol }}</td>
                        <td><span class="text-alert {{ $solicitation->status == 'Finalizado' ? 'answered' : 'waiting' }}">{{ $solicitation->situations[0]->situation }}</span></td>
                        <td class="actions">{{ $solicitation->latestResponseTime->response_deadline }}
                            <a data-toggle="modal" data-target="#changeDeadline{{$solicitation->id}}" class="link see" title="Adiar"><i class="fa-solid fa-clock"></i></a>

                            <div id="changeDeadline{{$solicitation->id}}" class="modal fade modal-warning" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                        <form id="formDeadline-{{ $solicitation->id }}" action="{{ route('sic.solicitation.deadline', $solicitation->slug) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label>Novo prazo</label>
                                                <input type="date" name="response_deadline" class="form-control" value="{{ old('response_deadline') }}">
                                            </div>
                                        </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('formDeadline-{{ $solicitation->id }}').submit();">
                                                Enviar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td class="actions text-right">
                            @if($solicitation->status != 'Finalizado')
                            <a href="{{ route('solicitations.edit', $solicitation->id) }}" class="link reply"><i class="fa-solid fa-reply"></i></a>
                            @endif
                            <a data-toggle="modal" data-target="#showSolicitation{{$solicitation->id}}" class="link see"><i class="fa-solid fa-eye"></i></a>
                            <!-- Permitir somente o admin apagar a manifestação -->
                            @if($user->id == 1)
                            <a data-toggle="modal" data-target="#myModal{{$solicitation->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                            <div id="myModal{{$solicitation->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $solicitation->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $solicitation->id }}" action="{{ route('solicitations.destroy', $solicitation->id) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="showSolicitation{{$solicitation->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="container-manifestation-result">
                                                <h3 class="title">{{ $solicitation->user->name }}</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="item">
                                                            <span class="label">{{ $solicitation->user->cpf ? 'CPF:' : 'CNPJ:' }}</span>
                                                            <span class="value">{{ $solicitation->user->cpf ? $solicitation->user->cpf : $solicitation->user->cnpj }}</span>
                                                        </div>

                                                        <div class="item">
                                                            <span class="label">E-mail: </span>
                                                            <span class="value">{{ $solicitation->user->email }}</span>
                                                        </div>

                                                        <div class="item">
                                                            <span class="label">Telefone: </span>
                                                            <span class="value">{{ $solicitation->user->phone }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="item">
                                                            <span class="label">Nascimento: </span>
                                                            <span class="value">{{ $solicitation->user->birth }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Sexo: </span>
                                                            <span class="value">{{ __($solicitation->user->sex) }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Protocolo: </span>
                                                            <span class="value">{{ $solicitation->protocol }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Situação: </span>
                                                            <span class="value">{{ $solicitation->situations[0]->situation }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Solicitação:</strong></span>
                                                        <p class="message">{{ $solicitation->solicitation }}</p>
                                                    </div>
                                                    @if($solicitation->answer)
                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Resposta:</strong></span>
                                                        <p class="message">{{ $solicitation->answer }}</p>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>Ainda não existem solicitações cadastradas.</span>
        </div>
        @endif

    </div>
</div>
@endsection