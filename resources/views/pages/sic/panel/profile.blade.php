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
        <span>Perfil</span>
    </li>
</ul>
<h3 class="title text-center">{{ $user->name }}</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                <div class="card main-card">
                    <h3 class="title">Dados cadastrados</h3>

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
                        <form class="form-default" method="post" action="{{ route('sic.updateProfile', $user->slug) }}">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de pessoa</label>
                                        <select class="form-control" id="person_type" name="person_type">
                                            <option value="fisica" {{ $user->cpf ? 'selected' : '' }}>Física</option>
                                            <option value="juridica" {{ $user->cnpj ? 'selected' : '' }}>Jurídica</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group person-type">
                                        <label>CPF</label>
                                        <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf', $user->cpf) }}" />
                                    </div>
                                    <div class="form-group person-type d-none">
                                        <label>CNPJ</label>
                                        <input type="text" name="cnpj" class="form-control mask-cnpj" value="{{ old('cnpj', $user->cnpj) }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome completo</label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data de nascimento</label>
                                        <input type="text" name="birth" class="form-control mask-date" value="{{ old('birth', $user->birth) }}" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select class="form-control" name="sex">
                                            <option value="male" {{ $user->sex == 'male' ? 'selected' : '' }}>Masculino</option>
                                            <option value="female" {{ $user->sex == 'female' ? 'selected' : '' }}>Feminino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone', $user->phone) }}" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="mail" name="email" class="form-control" value="{{ old('email', $user->email) }}" />
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

                            <div class="form-footer text-center">
                                <button type="submit" class="btn-submit-default">Atualizar</button>
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