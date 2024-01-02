@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('sic.panel') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>eSic - Solicitações</span>
    </li>
</ul>

<h3 class="title-sub-page main">eSic - Solicitações</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-laws adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="{{ route('sic.search') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Filtro por protocolo/resumo</label>
                                        <input type="text" name="protocol" value="{{ old('protocol', $searchData['protocol'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Filtro por exercício:</label>
                                        <input type="number" name="exercicy" value="{{ old('exercicy', $searchData['exercicy'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('sic.search') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($solicitations->count() > 0)

        <div class="row">
            
            @foreach($solicitations as $solicitation)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <div class="second-part">
                            <div class="body">
                                <p class="description">Solicitação: {{ $solicitation->solicitation }}</p>
                                <p class="description">Protocolo: {{ $solicitation->protocol }} data {{  $solicitation->created_at->format('d/m/Y')}}</p>
                                <p class="description">Situação: {{ $solicitation->situations[0]->situation }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        @else
            <div class="empty-data">Nenhum comissão encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Obras'])

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