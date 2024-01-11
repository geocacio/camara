@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Licitações</a>
    </li>
    <li class="item">
        <a href="{{ route('fiscais.contrato') }}" class="link">Fiscais</a>
    </li>
    <li class="item">
        <span>{{ $inspector->name }}</span>
    </li>
</ul>

<h3 class="title text-center">{{ $inspector->name }}</h3>

@endsection

@section('content')

@include('layouts.header')
<section class="section-councilor adjust-min-height margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card main-card card-manager">
                    <div class="tab-content" id="myTabContent">
                        <div class="gd-managers tab-pane fadeshow active" id="index" role="tabpanel" aria-labelledby="index-tab">
                            <div class="row container-descriptions">
                                <div class="col-md-6">
                                    <p class="title">Fiscal</p>
                                    <p class="description">{{ $inspector->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="title">Data de inicio</p>
                                    <p class="description">{{ \Carbon\Carbon::parse($inspector->start_date)->format('d/m/Y') }}</p>
                                </div>
                                @if($inspector->end_date != null)
                                    <div class="col-md-6">
                                        <p class="title">Data de fim</p>
                                        <p class="description">{{ \Carbon\Carbon::parse($inspector->end_date)->format('d/m/Y') }}</p>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <p class="title">Tipo</p>
                                    <p class="description">{{ $inspector->type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($contracts && count($contracts))
            <div class="tab-pane fadeshow" id="material" role="tabpanel" aria-labelledby="material-tab">
    
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-data-default">
                            <thead>
                                <tr>
                                    <th>Número do Contrato</th>
                                    <th>Data de início</th>
                                    <th>Data de fim</th>
                                    <th>Valor Total</th>
                                    <th>Descrição</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
            
                                @foreach($contracts as $item)
                                    <tr>
                                        <td>{{ $item->number }}: {{ $item->id }}/{{ date('Y', strtotime($item->date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->end_date)) }}</td>
                                        <td>{{ $item->total_value }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td data-toggle="tooltip" title="Ver mais">
                                            <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>

                                    <div class="modal fade modal-show-info-data" id="showDecree-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="showDecree-{{ $item->id }}Title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $item->number }}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="view-date">
                                                        <span>
                                                            <i class="fa-solid fa-calendar-days"></i>Início: <span>{{ date('d/m/Y', strtotime($item->start_date)) }}</span>
                                                        </span>
                                                    </div>
                                                    <div class="view-date">
                                                        <span>
                                                            <i class="fa-solid fa-calendar-days"></i>Fim: <span>{{ date('d/m/Y', strtotime($item->end_date)) }}</span>
                                                        </span>
                                                    </div>
                                                    <div class="description">
                                                        <p style="word-wrap: break-word;">{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
            
                            </tbody>
                        </table>
                    </div>
                </div>
    
            </div>
        @endif
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Fiscais de contrato'])

@include('layouts.footer')

@endsection