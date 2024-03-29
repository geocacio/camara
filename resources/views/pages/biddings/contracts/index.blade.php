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
        <span>Contratos</span>
    </li>
</ul>

<h3 class="title-sub-page main">Contratos</h3>
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
                        <form action="{{ route('contracts.biddings.index') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group mb-0">
                                        <label>Período</label>
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
                                        <label>Tipo</label>
                                        <select name="type" class="form-control">
                                            <option value="">Tipo</option>
                                            @foreach($categories as $item)
                                                <option value="{{ $item->id }}" {{ isset($searchData['modalidade']) ?? is_array($searchData) && count($searchData) > 0 ? ($item->id == $searchData['modalidade'] ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="description" class="form-control" value="{{ old('description', isset($searchData['description']) ? old('description', $searchData['description']) : '') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('contracts.biddings.index') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($contracts->count() > 0)

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-data-default">
                            <thead>
                                <tr>
                                    <th>Nº do Contrato</th>
                                    <th>Nome do contratado CPF/CNPJ</th>
                                    <th>Descrição abreviada</th>
                                    <th>Data de inicio</th>
                                    <th>Data de fim</th>
                                    <th>Valor Total</th>
                                    <th>Mais</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contracts as $item)
                                    <tr>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->company->name }} / @if(empty($item->company->cnpj)){{ $item->company->cpf }} 
                                            @else 
                                                {{ $item->company->cnpj }}
                                            @endif
                                        </td>
                                        <td style="max-width: 330px;">{{ $item->description }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($item->end_date)) }}</td>
                                        <td>R${{ $item->total_value }}</td>
                                        <td style="cursor: pointer"> 
                                            <a href="{{ asset('storage/'.$item->files->file->url) }}" target="_blank">
                                                <i class="fa-regular fa-file"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- {{ $bidding->render() }} --}}

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif


    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Licitacoes - Contratos'])

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