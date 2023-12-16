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
        <span>Manifestações</span>
    </li>
</ul>
<h3 class="title text-center">Manifestações</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            <div class="col-md-8">
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
                        <form class="form-default" method="post" action="{{ route('manifestacao.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="anonymous" type="checkbox" role="switch" id="anonymous" onchange="toggleInput(event)">
                                <label class="form-check-label" for="anonymous">Anônimo</label>
                            </div>
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
                                            <label>CPF</label>
                                            <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Data de nascimento</label>
                                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <select name="sex" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="male"  {{ old('sex') == 'male' ? 'selected' : '' }}>Masculino</option>
                                                <option value="female"  {{ old('sex') == 'female' ? 'selected' : '' }}>Feminino</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Grau de Instrução</label>
                                            <select name="level_education" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="ANALFABETO, INCLUSIVE O QUE, EMBORA TENHA RECEBIDO INSTRUÇÃO, NÃO SE ALFABETIZOU." {{ old('level_education') == 'ANALFABETO, INCLUSIVE O QUE, EMBORA TENHA RECEBIDO INSTRUÇÃO, NÃO SE ALFABETIZOU.' ? 'selected' : '' }}>ANALFABETO, INCLUSIVE O QUE, EMBORA TENHA RECEBIDO INSTRUÇÃO, NÃO SE ALFABETIZOU.</option>
                                                <option value="ATÉ O 5º ANO INCOMPLETO DO ENSINO FUNDAMENTAL (ANTIGA 4ª SÉRIE) QUE SE TENHA ALFABETIZADO SEM TER FREQÜENTADO ESCOLA REGULAR." {{ old('level_education') == 'ATÉ O 5º ANO INCOMPLETO DO ENSINO FUNDAMENTAL (ANTIGA 4ª SÉRIE) QUE SE TENHA ALFABETIZADO SEM TER FREQÜENTADO ESCOLA REGULAR.' ? 'selected' : '' }}>ATÉ O 5º ANO INCOMPLETO DO ENSINO FUNDAMENTAL (ANTIGA 4ª SÉRIE) QUE SE TENHA ALFABETIZADO SEM TER FREQÜENTADO ESCOLA REGULAR.</option>
                                                <option value="5º ANO COMPLETO DO ENSINO FUNDAMENTAL." {{ old('level_education') == '5º ANO COMPLETO DO ENSINO FUNDAMENTAL.' ? 'selected' : '' }}>5º ANO COMPLETO DO ENSINO FUNDAMENTAL.</option>
                                                <option value="DO 6º AO 9º ANO DO ENSINO FUNDAMENTAL INCOMPLETO (ANTIGA 5ª À 8ª SÉRIE)." {{ old('level_education') == 'DO 6º AO 9º ANO DO ENSINO FUNDAMENTAL INCOMPLETO (ANTIGA 5ª À 8ª SÉRIE).' ? 'selected' : '' }}>DO 6º AO 9º ANO DO ENSINO FUNDAMENTAL INCOMPLETO (ANTIGA 5ª À 8ª SÉRIE).</option>
                                                <option value="ENSINO FUNDAMENTAL COMPLETO." {{ old('level_education') == 'ENSINO FUNDAMENTAL COMPLETO.' ? 'selected' : '' }}>ENSINO FUNDAMENTAL COMPLETO.</option>
                                                <option value="ENSINO MÉDIO INCOMPLETO." {{ old('level_education') == 'ENSINO MÉDIO INCOMPLETO.' ? 'selected' : '' }}>ENSINO MÉDIO INCOMPLETO.</option>
                                                <option value="ENSINO MÉDIO COMPLETO." {{ old('level_education') == 'ENSINO MÉDIO COMPLETO.' ? 'selected' : '' }}>ENSINO MÉDIO COMPLETO.</option>
                                                <option value="EDUCAÇÃO SUPERIOR INCOMPLETA." {{ old('level_education') == 'EDUCAÇÃO SUPERIOR INCOMPLETA.' ? 'selected' : '' }}>EDUCAÇÃO SUPERIOR INCOMPLETA.</option>
                                                <option value="EDUCAÇÃO SUPERIOR COMPLETA." {{ old('level_education') == 'EDUCAÇÃO SUPERIOR COMPLETA.' ? 'selected' : '' }}>EDUCAÇÃO SUPERIOR COMPLETA.</option>
                                                <option value="PÓS GRADUAÇÃO INCOMPLETA." {{ old('level_education') == 'PÓS GRADUAÇÃO INCOMPLETA.' ? 'selected' : '' }}>PÓS GRADUAÇÃO INCOMPLETA.</option>
                                                <option value="PÓS GRADUAÇÃO COMPLETA." {{ old('level_education') == 'PÓS GRADUAÇÃO COMPLETA.' ? 'selected' : '' }}>PÓS GRADUAÇÃO COMPLETA.</option>
                                                <option value="MESTRADO COMPLETO." {{ old('level_education') == 'MESTRADO COMPLETO.' ? 'selected' : '' }}>MESTRADO COMPLETO.</option>
                                                <option value="DOUTORADO COMPLETO." {{ old('level_education') == 'DOUTORADO COMPLETO.' ? 'selected' : '' }}>DOUTORADO COMPLETO.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="mail" name="email" class="form-control" value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipo de telefone</label>
                                            <select name="phone_type" class="form-control">
                                                <option value="whatsapp" {{ old('phone_type') == 'whatsapp' ? 'selected' : '' }}>Whatsapp</option>
                                                <option value="celular" {{ old('phone_type') == 'celular' ? 'selected' : '' }}>Celular</option>
                                                <option value="fixo" {{ old('phone_type') == 'fixo' ? 'selected' : '' }}>Fixo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="tel" name="phone" class="form-control mask-phone" value="{{ old('phone') }}" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Manifestação'])

@include('layouts.footer')

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    
    //mascaras...
    $(document).ready(function() {
        $('.mask-currency').maskMoney({
            prefix: 'R$ ',
            thousands: '.',
            decimal: ',',
            precision: 2
        });
        $('.mask-quantity').maskMoney({
            precision: 2,
            thousands: '',
            decimal: '.'
        });
        $('.mask-cnpj').mask('00.000.000/0000-00');
        $('.mask-phone').mask('(00) 0 0000-0000');
        $('.mask-cep').mask('00000-000');
        $('.mask-cpf').mask('000.000.000-00');
    });
    
    function toggleInput(e) {
        const personalInformation = document.querySelector('.personal-information');
        if (e.target.checked) {
            personalInformation.style.display = 'none';
        } else {
            personalInformation.style.display = 'block';
        }
    }
</script>
@endsection