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
        @if($lai_page)
            <span>{{ $lai_page->main_title }}</span>Z
            @else
            <span>Lai</span>
        @endif
    </li>
</ul>

<h3 class="title-sub-page main">Explicação da LAI</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-laws adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        @if($laiInfo)
                            <p>{{ $laiInfo->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($laiInfo)
            <div class="container-lais-links">
                <div class="buttons-links-lais muni">
                    <a href="#">
                        <i class="fa-solid fa-circle-info"></i>
                        REGULAMENTAÇÃO DA LAI MUNICIPAL
                    </a>
                </div>

                @if($laiInfo->state_lai)
                    <div class="buttons-links-lais state">
                        <a href="{{ $laiInfo->state_lai }}">
                            <i class="fa-solid fa-circle-info"></i>
                            REGULAMENTAÇÃO DA LAI ESTADUAL
                        </a>
                    </div>
                @endif

                @if($laiInfo->federal_lai)
                    <div class="buttons-links-lais federal">
                        <a href="{{ $laiInfo->federal_lai }}">
                            <i class="fa-solid fa-circle-info"></i>
                            REGULAMENTAÇÃO DA LAI FEDERAL
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Regulamentação da Lai'])

@include('layouts.footer')

@endsection


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection