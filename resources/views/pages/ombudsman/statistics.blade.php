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
        <span>Estatísticas</span>
    </li>
</ul>
<h3 class="title text-center">Estatísticas</h3>

<input type="hidden" name="chartNature" value="{{ json_encode($chartNature) }}">
<input type="hidden" name="chartSecretary" value="{{ json_encode($chartSecretaries) }}">
<input type="hidden" name="chartMonths" value="{{ json_encode($chartMonths) }}">
<input type="hidden" name="chartYear" value="{{ json_encode($chartYear) }}">

@endsection

@section('content')

@include('layouts.header')

<section class="section-statistics">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            <div class="col-md-8">
                @if($chartNature && !empty($chartNature['labels']))
                <div class="container-chart mb-30">
                    <h3 class="title">Gráfico estatístico de Natureza</h3>
                    <div class="chart">
                        <canvas id="chartNature"></canvas>
                    </div>
                </div>
                @endif

                @if($chartSecretaries && !empty($chartSecretaries['labels']))
                <div class="container-chart mb-30">
                    <h3 class="title">Gráfico estatístico por Secretaria</h3>
                    <div class="chart">
                        <canvas id="chartSecretary"></canvas>
                    </div>
                </div>
                @endif

                @if($chartMonths && !empty($chartMonths['labels']))
                <div class="container-chart mb-30">
                    <h3 class="title">Gráfico estatístico mensal</h3>
                    <div class="chart">
                        <canvas id="chartMonths"></canvas>
                    </div>
                </div>
                @endif

                @if($chartYear && !empty($chartYear['labels']))
                <div class="container-chart mb-30">
                    <h3 class="title">Gráfico estatístico anual</h3>
                    <div class="chart">
                        <canvas id="chartYear"></canvas>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Estatisticas'])

@include('layouts.footer')

@endsection
@section('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let chartNature = JSON.parse(document.querySelector('input[name="chartNature"]').value);
        let chartSecretary = JSON.parse(document.querySelector('input[name="chartSecretary"]').value);
        let chartMonths = JSON.parse(document.querySelector('input[name="chartMonths"]').value);
        let chartYear = JSON.parse(document.querySelector('input[name="chartYear"]').value);

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

        const canvasSecretary = document.getElementById("chartSecretary");
        new Chart(canvasSecretary, {
            type: "bar",
            data: {
                labels: chartSecretary.labels,
                datasets: [{
                    label: "Estatísticas por tipo",
                    data: chartSecretary.data,
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
                        max: Math.max.apply(null, chartSecretary.data) + 0.5,
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

        const canvaschartMonths = document.getElementById("chartMonths");
        new Chart(canvaschartMonths, {
            type: "line",
            data: {
                labels: chartMonths.labels,
                datasets: [{
                    label: 'Quantidade de manifestações',
                    data: chartMonths.data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        });

        const canvaschartYear = document.getElementById("chartYear");
        new Chart(canvaschartYear, {
            type: "line",
            data: {
                labels: chartYear.labels,
                datasets: [{
                    label: 'Quantidade de manifestações',
                    data: chartYear.data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        });

    });
</script>

@endsection