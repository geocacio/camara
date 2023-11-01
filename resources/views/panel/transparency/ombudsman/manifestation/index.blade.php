@extends('panel.index')
@section('pageTitle', 'feedback Ouvidoria')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('ombudsman-feedback.create') }}" class="btn-default">Novo</a>
        </div>

        @if($ombudsmanFeedback && $ombudsmanFeedback->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Protocolo</th>
                        <th>Status</th>
                        <th>Prazo</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ombudsmanFeedback as $feedback)
                    <tr>
                        <td>{{ $feedback->id }}</td>
                        <td>{{ $feedback->protocol }}</td>
                        <td><span class="text-alert {{ $feedback->status == 'Finalizado' ? 'answered' : 'waiting' }}">{{ $feedback->status }}</span></td>
                        <td class="actions">{{ $feedback->new_deadline ? $feedback->new_deadline : $feedback->deadline }}
                            <a data-toggle="modal" data-target="#changeDeadline{{$feedback->id}}" class="link see" title="Adiar"><i class="fa-solid fa-clock"></i></a>

                            <div id="changeDeadline{{$feedback->id}}" class="modal fade modal-warning" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                        <form id="formDeadline-{{ $feedback->id }}" action="{{ route('ombudsman-feedback.deadline', $feedback->id) }}" method="post">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label>Novo prazo</label>
                                                <input type="date" name="new_deadline" class="form-control" value="{{ old('new_deadline') }}">
                                            </div>
                                        </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                            <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                document.getElementById('formDeadline-{{ $feedback->id }}').submit();">
                                                Enviar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td class="actions text-right">
                            @if($feedback->status != 'Finalizado')
                            <a href="{{ route('ombudsman-feedback.edit', $feedback->id) }}" class="link reply"><i class="fa-solid fa-reply"></i></a>
                            @endif
                            <a data-toggle="modal" data-target="#showManifestation{{$feedback->id}}" class="link see"><i class="fa-solid fa-eye"></i></a>
                            <!-- Permitir somente o admin apagar a manifestação -->
                            @if($user->id == 1)
                            <a data-toggle="modal" data-target="#myModal{{$feedback->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                            <div id="myModal{{$feedback->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $feedback->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $feedback->id }}" action="{{ route('ombudsman-feedback.destroy', $feedback->id) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="showManifestation{{$feedback->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="container-manifestation-result">
                                                <h3 class="title">{{ $feedback->anonymous != 'sim' ? $feedback->name : 'Identificação anônima' }}</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($feedback->anonymous != 'sim')
                                                        <div class="item">
                                                            <span class="label">CPF: </span>
                                                            <span class="value">{{ $feedback->cpf }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">E-mail: </span>
                                                            <span class="value">{{ $feedback->email }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Telefone: </span>
                                                            <span class="value">{{ $feedback->phone }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="item">
                                                            <span class="label">Secretaria: </span>
                                                            <span class="value">{{ $feedback->secretary->name }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Prazo: </span>
                                                            <span class="value">{{ $feedback->new_deadline ? $feedback->new_deadline : $feedback->deadline }} {{ $feedback->status == 'Finalizado' ? ' - '.$feedback->updated_at : ''}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if($feedback->anonymous != 'sim')
                                                        <div class="item">
                                                            <span class="label">Nascimento: </span>
                                                            <span class="value">{{ $feedback->date_of_birth }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Sexo: </span>
                                                            <span class="value">{{ __($feedback->sex) }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="item">
                                                            <span class="label">Protocolo: </span>
                                                            <span class="value">{{ $feedback->protocol }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Natureza: </span>
                                                            <span class="value">{{ $feedback->nature }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Status: </span>
                                                            <span class="value {{ $feedback->status == 'Finalizado' ? 'answered' : 'waiting' }}">{{ $feedback->status }}</span>
                                                        </div>
                                                    </div>
                                                    @if($feedback->anonymous != 'sim')
                                                    <div class="col-12">
                                                        <div class="item">
                                                            <span class="label">Grau de Instrução: </span>
                                                            <span class="value">{{ $feedback->level_education }}</span>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Manifestação:</strong></span>
                                                        <p class="message">{{ $feedback->message }}</p>
                                                    </div>
                                                    @if($feedback->answer)
                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Resposta:</strong></span>
                                                        <p class="message">{{ $feedback->answer }}</p>
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
            <span>Ainda não existem manifestações cadastradas.</span>
        </div>
        @endif

    </div>
</div>
@endsection