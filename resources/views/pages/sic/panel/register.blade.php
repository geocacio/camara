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
                    <h3 class="title">Insira as informações</h3>

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
                        <form class="form-default" method="post" action="{{ route('sicUser.register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de pessoa</label>
                                        <select class="form-control" id="person_type" name="person_type">
                                            <option value="fisica">Física</option>
                                            <option value="juridica">Jurídica</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group person-type">
                                        <label>CPF</label>
                                        <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                                    </div>
                                    <div class="form-group person-type d-none">
                                        <label>CNPJ</label>
                                        <input type="text" name="cnpj" class="form-control mask-cnpj" value="{{ old('cnpj') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome completo</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data de nascimento</label>
                                        <input type="text" name="birth" class="form-control mask-date" value="{{ old('birth') }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select class="form-control" name="sex">
                                            <option value="male">Masculino</option>
                                            <option value="female">Feminino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select class="form-control" id="sex">
                                            <option value="male">Masculino</option>
                                            <option value="female">Feminino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Escolaridade</label>
                                        <select class="form-control" id="sex">
                                            <option value="">Selecione uma opção</option>
                                            <option value="ANALFABETO, INCLUSIVE O QUE, EMBORA TENHA RECEBIDO INSTRUÇÃO, NÃO SE ALFABETIZOU.">ANALFABETO, INCLUSIVE O QUE, EMBORA TENHA RECEBIDO INSTRUÇÃO, NÃO SE ALFABETIZOU.</option>
                                            <option value="ATÉ O 5º ANO INCOMPLETO DO ENSINO FUNDAMENTAL (ANTIGA 4ª SÉRIE) QUE SE TENHA ALFABETIZADO SEM TER FREQÜENTADO ESCOLA REGULAR.">ATÉ O 5º ANO INCOMPLETO DO ENSINO FUNDAMENTAL (ANTIGA 4ª SÉRIE) QUE SE TENHA ALFABETIZADO SEM TER FREQÜENTADO ESCOLA REGULAR.</option>
                                            <option value="5º ANO COMPLETO DO ENSINO FUNDAMENTAL.">5º ANO COMPLETO DO ENSINO FUNDAMENTAL.</option>
                                            <option value="DO 6º AO 9º ANO DO ENSINO FUNDAMENTAL INCOMPLETO (ANTIGA 5ª À 8ª SÉRIE).">DO 6º AO 9º ANO DO ENSINO FUNDAMENTAL INCOMPLETO (ANTIGA 5ª À 8ª SÉRIE).</option>
                                            <option value="ENSINO FUNDAMENTAL COMPLETO.">ENSINO FUNDAMENTAL COMPLETO.</option>
                                            <option value="ENSINO MÉDIO INCOMPLETO.">ENSINO MÉDIO INCOMPLETO.</option>
                                            <option value="ENSINO MÉDIO COMPLETO.">ENSINO MÉDIO COMPLETO.</option>
                                            <option value="EDUCAÇÃO SUPERIOR INCOMPLETA.">EDUCAÇÃO SUPERIOR INCOMPLETA.</option>
                                            <option value="EDUCAÇÃO SUPERIOR COMPLETA.">EDUCAÇÃO SUPERIOR COMPLETA.</option>
                                            <option value="PÓS GRADUAÇÃO INCOMPLETA.">PÓS GRADUAÇÃO INCOMPLETA.</option>
                                            <option value="PÓS GRADUAÇÃO COMPLETA.">PÓS GRADUAÇÃO COMPLETA.</option>
                                            <option value="MESTRADO COMPLETO.">MESTRADO COMPLETO.</option>
                                            <option value="DOUTORADO COMPLETO.">DOUTORADO COMPLETO.</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone') }}" />
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
                                        <label>Senha</label>
                                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirmar Senha</label>
                                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group links">
                                <a href="{{ route('sic.login') }}" class="link">Login</a>
                            </div>

                            <div class="form-footer text-center">
                                <button type="submit" class="btn-submit-default">Registrar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Cadastro eSIC'])

@include('layouts.footer')

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    //mascaras...
    $(document).ready(function() {
        $('.mask-cnpj').mask('00.000.000/0000-00');
        $('.mask-phone').mask('(00) 0 0000-0000');
        $('.mask-date').mask('00/00/0000');
        $('.mask-cpf').mask('000.000.000-00');
    });

    const person_type = document.getElementById('person_type');
    person_type.addEventListener('change', e => {
        let formGroups = document.querySelectorAll('.person-type');
        formGroups.forEach(group => {
            group.querySelector('input').value = '';
            group.classList.toggle('d-none');
        });
    });
</script>
@endsection