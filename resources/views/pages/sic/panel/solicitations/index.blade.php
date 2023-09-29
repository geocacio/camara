@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Portal da transparência</a>
    </li>
    <li class="item">
        <a href="{{ route('ouvidoria.show') }}" class="link">Ouvidoria</a>
    </li>
    <li class="item">
        <a href="{{ route('sic.show') }}" class="link">e-SIC</a>
    </li>
    <li class="item">
        <span>Cadastro</span>
    </li>
</ul>
<h3 class="title text-center">Cadastro</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <div class="card main-card">

                    <ul class="breadcrumb esic">
                        <li class="item"><a href="{{ route('sic.panel') }}" class="link">e-SIC</a></li>
                        <li class="item">
                            <span>Informações do SIC</span>
                        </li>
                    </ul>

                    <h3 class="title">Informações do SIC</h3>

                    @if (session('feedback-success'))
                    <div class="alert alert-success">
                        {!! session('feedback-success') !!}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <li>{{ $errors->first() }}</li>
                        </ul>
                    </div>
                    @endif

                    <div class="card-body">
                        @if($solicitations && $solicitations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-esic">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Situação</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($solicitations as $solicitation)
                                    <tr>
                                        <td>{{ $solicitation->title }}</td>
                                        <td><span class="marked-text orange">{{ $solicitation->situations[0]->situation }}</span></td>
                                        <td>
                                            <button id="btnSolicitation" class="btn-action eye" data-toggle="tooltip" data-placement="right" title="Ver solicitação">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <button id="btnAppeal" class="btn-action appeal" data-toggle="tooltip" data-placement="right" title="Entrar com recurso">
                                                <i class="fa-solid fa-gavel"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @else
                            <div class="empty-data">Nenhuma carta de serviços encontrado.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-default" id="modalShowSolicitation" tabindex="-1" role="dialog" aria-labelledby="modalShowSolicitationTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Ver solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Aqui vai aparecer as informações
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="submit-satisfaction-survey" type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-default" id="modalAppeal" tabindex="-1" role="dialog" aria-labelledby="modalAppealTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Entrar com recurso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" id="satisfaction-survey">
                        @csrf

                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea name="reason" rows="2" class="form-control form-control-sm" required>{{ old('reason') }}</textarea>
                            <span class="error-message" id="reason-error"></span>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="submit-satisfaction-survey" type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Solicitação eSIC'])

@include('layouts.footer')

@endsection

@section('scripts')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    const solicitation = document.getElementById('btnSolicitation');
    solicitation.addEventListener('click', () => {
        const getModalSolicitation = document.querySelector('#modalShowSolicitation');
        let modalSolicitation = new bootstrap.Modal(getModalSolicitation);
        modalSolicitation.show();
    });

    const appeal = document.getElementById('btnAppeal');
    appeal.addEventListener('click', () => {
        const getModal = document.querySelector('#modalAppeal');
        let modal = new bootstrap.Modal(getModal);
        modal.show();
    });
</script>
@endsection