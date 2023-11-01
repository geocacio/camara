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
                @if($reportNature && !empty($reportNature['data']))

                <h3 class="title-table">Gráfico estatístico de Natureza</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Natureza</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reportNature['data'] as $item)
                                <tr>
                                    <td>{{ $item['nature'] }}</td>
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
                                <span class="info">Quantidade total de manifestação: <strong>{{ $reportNature['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicNatureModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'nature')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>
                    @if($chartNature && !empty($chartNature['labels']))
                    <input type="hidden" name="chartNature" value="{{ json_encode($chartNature) }}">
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
                                        <canvas id="chartNature"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

                @if($reportSecretary && !empty($reportSecretary['data']))

                <h3 class="title-table mt-30">Relatório estatístico por unidade administrativa</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Secretaria</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reportSecretary['data'] as $item)
                                <tr>
                                    <td>{{ $item['secretary'] }}</td>
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
                                <span class="info">Quantidade total de manifestação: <strong>{{ $reportNature['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicSecretaryModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'secretary')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>

                    @if($chartSecretary && !empty($chartSecretary['labels']))
                    <input type="hidden" name="chartSecretary" value="{{ json_encode($chartSecretary) }}">
                    @endif
                    <div class="modal modal-graphic fade" id="graphicSecretaryModal" tabindex="-1" role="dialog" aria-labelledby="graphicSecretaryModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body">
                                    <h3 class="title">Gráfico estatístico por Secretaria</h3>
                                    <div class="chart">
                                        <canvas id="chartSecretary"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

                @if($reportMonth && !empty($reportMonth['data']))

                <h3 class="title-table mt-30">Relatório estatístico mensal/{{ date('Y') }}</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Mês</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reportMonth['data'] as $item)
                                <tr>
                                    <td>{{ __($item['month']) }}</td>
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
                                <span class="info">Quantidade total de manifestação: <strong>{{ $reportMonth['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicMonthModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'month')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>

                    @if($chartMonths && !empty($chartMonths['labels']))
                    <input type="hidden" name="chartMonths" value="{{ json_encode($chartMonths) }}">
                    @endif
                    <div class="modal modal-graphic fade" id="graphicMonthModal" tabindex="-1" role="dialog" aria-labelledby="graphicMonthModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <div class="modal-body">
                                    <h3 class="title">Gráfico estatístico mensal</h3>
                                    <div class="chart">
                                        <canvas id="chartMonths"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                @endif

                @if($reportYear && !empty($reportYear['data']))

                <h3 class="title-table mt-30">Relatório estatístico Anual</h3>

                <div class="container-table">

                    <div class="table-responsive table-default">
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>Mês</th>
                                    <th class="align-center">Quantidade</th>
                                    <th class="text-right">Percentual</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reportYear['data'] as $item)
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
                                <span class="info">Quantidade total de manifestação: <strong>{{ $reportYear['total'] }}</strong></span>
                            </div>
                            <div class="right">
                                <button class="btn-caption" data-toggle="modal" data-target="#graphicYearModal"><i class="fa-solid fa-chart-pie"></i></button>
                                <button onclick="generatePDF(event, 'year')" target="_blank" class="btn-caption"><i class="fa-solid fa-file-pdf"></i></button>
                            </div>
                        </div>
                    </div>

                    @if($chartYear && !empty($chartYear['labels']))
                    <input type="hidden" name="chartYear" value="{{ json_encode($chartYear) }}">
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
                                        <canvas id="chartYear"></canvas>
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