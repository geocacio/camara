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
            <a href="{{ route('price.registration.index') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>atas de registros de preço</span>
            </a>
            <a href="{{ route('fiscais.contrato') }}" class="item-bidding">
                <i class="fa-solid fa-file-contract"></i>
                <span>fiscais de contratos</span>
            </a>
        </div>
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
                                        <td>{{ $item->description }}</td>
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

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection