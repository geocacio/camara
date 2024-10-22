@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>{{ !empty($expensesPage->title) ? $expensesPage->title : 'DEMONSTRATIVO DAS DESPESAS'}}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ !empty($expensesPage->title) ? $expensesPage->title : 'DEMONSTRATIVO DAS DESPESAS'}}</h3>
@endsection

@section('content')

@include('layouts.header')



<section class="section-legislatures adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="{{ old('number', $searchData ? $searchData['number'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label>De:</label>
                                        <input type="text" name="start_date" class="form-control input-sm mask-date" value="{{ old('start_date', $searchData ? $searchData['start_date'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label>Até:</label>
                                        <input type="text" name="end_date" class="form-control input-sm mask-date" value="{{ old('end_date', $searchData ? $searchData['end_date'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $searchData ? $searchData['description'] : '') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('dicionario') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($vouchers->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-data-default">
                            <thead>
                                <tr>
                                    <th>Número do empenho</th>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Mais</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vouchers as $item)
                                    <tr>
                                        <td>{{ $item->voucher_number }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->voucher_date)) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>R${{ $item->amount }}</td>
                                        <td style="cursor: pointer"> 
                                            <a href="{{ route('despesas.show', $item->id) }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $vouchers->render() }}

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Dicionário'])

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