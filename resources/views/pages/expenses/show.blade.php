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
        <a href="{{ route('diarias.show') }}" class="link">Diárias</a>
    </li>
    <li class="item">
        <span>{{ $voucher ? $voucher->number : '' }}</span>
    </li>
</ul>

<h3 class="title text-center">Diária {{ $voucher ? $voucher->number : ''}}</h3>

@endsection

@section('content')

@include('layouts.header')


<section class="section-single-voucher adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                    <ul class="nav nav-tabs nav-tab-page" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                                <i class="fa-solid fa-circle-info"></i>
                                Informações Principais
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                <i class="fa-solid fa-check-to-slot"></i>
                                Liquidações
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="trip-tab" data-bs-toggle="tab" data-bs-target="#trip" type="button" role="tab" aria-controls="trip" aria-selected="false">
                                <i class="fa-solid fa-dollar-sign"></i>
                                Pagamentos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a target="_blank" href="{{ route('despesas.pdf', $voucher->id) }}" class="nav-link" type="button" role="tab" aria-controls="trip" aria-selected="false">
                                <i class="fa-regular fa-file-pdf"></i>
                                Imprimir
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                            <h1 class="title"><i class="fa-solid fa-circle-info mr-10"></i>Informações Principais</h1>

                            <div class="card-info">
                                <h3 class="title-info">Informações do empenho</h3>
                                @if($voucher->voucher_number)
                                    <div class="info">
                                        <span class="label"><strong>Número do empenho:</strong></span>
                                        <span class="message">{{ $voucher->voucher_number }}</span>
                                    </div>
                                @endif
                                @if($voucher->voucher_date)
                                    <div class="info">
                                        <span class="label"><strong>Data:</strong></span>
                                        <span class="message">{{ date('d/m/Y', strtotime($voucher->voucher_date)) }}</span>
                                    </div>
                                @endif
                                @if($voucher->amount)
                                    <div class="info">
                                        <span class="label"><strong>Valor:</strong></span>
                                        <span class="message">R$ {{ number_format($voucher->amount, 2, ',', '.') }}</span>
                                    </div>
                                @endif
                                @if($voucher->supplier)
                                    <div class="info">
                                        <span class="label"><strong>Fornecedor:</strong></span>
                                        <span class="message">{{ $voucher->supplier }}</span>
                                    </div>
                                @endif
                                @if($voucher->nature)
                                    <div class="info">
                                        <span class="label"><strong>Natureza:</strong></span>
                                        <span class="message">{{ $voucher->nature }}</span>
                                    </div>
                                @endif
                            
                                <h3 class="title-info">Informações do orçamento</h3>
                                @if($voucher->economic_category)
                                    <div class="info">
                                        <span class="label"><strong>Categoria econômica:</strong></span>
                                        <span class="message">{{ $voucher->economic_category }}</span>
                                    </div>
                                @endif
                                @if($voucher->organization)
                                    <div class="info">
                                        <span class="label"><strong>Orgão:</strong></span>
                                        <span class="message">{{ $voucher->organization }}</span>
                                    </div>
                                @endif
                                @if($voucher->budget_unit)
                                    <div class="info">
                                        <span class="label"><strong>Unid. orçamentária:</strong></span>
                                        <span class="message">{{ $voucher->budget_unit }}</span>
                                    </div>
                                @endif
                                @if($voucher->project_activity)
                                    <div class="info">
                                        <span class="label"><strong>Proj. atividade:</strong></span>
                                        <span class="message">{{ $voucher->project_activity }}</span>
                                    </div>
                                @endif
                                @if($voucher->function)
                                    <div class="info">
                                        <span class="label"><strong>Função:</strong></span>
                                        <span class="message">{{ $voucher->function ?: '-' }}</span>
                                    </div>
                                @endif
                                @if($voucher->sub_function)
                                    <div class="info">
                                        <span class="label"><strong>Sub-função:</strong></span>
                                        <span class="message">{{ $voucher->sub_function ?: '-' }}</span>
                                    </div>
                                @endif
                                @if($voucher->resource_source)
                                    <div class="info">
                                        <span class="label"><strong>Fonte de recurso:</strong></span>
                                        <span class="message">{{ $voucher->resource_source ?: '-' }}</span>
                                    </div>
                                @endif
                                @if($voucher->description)
                                    <div class="info">
                                        <span class="label"><strong>Histórico:</strong></span>
                                        <span class="message">{{ $voucher->description }}</span>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <h1 class="title"><i class="fa-solid fa-check-to-slot"></i>Liquidações</h1>

                            <div class="card-info">
                                <div class="tab-pane fadeshow" id="public-form" role="tabpanel" aria-labelledby="public-form-tab">

                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>Valor</th>
                                                        <th>Exercício</th>
                                                        <th>Nota Fiscal	</th>
                                                        <th>Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                    @foreach($voucher->liquidations as $liquidation)
                                                    <tr>
                                                        <td>{{ $liquidation->amount }}</td>
                                                        <td>{{ $liquidation->fiscal_year }}</td>
                                                        <td>{{ $liquidation->invoice_number }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($liquidation->liquidation_date)) }}</td>
                                                    </tr>
                                                    @endforeach
                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="trip" role="tabpanel" aria-labelledby="trip-tab">
                            <h1 class="title"><i class="fa-solid fa-dollar-sign mr-10"></i>Pagamentos</h1>

                            <div class="card-info">
                                <div class="tab-pane fadeshow" id="public-form" role="tabpanel" aria-labelledby="public-form-tab">

                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-data-default">
                                                <thead>
                                                    <tr>
                                                        <th>Número pagamento</th>
                                                        <th>Valor</th>
                                                        <th>Data</th>
                                                        <th>Exercício</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                    @foreach($voucher->payments as $payment)
                                                    <tr>
                                                        <td>{{ $payment->payment_number }}</td>
                                                        <td>{{ $payment->valor }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($payment->date)) }}</td>
                                                        <td>{{ $payment->exercise }}</td>
                                                    </tr>
                                                    @endforeach
                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Diária'])

@include('layouts.footer')

@endsection