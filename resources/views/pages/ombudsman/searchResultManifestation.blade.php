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
        <span>Minha manifestação</span>
    </li>
</ul>
<h3 class="title text-center">Minha manifestação</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-feedback margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            <div class="col-md-8">
                @if($result->count() <= 0)
                    <div class="main-card">
                        <div class="body text-center text-danger">Nenhuma manifestação encontrada!</div>
                    </div>
                @else
                    <div class="container-faq">
                        <div class="body">
                            <div class="accordion" id="accordionManifestation">
                                @foreach($result as $index => $item)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $item->id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $item->id }}" aria-expanded="true" aria-controls="collapse-{{ $item->id }}">
                                            <i class="fa-solid {{ $index == 0 ? 'fa-minus' : 'fa-plus' }}"></i>
                                            <span>Protocolo: <strong>{{ $item->protocol }}</strong> - <span class="text-alert {{ $item->status == 'Finalizado' ? 'answered' : 'waiting' }}">{{ $item->status }}</span></span>
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $item->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : ''}}" aria-labelledby="heading-{{ $item->id }}" data-bs-parent="#accordionManifestation">
                                        <div class="accordion-body">
                                            <div class="container-manifestation-result">
                                                <h3 class="title">{{ $item->anonymous != 'sim' ? $item->name : 'Identificação anônima' }}</h3>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($item->anonymous != 'sim')
                                                        <div class="item">
                                                            <span class="label">CPF: </span>
                                                            <span class="value">{{ $item->cpf }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">E-mail: </span>
                                                            <span class="value">{{ $item->email }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Telefone: </span>
                                                            <span class="value">{{ $item->phone }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="item">
                                                            <span class="label">Prazo: </span>
                                                            <span class="value">{{ $item->new_deadline ? $item->new_deadline : $item->deadline }} {{ $item->status == 'Finalizado' ? ' - '.$item->updated_at : ''}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if($item->anonymous != 'sim')
                                                        <div class="item">
                                                            <span class="label">Nascimento: </span>
                                                            <span class="value">{{ $item->date_of_birth }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Sexo: </span>
                                                            <span class="value">{{ __($item->sex) }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="item">
                                                            <span class="label">Protocolo: </span>
                                                            <span class="value">{{ $item->protocol }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Natureza: </span>
                                                            <span class="value">{{ $item->nature }}</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label">Status: </span>
                                                            <span class="value {{ $item->status == 'Finalizado' ? 'answered' : 'waiting' }}">{{ $item->status }}</span>
                                                        </div>
                                                    </div>
                                                    @if($item->anonymous != 'sim')
                                                    <div class="col-12">
                                                        <div class="item">
                                                            <span class="label">Grau de Instrução: </span>
                                                            <span class="value">{{ $item->level_education }}</span>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Manifestação:</strong></span>
                                                        <p class="message">{{ $item->message }}</p>
                                                    </div>
                                                    @if($item->answer)
                                                    <div class="col-12">
                                                        <span class="label mt-20 d-block"><strong>Resposta:</strong></span>
                                                        <p class="message">{{ $item->answer }}</p>
                                                    </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Resultado da busca daManifestação'])

@include('layouts.footer')

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        //toggle accordion icon
        const accordionManifestation = document.querySelector('#accordionManifestation');
        const allItems = accordionManifestation ? accordionManifestation.querySelectorAll('.accordion-item') : [];
        
        allItems.forEach(item => {
            item.querySelector('.accordion-button').addEventListener('click', e => {
                const icon = e.target.querySelector('i');
                const currentClass = icon.classList.contains('fa-plus') ? 'fa-plus' : 'fa-minus';
                allItems.forEach(item => item.querySelector('.accordion-button i').classList.replace('fa-minus', 'fa-plus'));
                console.log('laele ', currentClass)
                if (currentClass == 'fa-plus') {
                    icon.classList.replace('fa-plus', 'fa-minus');
                } else {
                    icon.classList.replace('fa-minus', 'fa-plus');
                }
            });
        });

    });
    
    //mascaras...
    $(document).ready(function() {
        $('.mask-cpf').mask('000.000.000-00');
        $('.mask-protocol').mask('000000000000');
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