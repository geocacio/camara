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
        <span>Licitações</span>
    </li>
</ul>

<h3 class="title-sub-page main">Licitações</h3>
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
                        <form action="{{ route('bidding.page') }}" method="post">
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
                                        <label>Modalidade da licitação</label>
                                        <select name="modalidade" class="form-control">
                                            <option value="">Modalidade da licitação</option>
                                            @foreach($modalidades as $item)
                                                <option value="{{ $item->id }}" {{ isset($searchData['modalidade']) ?? is_array($searchData) && count($searchData) > 0 ? ($item->id == $searchData['modalidade'] ? 'selected' : '') : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Situação da licitação</label>
                                        <select name="status" class="form-control">
                                            <option value="">Selecione um</option>
                                            <option value="Aberta" {{ isset($searchData['status']) && $searchData['status'] == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                                            <option value="Fechada" {{ isset($searchData['status']) && $searchData['status'] == 'Fechada' ? 'selected' : '' }}>Fechada</option>
                                            <option value="Em avaliação" {{ isset($searchData['status']) && $searchData['status'] == 'Em avaliação' ? 'selected' : '' }}>Em avaliação</option>
                                            <option value="Homologada" {{ isset($searchData['status']) && $searchData['status'] == 'Homologada' ? 'selected' : '' }}>Homologada</option>
                                            <option value="Revogada" {{ isset($searchData['status']) && $searchData['status'] == 'Revogada' ? 'selected' : '' }}>Revogada</option>
                                            <option value="Anulada" {{ isset($searchData['status']) && $searchData['status'] == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                                            <option value="Concluída" {{ isset($searchData['status']) && $searchData['status'] == 'Concluída' ? 'selected' : '' }}>Concluída</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Exercício</label>
                                        <select name="exercice" class="form-control">
                                            <option value="">Selecione</option>
                                            @foreach($exercicies[0]->children as $item)
                                                <option value="{{ $item->id }}" {{ isset($searchData['exercice']) && $item->id == $searchData['exercice'] ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Registro de preço</label>
                                        <select name="register_price" class="form-control">
                                            <option value="">Selecione</option>

                                            <option value="Sim" {{ isset($searchData['exercice']) && $searchData == 'Sim' ? 'selected' : '' }}>Sim</option>
                                            <option value="Não" {{ isset($searchData['exercice']) && $searchData == 'Não' ? 'selected' : '' }}>Não</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número da licitação</label>
                                        <input type="text" name="number" class="form-control" value="{{ old('number', isset($searchData['number']) ? old('number', $searchData['number']) : '') }}" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Objeto da licitação</label>
                                        <input type="text" name="object" class="form-control" value="{{ old('object', isset($searchData['object']) ? old('object', $searchData['object']) : '') }}" />
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Processo da licitação</label>
                                        <input type="text" name="process" class="form-control" value="{{ old('process', isset($searchData['process']) ? old('process', $searchData['process']) : '') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('bidding.page') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
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

            {{-- <div class="row">
                
                @foreach($bidding as $item)
                
                <div class="col-md-12">
                    <div class="card-with-links">
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
            </div> --}}
            <div class="row">

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
                                @foreach($bidding as $item)
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

            {{ $bidding->render() }}

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