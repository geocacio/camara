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
                                        <option value="1" {{ isset($searchData['mes']) && $searchData['mes'] == 1 ? 'selected' : '' }}>Janeiro</option>
                                        <option value="2" {{ isset($searchData['mes']) && $searchData['mes'] == 2 ? 'selected' : '' }}>Fevereiro</option>
                                        <option value="3" {{ isset($searchData['mes']) && $searchData['mes'] == 3 ? 'selected' : '' }}>Março</option>
                                        <option value="4" {{ isset($searchData['mes']) && $searchData['mes'] == 4 ? 'selected' : '' }}>Abril</option>
                                        <option value="5" {{ isset($searchData['mes']) && $searchData['mes'] == 5 ? 'selected' : '' }}>Maio</option>
                                        <option value="6" {{ isset($searchData['mes']) && $searchData['mes'] == 6 ? 'selected' : '' }}>Junho</option>
                                        <option value="7" {{ isset($searchData['mes']) && $searchData['mes'] == 7 ? 'selected' : '' }}>Julho</option>
                                        <option value="8" {{ isset($searchData['mes']) && $searchData['mes'] == 8 ? 'selected' : '' }}>Agosto</option>
                                        <option value="9" {{ isset($searchData['mes']) && $searchData['mes'] == 9 ? 'selected' : '' }}>Setembro</option>
                                        <option value="10" {{ isset($searchData['mes']) && $searchData['mes'] == 10 ? 'selected' : '' }}>Outubro</option>
                                        <option value="11" {{ isset($searchData['mes']) && $searchData['mes'] == 11 ? 'selected' : '' }}>Novembro</option>
                                        <option value="12" {{ isset($searchData['mes']) && $searchData['mes'] == 12 ? 'selected' : '' }}>Dezembro</option>
                                    </select>
                                </div>

                                <div class="form-group mb-0 col-md-3">
                                    <label>Ano</label>
                                    <input type="text" name="ano" value="{{ old('ano', $searchData ? $searchData['ano'] : '') }}" class="form-control mask-year" placeholder="Ano">
                                </div>

                                <div class="form-group mb-0 col-md-6">
                                    <label>Nome, Número ou Descrição</label>
                                    <input type="text" name="number_name_desc" value="{{ old('number_name_desc', $searchData ? $searchData['number_name_desc'] : '') }}" class="form-control" placeholder="Nome, Número ou Descrição">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('balancetes-all') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
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
                
                @foreach($chamberFinancial as $finance)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <div class="second-part">
                            <div class="body">
                                <h3 class="title">{{ $finance->name }}</h3>
                                <ul>
                                    @php
                                        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
                                        $formattedDate = strftime('%B %Y', strtotime($finance->date));
                                    @endphp

                                    <li class="description">Mês: {{ $formattedDate }}</li>

                                    <li class="description">Data: {{ date('d/m/Y', strtotime($finance->date)) }}</li>
                                    <li class="description">Status: {{ $finance->status ? 'Ativo' : 'Inativo'}}</li>
                                </ul>
                            </div>
            
                            <div class="footer">
                                @if(!empty($finance->files[0]))
                                    <a href="{{ asset('storage/'.$finance->files[0]->file->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                @endforeach

                {{ $chamberFinancial->render() }}

            </div>

        @else
            <div class="empty-data">Nenhum balancete encontrado.</div>
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
    $('.mask-year').mask('0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection