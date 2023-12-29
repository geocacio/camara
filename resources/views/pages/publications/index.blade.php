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
                        <form action="{{ route('publicacoes.show') }}" method="post">
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
                                        <label>Buscar pelo Tipo</label>
                                        <select name="type_id" class="form-control input-sm">
                                            <option value="">Selecione</option>
                                            @foreach ($subTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('type_id', $searchData['type_id'] ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição ou Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="{{ old('number', $searchData['number'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Pesquisar pelo Grupo</label>
                                        <select name="group_id" class="form-control input-sm">
                                            <option value="">Selecione</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" {{ old('group_id', $searchData['group_id'] ?? '') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Exercicio</label>
                                        <select name="exercicy_id" class="form-control input-sm">
                                            <option value="">Selecione</option>
                                            @foreach ($exercicy as $exe)
                                                <option value="{{ $exe->id }}" {{ old('exercicy_id', $searchData['exercicy_id'] ?? '') == $exe->id ? 'selected' : '' }}>{{ $exe->name }}</option>
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

        @if($publications->count() > 0)

        <div class="row">
            
            @foreach($publications as $publication)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $publication->title }}</h3>
                                    <p class="description">{{ $publication->description }}</p>
                                    <p class="description">Número: {{ $publication->number }}</p>
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