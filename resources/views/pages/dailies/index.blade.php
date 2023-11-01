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
        <span>{{ $page_daily ? $page_daily->main_title : '' }}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ $page_daily ? $page_daily->main_title : '' }}</h3>
<p class="description-text main mb-30">{{ $page_daily ? $page_daily->description : '' }}</p>
@endsection

@section('content')

@include('layouts.header')



<section class="section-dailies adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="{{ old('number', $searchData ? $searchData['number'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Data</label>
                                        <input type="text" name="trip_start" class="form-control input-sm mask-date" value="{{ old('trip_start', $searchData ? $searchData['trip_start'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Beneficiário</label>
                                        <input type="text" name="agent" class="form-control input-sm" value="{{ old('agent', $searchData ? $searchData['agent'] : '') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('diarias.show') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            @include('partials.tableDefault', ['data' => $diaries, 'actions' => [ 'route' => 'diarias.single', 'param_type' => 'slug' ] ])

        </div>
        {{-- @include('partials.cardByDecreeOrLaw', ['data' => $laws]) --}}

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Diárias'])

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