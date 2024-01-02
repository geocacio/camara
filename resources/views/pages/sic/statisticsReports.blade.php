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
        <span>Relatórios estatísticos</span>
    </li>
</ul>
<h3 class="title text-center">Relatórios estatísticos</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-statistics-report">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            <div class="col-md-8">
                @if($sicSituationTable && !empty($sicSituationTable['data']))

                <h3 class="title-table">Relatório estatístico por situação</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Situação</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($sicSituationTable['data'] as $item)
                                <tr>
                                    <td>{{ $item['situation'] }}</td>
                                    <td class="align-center">{{ $item['count'] }}</td>
                                    <td class="text-right">{{ $item['percentage'] }}%</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="caption-table">
                        <div class="caption-container">
                            <div class="left">
                                <span class="info">Quantidade total de manifestação: <strong>{{ $sicSituationTable['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicNatureModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'nature')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>
                    @if($sicSituationGraphic && !empty($sicSituationGraphic['labels']))
                    <input type="hidden" name="sicSituationGraphic" value="{{ json_encode($sicSituationGraphic) }}">
                    @endif
                    <div class="modal modal-graphic fade" id="graphicNatureModal" tabindex="-1" role="dialog" aria-labelledby="graphicNatureModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body">
                                    <h3 class="title">Gráfico estatístico de Natureza</h3>
                                    <div class="chart">
                                        <canvas id="sicSituationGraphic"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

                @if($tableReport && !empty($tableReport['data']))

                <h3 class="title-table mt-30">Relatório estatístico por exercício</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Exercício</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($tableReport['data'] as $item)
                                <tr>
                                    <td>{{ __($item['year']) }}</td>
                                    <td class="align-center">{{ $item['count'] }}</td>
                                    <td class="text-right">{{ $item['percentage'] }}%</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="caption-table">
                        <div class="caption-container">
                            <div class="left">
                                <span class="info">Quantidade total de manifestação: <strong>{{ $tableReport['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicYearModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'year')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>

                    @if($graphicReport && !empty($graphicReport['labels']))
                    <input type="hidden" name="graphicReport" value="{{ json_encode($graphicReport) }}">
                    @endif
                    <div class="modal modal-graphic fade" id="graphicYearModal" tabindex="-1" role="dialog" aria-labelledby="graphicYearModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body">
                                    <h3 class="title">Gráfico estatístico anual</h3>
                                    <div class="chart">
                                        <canvas id="graphicReport"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Relatórios estatisticos'])

@include('layouts.footer')

@endsection
@section('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let sicSituationGraphic = JSON.parse(document.querySelector('input[name="sicSituationGraphic"]').value);
        let chartSecretary = JSON.parse(document.querySelector('input[name="chartSecretary"]').value);
        let chartMonths = JSON.parse(document.querySelector('input[name="chartMonths"]').value);
        let graphicReport = JSON.parse(document.querySelector('input[name="graphicReport"]').value);

        const canvasNature = document.getElementById("sicSituationGraphic");
        new Chart(canvasNature, {
            type: "bar",
            data: {
                labels: sicSituationGraphic.labels,
                datasets: [{
                    label: "Estatísticas por tipo",
                    data: sicSituationGraphic.data,
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
                        max: Math.max.apply(null, sicSituationGraphic.data) + 0.5,
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

        const canvasgraphicReport = document.getElementById("graphicReport");
        new Chart(canvasgraphicReport, {
            type: "line",
            data: {
                labels: graphicReport.labels,
                datasets: [{
                    label: 'Quantidade de manifestações',
                    data: graphicReport.data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        });

    });

    function generatePDF(e, pdfName) {
        const button = e.target;
        button.disabled = true;
        button.style.cursor = 'not-allowed';

        $.ajax({
            url: `/transparencia/ouvidoria/relatorios-estatisticos/${pdfName}/pdf`,
            method: "GET",
            success: function(pdfUrl) {
                button.disabled = false;
                button.style.cursor = 'pointer';
                window.open(pdfUrl, "_blank");
            }
        });
    }
</script>

@endsection