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

<input type="hidden" name="chartNature" value="{{ json_encode($sicSituation) }}">
<input type="hidden" name="chartYear" value="{{ json_encode($dataReport) }}">

@endsection

@section('content')

@include('layouts.header')

<section class="section-statistics">
    <div class="container">
        <div class="row">

            @include('pages.sic.sidebar')

            <div class="col-md-8">
                @if($sicSituation && !empty($sicSituation['labels']))
                <div class="container-chart mb-30">
                    <h3 class="title">Gráfico estatístico por situação</h3>
                    <div class="chart">
                        <canvas id="chartNature"></canvas>
                    </div>
                </div>
                @endif

                @if($dataReport && !empty($dataReport['labels']))
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

        let chartYear = JSON.parse(document.querySelector('input[name="chartYear"]').value);

        const canvasNature = document.getElementById("chartNature");
        new Chart(canvasNature, {
            type: "bar",
            data: {
                labels: chartNature.labels,
                datasets: [{
                    label: "Quantidade",
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

        const canvaschartYear = document.getElementById("chartYear");
        new Chart(canvaschartYear, {
            type: "bar",
            data: {
                labels: chartYear.labels,
                datasets: [{
                    label: "Quantidade",
                    data: chartYear.data,
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
                        max: Math.max.apply(null, chartYear.data) + 0.5,
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
    });
</script>

@endsection