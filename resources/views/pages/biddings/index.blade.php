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
        <a href="{{ route('bidding.page') }}" class="link">Licitações</a>
    </li>
</ul>

<h3 class="title-sub-page main">Licitações</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-legislature adjust-min-height no-padding-top">
    <div class="container">
        <div class="biddings">
            <a href="{{ route('shopping.portal.page') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>Licitações</span>
            </a>
            <a href="{{ route('dispensa.inexigibilidade') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>dispensa e inexigibilidades</span>
            </a>
            <a href="{{ route('atodeadesao.index') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>Ato de adesão</span>
            </a>
            <a href="{{ route('public.call') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>chamamento público</span>
            </a>
            <a href="{{ route('suspended.index') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>SUSPENSAS/INIDÔNEAS</span>
            </a>
            <a href="{{ route('contracts.biddings.index') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>Contratos</span>
            </a>
            <a href="{{ route('price.registration.index') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>atas de registros de preço</span>
            </a>
            <a href="{{ route('fiscais.contrato') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>fiscais de contratos</span>
            </a>
        </div>
    </div>

    @if($biddingNotices->count() > 0)
        <div class="avisos">
            <h3>Avisos de licitações</h3>
            <div class="swiper-container biddings-carousel">
                <div class="swiper-wrapper">
                    @foreach($biddingNotices as $item)
                        <a href="{{ route('bidding.show', $item->slug) }}" class="swiper-slide box-alert">
                            <div class="title-data">
                                <span class="title-biddings-alert">
                                    {{ $item->categories[0]->category->name }}
                                </span>
                                <span class="date">
                                    {{ $item->number }}
                                </span>
                            </div>

                            <span class="desc-alert-biddin">{{ \Illuminate\Support\Str::limit($item->description, $limit = 100, $end = '...') }}</span>
                            
                            <div class="caldendar-status">
                                <span>Data <i class="fa-regular fa-calendar"></i>: {{ date('d/m/Y', strtotime($item->opening_date)) }}</span>
                                <span>{{ $item->status }}  <i class="fa-regular fa-circle-question"></i></span>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>

            <div class="btn-swipper">
                <div class="btn-swipper-custom swiper--prev">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>

                <div class="swiper-pagination"></div> {{-- dots --}}
                
                <div class="btn-swipper-custom swiper--next">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </div>
        </div>
    @endif
    <div class="container">
        @if($biddings->count() > 0)

            <div class="row">
                <h5>ÚLTIMAS LICITAÇÕES</h5>
    
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-data-default">
                            <thead>
                                <tr>
                                    <th>Número Processo</th>
                                    <th>Objeto</th>
                                    <th>Data abertura</th>
                                    <th>Mais</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($biddings as $item)
                                    <tr>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->description, $limit = 100, $end = '...') }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->opening_date)) }}</td>
                                        <td style="cursor: pointer"> 
                                            <a href="{{ route('bidding.show', $item->slug) }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Licitacoes'])

@include('layouts.footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    var swiper = new Swiper('.biddings-carousel', {
        slidesPerView: 3,
        spaceBetween: 10,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper--next',
            prevEl: '.swiper--prev',
        },
    });
</script>


@endsection