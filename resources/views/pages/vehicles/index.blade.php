@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Veiculos</span>
    </li>
</ul>

<h3 class="title-sub-page main">Veículos</h3>
{{-- <p class="description-text main mb-30">{{ $page_law->description }}</p> --}}
@endsection

@section('content')

@include('layouts.header')

<section class="section-sessions adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="#" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Secretaria</label>
                                        <select name="secretary_id" class="form-control">
                                            <option value="">Selecione</option>
                                            @foreach ($secretarys as $secretary)
                                                <option value="{{ $secretary->id }}" {{ old('secretary_id', $searchData['secretary_id'] ?? '') == $secretary->id ? 'selected' : '' }}>{{ $secretary->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Tipo</label>
                                        <select name="situation" class="form-control">
                                            <option value="">Selecione</option>
                                            <option value="Ativo" {{ $searchData['situation'] == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                            <option value="Inativo" {{ $searchData['situation'] ==  'Inativo' ? 'selected' : '' }}>Inativo</option>
                                            <option value="Quebrado" {{ $searchData['situation'] ==  'Quebrado' ? 'selected' : '' }}>Quebrado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Modelo do veículo</label>
                                        <input type="text" name="model" class="form-control" value="{{ old('model',  $searchData['model'] ?? '') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Marca do veículo</label>
                                        <input type="text" name="brand" class="form-control" value="{{ old('brand', $searchData['brand'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Placa do veículo</label>
                                        <input type="text" name="plate" class="form-control" value="{{ old('plate', $searchData['plate'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Tipo do veículo</label>
                                        <select name="type" class="form-control">
                                            <option value="">Selecione</option>
                                            <option value="Própio" {{ $searchData['type'] == 'Própio' ? 'selected' : '' }}>Própio</option>
                                            <option value="Locado" {{ $searchData['type'] == 'Locado' ? 'selected' : '' }}>Locado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('materiais-all') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($vehicles->count() > 0)

            <div class="row">
                
                @foreach($vehicles as $vehicle)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="{{ route('veiculos.single', $vehicle->slug) }}">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">Modelo: {{ $vehicle->model }} Marca: {{ $vehicle->brand }}</h3>
                                    <p class="description">Placa: {{ $vehicle->plate }}</p>
                                    <ul>
                                        <li class="description">
                                            Ano
                                            {{ $vehicle->year }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                @endforeach

                {{ $vehicles->render() }}

            </div>

        @endif
        @if ($noInformatios->count() > 0)
            <h4>Periodos sem veículos</h4>
            @foreach ($noInformatios as $obj)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <div class="second-part">
                            <div class="body">
                                <p class="no-vehicle">{{ $obj->description }}</p>
                                <p class="no-vehicle">Periodo: {{ $obj->periodo }}</p>
                            </div>

                            <div class="footer">
                                @if(!empty($obj->fileWhenNoInfo))
                                    <a href="{{ asset('storage/'.$obj->fileWhenNoInfo->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'veiculos'])

@include('layouts.footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<style>
    .no-vehicle {
        font-size: 13px;
        color: #0c0c0c;
        text-align: justify;
        margin-bottom: 0;
        text-overflow: ellipsis;
    }
</style>

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection