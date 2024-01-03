@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Fale Conosco</span>
    </li>
</ul>
<h3 class="title text-center">Fale Conosco</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card main-card">
                    <h3 class="title">Formulário para a manifestação</h3>

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
                        <form class="form-default mb-5" method="post" action="{{ route('faleconosco.store') }}">
                            @csrf
                            <div class="personal-information">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Endereço</label>
                                            <input type="text" name="endereco" class="form-control" value="{{ old('endereco') }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="number" name="telephone" class="form-control" value="{{ old('telephone') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Orgão</label>
                                            <select name="orgao" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="orgao"  {{ old('orgao') }}>Camara</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Natureza</label>
                                            <select name="nature" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="critica"  {{ old('nature') == 'criticism' ? 'selected' : '' }}>Crítica</option>
                                                <option value="orgao"  {{ old('nature') == 'Reports' ? 'selected' : '' }}>Denúncias</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <input type="tel" name="subject" class="form-control" value="{{ old('subject') }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Natureza</label>
                                        <select name="nature" class="form-control">
                                            <option value="criticas">Críticas</option>
                                            <option value="denuncias">Denúncias</option>
                                            <option value="duvidas">Dúvidas</option>
                                            <option value="elogios">Elogios</option>
                                            <option value="reclamacoes">Reclamações</option>
                                            <option value="servicos">Serviços</option>
                                            <option value="sugestoes">Sugestões</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mensagem</label>
                                <textarea name="message" rows="10" class="form-control">{{ old('message') }}</textarea>
                            </div>

                            <div class="form-footer text-center">
                                <button type="submit" class="btn-submit-default">Enviar</button>
                            </div>

                        </form>
                        @if($contactUsData)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="box-contactUs">
                                        <h1>
                                            <i class="fas fa-phone"></i>
                                            Telefone
                                        </h1>
                                        <p>
                                            {{ $contactUsData->telefone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box-contactUs">
                                        <h1>
                                            <i class="fa-solid fa-clock fa-fw"></i>
                                            Horário de atendimento
                                        </h1>
                                        <p>
                                            {{ $contactUsData->opening_hours }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box-contactUs">
                                        <h1>
                                            <i class="fa-solid fa-envelope fa-fw"></i>
                                            E-mail
                                        </h1>
                                        <p>
                                            <a href="#">{{ $contactUsData->email }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Manifestação'])

@include('layouts.footer')

@endsection