@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Portarias</span>
    </li>
</ul>

<h3 class="title-sub-page main">Portarias</h3>
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
                        <form action="{{ route('portarias.show') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>De:</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $searchData['start_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Até:</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $searchData['end_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="{{ old('number', $searchData['number'] ?? '') }}" />
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Selecione uma opção</label>
                                        <select name="type" class="form-control input-sm">
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" {{ old('type', $searchData['type'] ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="details" class="form-control input-sm" value="{{ old('details', $searchData['details'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Agente</label>
                                        <input type="text" name="agent" class="form-control input-sm" value="{{ old('agent', $searchData['agent'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Pesquisar pelo cargo</label>
                                        <select name="cargo" class="form-control input-sm">
                                            @foreach ($cargos as $cargo)
                                                <option value="{{ $cargo->id }}" {{ old('cargo', $searchData['cargo'] ?? '') == $cargo->id ? 'selected' : '' }}>{{ $cargo->office }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('obras.page') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($ordinances->count() > 0)

        <div class="row">
            
            @foreach($ordinances as $ordinance)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $ordinance->number }}/{{ date('Y', strtotime($ordinance->date)) }}</h3>
                                    <p class="description">{{ $ordinance->detail }}</p>
                                    <p class="description">{{ $ordinance->number }}</p>
                                    <p class="description">
                                        <span>Data</span> 
                                        {{ date('d/m/Y', strtotime($ordinance->date)) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach


            {{-- {{ $construction->render() }} --}}

        </div>

        @else
            <div class="empty-data">Nenhuma obra encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Portarias'])

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