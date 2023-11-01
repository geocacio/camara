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
        @if($ombudsman_survey_question && $page->main_title != '')
        <span>{{ $page->main_title }}</span>
        @endif
    </li>
</ul>
@if($ombudsman_survey_question)
@if($page->main_title != '')
<h3 class="title text-center">{{ $page->main_title }}</h3>
@endif

@endif
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-survey-satisfaction margin-fixed-top">
    <div class="container">
        <div class="row">

            @include('pages.ombudsman.sidebar')

            @if($ombudsman_survey_question && $ombudsman_survey_question->count() > 0)
            <div class="col-md-8">
                @if($page->title != '')
                <h3 class="secondary-title text-center mb-30">{{ $page->title }}</h3>
                @endif
                @if($page->description != '')
                <p class="description text-center">{{ $page->description }}</p>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
                @endif

                @if($ombudsman_survey_question)
                <form class="form-survey-satisfaction mb-30" method="post" action="{{ route('survey.store') }}">
                    @csrf
                    <div class="form-group custom-form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>CPF</label>
                                <input type="text" name="cpf" class="form-control mask-cpf" value="{{ old('cpf') }}" />
                            </div>
                            <div class="col-md-9">
                                <div class="legend-group">
                                    <div class="item">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ff2a2a">
                                            <path d="M256 272c-45.41 0-100.9 38.25-107.8 93.25c-1.574 11.88 6.902 21.62 15.5 18C186.4 373.5 220 368 256 368s69.63 5.486 92.27 15.24c8.477 3.625 17.07-6 15.5-18C356.9 310.3 301.4 272 256 272zM228 208c0-4.25-2.18-8.125-5.812-10.25l-80.04-48c-4.965-3-11.5-2-15.26 2.5s-3.875 11-.1211 15.5L160.5 208l-33.66 40.25c-3.754 4.5-3.633 11 .1211 15.5c3.512 4.125 9.93 5.75 15.26 2.5l80.04-48C225.8 216.1 228 212.3 228 208zM385.1 152.3c-3.754-4.5-10.29-5.5-15.26-2.5l-80.04 48C286.2 199.9 283.1 203.8 283.1 208s2.18 8.125 5.812 10.25l80.04 48c5.328 3.25 11.75 1.625 15.26-2.5c3.754-4.5 3.875-11 .1211-15.5L351.5 208l33.66-40.25C388.1 163.3 388.8 156.6 385.1 152.3zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                        </svg>
                                        <span>Muito insatiseito</span>
                                    </div>
                                    <div class="item">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ff7100">
                                            <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM175.1 240c17.8 0 32.09-14.25 32.09-32s-14.29-32-32.09-32c-17.68 0-31.97 14.25-31.97 32S158.3 240 175.1 240zM336 240c17.68 0 31.97-14.25 31.97-32s-14.29-32-31.97-32c-17.8 0-32.09 14.25-32.09 32S318.2 240 336 240zM256 272c-86.31 0-121.2 65.16-127.6 99.63C126 384.6 134.5 396.1 147.5 399.5c12.81 2.438 25.5-6 28.09-18.91C176.8 374.4 189.7 320 256 320s79.19 54.38 80.41 60.38C338.5 391.9 348.6 400 359.1 400c1.469 0 2.938-.125 4.406-.4062c13.03-2.406 21.62-14.94 19.22-27.97C377.2 337.2 342.3 272 256 272z" />
                                        </svg>
                                        <span>Insatisfeito</span>
                                    </div>
                                    <div class="item">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ffcf00">
                                            <path d="M344 320H167.1c-13.2 0-23.98 10.75-23.98 24s10.78 24 23.98 24h176.1c13.2 0 23.98-10.75 23.98-24S357.2 320 344 320zM175.1 240c17.8 0 32.02-14.25 32.02-32s-14.22-32-32.02-32c-17.68 0-31.99 14.25-31.99 32S158.3 240 175.1 240zM336 176c-17.8 0-32.02 14.25-32.02 32s14.22 32 32.02 32c17.68 0 31.99-14.25 31.99-32S353.7 176 336 176zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                        </svg>
                                        <span>Neutro</span>
                                    </div>
                                    <div class="item">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#4cf928">
                                            <path d="M340 312.6C319.2 337.6 288.5 352 256 352s-63.21-14.25-84.04-39.38c-8.477-10.25-23.61-11.5-33.79-3.125C128 318 126.7 333.1 135.1 343.3c29.91 36 74.11 56.73 120.9 56.73s90.94-20.73 120.9-56.73c8.598-10.12 7.145-25.25-3.027-33.75C363.7 301.1 348.5 302.4 340 312.6zM144.5 210.9c7.75-13.75 19.25-21.62 31.48-21.62c12.35 0 23.86 7.875 31.48 21.62l9.566 17C219.1 231.7 223.2 232.8 226.3 231.8c3.512-1.125 5.934-4.5 5.691-8.375C228.8 181.3 199.8 152 175.1 152c-23.73 0-52.68 29.25-55.95 71.38C119.6 227.1 122.1 230.6 125.7 231.8c3.391 1 7.459-.575 9.397-3.825L144.5 210.9zM336 152c-23.86 0-52.72 29.25-55.99 71.38c-.2422 3.75 2.107 7.25 5.619 8.375c3.512 1 7.387-.575 9.324-3.825l9.566-17c7.629-13.75 19.13-21.62 31.48-21.62c12.23 0 23.73 7.875 31.48 21.62l9.445 17c2.18 3.75 6.176 4.825 9.324 3.825c3.633-1.125 6.127-4.5 5.764-8.375C388.8 181.3 359.8 152 336 152zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                        </svg>
                                        <span>Satisfeito</span>
                                    </div>
                                    <div class="item">
                                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#2ebb56">
                                            <path d="M144.5 210.9c7.75-13.75 19.25-21.62 31.48-21.62c12.35 0 23.86 7.875 31.48 21.62l9.566 17C219.1 231.7 223.2 232.8 226.3 231.8c3.512-1.125 5.934-4.5 5.691-8.375C228.8 181.3 199.8 152 175.1 152c-23.73 0-52.54 29.25-55.81 71.38C119.8 227.1 122.1 230.6 125.7 231.8c3.512 1 7.459-.575 9.397-3.825L144.5 210.9zM361.6 304.6C335.7 312.9 297.2 317.8 256 317.8S176.4 312.9 150.4 304.6C140.6 301.5 131 309.9 132.7 319.9c7.871 47.13 71.32 80 123.3 80s115.3-32.88 123.3-80C380.8 310.1 371.6 301.5 361.6 304.6zM336 152c-23.86 0-52.64 29.25-55.91 71.38c-.2422 3.75 2.034 7.25 5.546 8.375c3.512 1 7.459-.575 9.397-3.825l9.494-17c7.629-13.75 19.13-21.62 31.48-21.62c12.23 0 23.81 7.875 31.56 21.62l9.445 17c2.18 3.75 6.103 4.825 9.252 3.825c3.633-1.125 6.055-4.5 5.691-8.375C388.7 181.3 359.8 152 336 152zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                        </svg>
                                        <span>Muito Satisfeito</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($ombudsman_survey_question as $index => $question)
                    <div class="form-group custom-form-group">
                        <label>{{ $question->question_text }}</label>
                        <div class="radio-container">
                            <div class="group-items-radio">
                                <input type="radio" id="icon-1-of-{{ $index }}" name="question-{{ $question->id }}" value="1" class="hidden-radio" />
                                <label for="icon-1-of-{{ $index }}" class="icon-label">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ff2a2a">
                                        <path d="M256 272c-45.41 0-100.9 38.25-107.8 93.25c-1.574 11.88 6.902 21.62 15.5 18C186.4 373.5 220 368 256 368s69.63 5.486 92.27 15.24c8.477 3.625 17.07-6 15.5-18C356.9 310.3 301.4 272 256 272zM228 208c0-4.25-2.18-8.125-5.812-10.25l-80.04-48c-4.965-3-11.5-2-15.26 2.5s-3.875 11-.1211 15.5L160.5 208l-33.66 40.25c-3.754 4.5-3.633 11 .1211 15.5c3.512 4.125 9.93 5.75 15.26 2.5l80.04-48C225.8 216.1 228 212.3 228 208zM385.1 152.3c-3.754-4.5-10.29-5.5-15.26-2.5l-80.04 48C286.2 199.9 283.1 203.8 283.1 208s2.18 8.125 5.812 10.25l80.04 48c5.328 3.25 11.75 1.625 15.26-2.5c3.754-4.5 3.875-11 .1211-15.5L351.5 208l33.66-40.25C388.1 163.3 388.8 156.6 385.1 152.3zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                    </svg>
                                </label>
                            </div>

                            <div class="group-items-radio">
                                <input type="radio" id="icon-2-of-{{ $index }}" name="question-{{ $question->id }}" value="2" class="hidden-radio" />
                                <label for="icon-2-of-{{ $index }}" class="icon-label">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ff7100">
                                        <path d="M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464zM175.1 240c17.8 0 32.09-14.25 32.09-32s-14.29-32-32.09-32c-17.68 0-31.97 14.25-31.97 32S158.3 240 175.1 240zM336 240c17.68 0 31.97-14.25 31.97-32s-14.29-32-31.97-32c-17.8 0-32.09 14.25-32.09 32S318.2 240 336 240zM256 272c-86.31 0-121.2 65.16-127.6 99.63C126 384.6 134.5 396.1 147.5 399.5c12.81 2.438 25.5-6 28.09-18.91C176.8 374.4 189.7 320 256 320s79.19 54.38 80.41 60.38C338.5 391.9 348.6 400 359.1 400c1.469 0 2.938-.125 4.406-.4062c13.03-2.406 21.62-14.94 19.22-27.97C377.2 337.2 342.3 272 256 272z" />
                                    </svg>
                                </label>
                            </div>

                            <div class="group-items-radio">
                                <input type="radio" id="icon-3-of-{{ $index }}" name="question-{{ $question->id }}" value="3" class="hidden-radio" />
                                <label for="icon-3-of-{{ $index }}" class="icon-label">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#ffcf00">
                                        <path d="M344 320H167.1c-13.2 0-23.98 10.75-23.98 24s10.78 24 23.98 24h176.1c13.2 0 23.98-10.75 23.98-24S357.2 320 344 320zM175.1 240c17.8 0 32.02-14.25 32.02-32s-14.22-32-32.02-32c-17.68 0-31.99 14.25-31.99 32S158.3 240 175.1 240zM336 176c-17.8 0-32.02 14.25-32.02 32s14.22 32 32.02 32c17.68 0 31.99-14.25 31.99-32S353.7 176 336 176zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                    </svg>
                                </label>
                            </div>

                            <div class="group-items-radio">
                                <input type="radio" id="icon-4-of-{{ $index }}" name="question-{{ $question->id }}" value="4" class="hidden-radio" />
                                <label for="icon-4-of-{{ $index }}" class="icon-label">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#4cf928">
                                        <path d="M340 312.6C319.2 337.6 288.5 352 256 352s-63.21-14.25-84.04-39.38c-8.477-10.25-23.61-11.5-33.79-3.125C128 318 126.7 333.1 135.1 343.3c29.91 36 74.11 56.73 120.9 56.73s90.94-20.73 120.9-56.73c8.598-10.12 7.145-25.25-3.027-33.75C363.7 301.1 348.5 302.4 340 312.6zM144.5 210.9c7.75-13.75 19.25-21.62 31.48-21.62c12.35 0 23.86 7.875 31.48 21.62l9.566 17C219.1 231.7 223.2 232.8 226.3 231.8c3.512-1.125 5.934-4.5 5.691-8.375C228.8 181.3 199.8 152 175.1 152c-23.73 0-52.68 29.25-55.95 71.38C119.6 227.1 122.1 230.6 125.7 231.8c3.391 1 7.459-.575 9.397-3.825L144.5 210.9zM336 152c-23.86 0-52.72 29.25-55.99 71.38c-.2422 3.75 2.107 7.25 5.619 8.375c3.512 1 7.387-.575 9.324-3.825l9.566-17c7.629-13.75 19.13-21.62 31.48-21.62c12.23 0 23.73 7.875 31.48 21.62l9.445 17c2.18 3.75 6.176 4.825 9.324 3.825c3.633-1.125 6.127-4.5 5.764-8.375C388.8 181.3 359.8 152 336 152zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                    </svg>
                                </label>
                            </div>

                            <div class="group-items-radio">
                                <input type="radio" id="icon-5-of-{{ $index }}" name="question-{{ $question->id }}" value="5" class="hidden-radio" />
                                <label for="icon-5-of-{{ $index }}" class="icon-label">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#2ebb56">
                                        <path d="M144.5 210.9c7.75-13.75 19.25-21.62 31.48-21.62c12.35 0 23.86 7.875 31.48 21.62l9.566 17C219.1 231.7 223.2 232.8 226.3 231.8c3.512-1.125 5.934-4.5 5.691-8.375C228.8 181.3 199.8 152 175.1 152c-23.73 0-52.54 29.25-55.81 71.38C119.8 227.1 122.1 230.6 125.7 231.8c3.512 1 7.459-.575 9.397-3.825L144.5 210.9zM361.6 304.6C335.7 312.9 297.2 317.8 256 317.8S176.4 312.9 150.4 304.6C140.6 301.5 131 309.9 132.7 319.9c7.871 47.13 71.32 80 123.3 80s115.3-32.88 123.3-80C380.8 310.1 371.6 301.5 361.6 304.6zM336 152c-23.86 0-52.64 29.25-55.91 71.38c-.2422 3.75 2.034 7.25 5.546 8.375c3.512 1 7.459-.575 9.397-3.825l9.494-17c7.629-13.75 19.13-21.62 31.48-21.62c12.23 0 23.81 7.875 31.56 21.62l9.445 17c2.18 3.75 6.103 4.825 9.252 3.825c3.633-1.125 6.055-4.5 5.691-8.375C388.7 181.3 359.8 152 336 152zM256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM256 464c-114.7 0-208-93.31-208-208S141.3 48 256 48s208 93.31 208 208S370.7 464 256 464z" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="form-group text-right">
                        <button type="submit" class="btn-default">
                            <i class="fa-solid fa-paper-plane"></i>
                            Enviar pesquisa
                        </button>
                    </div>

                </form>
                @endif
                
                @if($dataGraphic && !empty($dataGraphic['labels']))
                <input type="hidden" name="dataGraphic" value="{{ json_encode($dataGraphic) }}">
                @endif

                @if($dataGraphic && !empty($dataGraphic['labels']))
                <h3 class="title text-center mt-60">Avaliação contínua dos serviços públicos</h3>
                <div class="container-chart mt-30">
                    <div class="chart">
                        <canvas id="chartSurvey"></canvas>
                    </div>
                </div>
                @endif

                <div class="text-center mt-10">
                    <a href="{{ asset('storage/'.$pdfUrl) }}" target="_blank" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i></a>
                </div>

            </div>
            @endif

        </div>
    </div>
</section>

@include('layouts.footer')

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $('.mask-cpf').mask('000.000.000-00');

    document.addEventListener("DOMContentLoaded", () => {
        const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.addEventListener('click', e => {
                if (e.target.checked) {
                    let fill = e.target.closest('.group-items-radio').querySelector('svg').getAttribute('fill');
                    e.target.closest('.form-group').style.borderColor = fill;
                }
            });
        });
    });
    
    document.addEventListener("DOMContentLoaded", function() {
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
    });
</script>
@endsection