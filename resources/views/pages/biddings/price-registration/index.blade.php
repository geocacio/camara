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
    <li class="item">
        <span>ATAS DE REGISTRO DE PREÇO</span>
    </li>
</ul>

<h3 class="title-sub-page main">ATAS DE REGISTRO DE PREÇO</h3>
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
                        <form action="{{ route('price.registration.index') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label>Período da licitação:</label>
                                        <input type="text" name="start_date" class="form-control mask-date" value="{{ isset($searchData['start_date']) ? old('start_date', $searchData['start_date']) : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label></label>
                                        <input type="text" name="end_date" class="form-control mask-date" value="{{ isset($searchData['end_date']) ? old('end_date', $searchData['end_date']) : '' }}" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control" value="{{ old('number', isset($searchData['number']) ? old('number', $searchData['number']) : '') }}" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Objeto</label>
                                        <input type="text" name="description" class="form-control" value="{{ old('description', isset($searchData['description']) ? old('description', $searchData['description']) : '') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('price.registration.index') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($bidding->count() > 0)

            <div class="row">
                
                @foreach($bidding as $item)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                            {{-- <div class="header">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div> --}}
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $item->number }}</h3>
                                    <ul>
                                        <li class="description">{{ $item->description }}</li>
                                    </ul>
                                </div>
                            </div>
                    </div>

                </div>

                @endforeach

                {{-- {{ $bidding->render() }} --}}

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif


    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Licitacoes - Dispensa e Inexigibilidade'])

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