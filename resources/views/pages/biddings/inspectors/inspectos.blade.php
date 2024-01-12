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
        <a href="{{ route('shopping.portal.page') }}" class="link">Licitações</a>
    </li>
    <li class="item">
        <span>Fiscais de contrato</span>
    </li>
</ul>

<h3 class="title-sub-page main">Fiscais de contrato</h3>
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
                        <form action="{{ route('fiscais.contrato') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label>Nome</label>
                                        <input type="text" name="name" class="form-control" value="{{ isset($searchData['name']) ? old('name', $searchData['name']) : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('fiscais.contrato') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($inspectors->count() > 0)

            <div class="row">
                
                @foreach($inspectors as $item)
                
                <div class="col-md-12">
                    <a href="{{ route('fiscais.show', $item->slug) }}" class="card-with-links">
                        <div class="second-part">
                            <div class="body">
                                <h3 class="title">{{ $item->name }}</h3>
                                <ul>
                                    <li class="description">Data início: @if($item->start_date != '') {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }} @endif</li>
                                </ul>
                                @if($item->end_date != 'null')
                                    <ul>
                                        <li class="description">Data Fim:{{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </a>

                </div>

                @endforeach

                {{-- {{ $bidding->render() }} --}}

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif


    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Licitacoes - Fiscais de Contrato'])

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