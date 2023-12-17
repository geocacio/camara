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
        <span>Balancetes Financeiros</span>
    </li>
</ul>

<h3 class="title-sub-page main">Balancetes Financeiros</h3>
@endsection

@section('content')

@include('layouts.header')



<section class="section-chambers adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="#" method="post">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-3 mb-0">
                                    <label>Mês</label>
                                    <select name="mes" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="1">Janeiro</option>
                                        <option value="2">Fevereiro</option>
                                        <option value="3">Março</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Maio</option>
                                        <option value="6">Junho</option>
                                        <option value="7">Julho</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Setembro</option>
                                        <option value="10">Outubro</option>
                                        <option value="11">Novembro</option>
                                        <option value="12">Dezembro</option>
                                    </select>
                                </div>

                                <div class="form-group mb-0 col-md-3">
                                    <label>Ano</label>
                                    <input type="number" name="ano" class="form-control" placeholder="Ano">
                                </div>

                                <div class="form-group mb-0 col-md-6">
                                    <label>Nome, Número ou Descrição</label>
                                    <input type="text" name="number_name_desc" class="form-control" placeholder="Nome, Número ou Descrição">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('legislaturas-all') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($chamberFinancial->count() > 0)

            <div class="row">
                
                @foreach($chamberFinancial as $chamber)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="{{ route('vereadores-all', $chamber->slug) }}">
                            <div class="header">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div>
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $chamber->name }}</h3>
                                    <ul>
                                        @php
                                            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
                                            $formattedDate = strftime('%B %Y', strtotime($chamber->date));
                                        @endphp

                                        <li class="description">Mês: {{ $formattedDate }}</li>

                                        <li class="description">Data: {{ date('d/m/Y', strtotime($chamber->date)) }}</li>
                                        <li class="description">Status: {{ $chamber->status }}</li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                

                @endforeach

                {{-- {{ $chamberFinancial->render() }} --}}

            </div>

        @else
            <div class="empty-data">Nenhuma legislatura encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Legislaturas'])

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