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
        <span>{{ $ombudsman->title }}</span>
    </li>
</ul>
<h3 class="title text-center">{{ $ombudsman->title }}</h3>
@endsection

@section('content')

@include('layouts.header')

<input type="hidden" name="chartData" value="{{ json_encode($chartData) }}">

@if($dataGraphic && !empty($dataGraphic['labels']))
<input type="hidden" name="dataGraphic" value="{{ json_encode($dataGraphic) }}">
@endif

<section class="section-ombudsman pv-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="ombudsman-container">
                    <a href="{{ route('manifestacao.show') }}" class="link-box">
                        <i class="{{ $ombudsman->icon }}"></i>
                        <h5 class="title">{{ $ombudsman->title }}</h5>
                        <p class="description">{{ $ombudsman->description }}</p>
                        <button class="fake-link">Acessar</button>
                    </a>
                    <a href="{{ route('sic.show') }}" class="link-box">
                        <i class="{{ $esicPage->icon }}"></i>
                        <h5 class="title">{{ $esicPage->title }}</h5>
                        <p class="description">{{ $esicPage->description }}</p>
                        <button class="fake-link">Acessar</button>
                    </a>
                    <a href="{{ route('faleconosco.index') }}" class="link-box">
                        <i class="fa-solid fa-phone"></i>
                        <h5 class="title">Contato</h5>
                        <p class="description">Fale Conosco</p>
                        <button class="fake-link">Acessar</button>
                    </a>
                    <a href="{{ route('cartaservicos.index') }}" class="link-box">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <h5 class="title">SERVIÇOS AO CIDADÃO</h5>
                        <p class="description">CARTA DE SERVIÇOS AO CIDADÃO</p>
                        <button class="fake-link">Acessar</button>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>

@if($chartData && !empty($chartData['labels']) || $dataGraphic && !empty($dataGraphic['labels']))
<section class="section-charts pv-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="main-title text-center mb-30">Relatório estatístico da ouvidoria</h3>
            </div>

            @if($chartData && !empty($chartData['labels']))
            <div class="col-md-6">
                <div class="container-chart">
                    <h3 class="title">Gráfico estatístico de Natureza</h3>
                    <div class="chart">
                        <canvas id="chartNature"></canvas>
                    </div>
                </div>

                <div class="container-button">
                    <a class="light-link mt-3" href="{{ route('estatisticas.reports') }}"><i class="fa-solid fa-chart-pie"></i> Mais relatórios da ouvidoria</a>
                </div>

            </div>
            @endif

            @if($dataGraphic && !empty($dataGraphic['labels']))
            <div class="col-md-6">
                <div class="container-chart">
                    <h3 class="title">Avaliação contínua dos serviços públicos</h3>
                    <div class="chart">
                        <canvas id="chartSurvey"></canvas>
                    </div>
                </div>

                <div class="container-button">
                    <a class="light-link mt-3" href="{{ route('survey.show') }}"><i class="fa-solid fa-face-smile"></i> Clique aqui para avaliar</a>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
@endif

@if($faqs && $faqs->count() > 0)
<section class="section-ombudsman-faq pv-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="container-faq">
                    <div class="header">
                        <h3 class="main-title text-center mb-30">Perguntas frequentes FAQ</h3>
                    </div>
                    <div class="body">
                        <div class="accordion" id="accordionFaq">
                            @foreach($faqs as $index => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">
                                        <i class="fa-solid {{ $index == 0 ? 'fa-minus' : 'fa-plus' }}"></i>
                                        <!-- <i class="fa-solid fa-minus"></i> -->
                                        <span>{{ $faq->question }}</span>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : ''}}" aria-labelledby="heading-{{ $faq->id }}" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">{{ $faq->answer }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Ouvidoria'])

@include('layouts.footer')

@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let chartNature = JSON.parse(document.querySelector('input[name="chartData"]').value);
        const canvasNature = document.getElementById("chartNature");
        new Chart(canvasNature, {
            type: "bar",
            data: {
                labels: chartNature.labels,
                datasets: [{
                    label: "Estatísticas por tipo",
                    data: chartNature.data,
                    backgroundColor: [
                        '#ff2a2a',
                        '#ff7100',
                        '#ffcf00',
                        '#4cf928',
                        '#2ebb56',
                    ],
                    borderWidth: 1,
                    barThickness: 40,
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Oculta a legenda (label)
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max.apply(null, chartNature.data) + 0.5,
                        grid: {
                            display: false,
                        },
                    },
                    x: {
                        barPercentage: 1.8,
                    }
                },
            },
        });


        let chartSurvey = JSON.parse(document.querySelector('input[name="dataGraphic"]').value);
        const canvasSurvey = document.getElementById("chartSurvey");
        new Chart(canvasSurvey, {
            type: "bar",
            data: {
                labels: chartSurvey.labels,
                datasets: [{
                    label: "Resultado da pesquisa",
                    data: chartSurvey.data,
                    backgroundColor: [
                        '#ff2a2a',
                        '#ff7100',
                        '#ffcf00',
                        '#4cf928',
                        '#2ebb56',
                    ],
                    borderWidth: 1,
                    barThickness: 40,
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Oculta a legenda (label)
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max.apply(null, chartSurvey.data) + 0.5,
                        grid: {
                            display: false,
                        },
                    },
                    x: {
                        barPercentage: 1.8,
                    }
                },
            },
        });

        //toggle accordion icon
        const accordionFaq = document.querySelector('#accordionFaq');
        const allItems = accordionFaq ? accordionFaq.querySelectorAll('.accordion-item') : [];

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
</script>

@endsection