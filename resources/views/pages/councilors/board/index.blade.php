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
        <span>Mesa Diretora</span>
    </li>
</ul>

<h3 class="title-sub-page main"># {{ $currentLegislaturePosition }} Legislatura: ({{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }})</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-legislature adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="{{ route('mesa-diretora.page') }}" method="post">
                            @csrf

                            <div class="form-group mb-0">
                                <label>Legislatura</label>
                                <select name="legislature_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @if($allLegislatures->count() > 0)
                                    @foreach($allLegislatures as $item)
                                    <option value="{{ $item->id }}" {{ count($searchData) > 0 ? ($item->id == $searchData['legislature_id'] ? 'selected' : '') : '' }}>({{ date('d/m/Y', strtotime($item->start_date)) }} {{ date('d/m/Y', strtotime($item->end_date)) }})</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('mesa-diretora.page') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($councilors)

            <div class="row gd-councilor-container">
                <div class="col-12">
                    <div class="card main-card">
                        <div class="row row-gap-20">
                            @foreach($councilors as $index => $councilor)
                                <div class="col-md-6">
                                    <a href="{{ route('vereador.single', $councilor->slug) }}" class="councilor-items">
                                        @if($councilor->files && count($councilor->files) > 0)
                                        <figure class="figure">
                                            <img class="image" src="{{ asset('storage/'.$councilor->files[0]->file->url) }}" alt="">
                                        </figure>
                                        @endif
                                        <div class="info">
                                            <span class="title">{{  $councilor->surname }}</span>
                                            <span class="title">{{  $councilor->legislatureRelations[$index]->office->office }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="empty-data">Nenhuma informação encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Mesa Diretora'])

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