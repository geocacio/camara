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
        <span>Estágiarios</span>
    </li>
</ul>

<h3 class="title-sub-page main">Estágiarios</h3>
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
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>De:</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $searchData['start_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Até:</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $searchData['end_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Nome</label>
                                        <input type="text" name="name" value="{{ old('start_date', $searchData['start_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Secretaria</label>
                                        <input type="date" name="secretary" value="{{ old('end_date', $searchData['end_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('glossario.show') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($employees->count() > 0)

            <div class="row">
                
                @foreach($employees as $item)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $item->name }}</h3>
                                    <ul>
                                        <li class="description">{{ $item->office->office }}</li>
                                    </ul>
                                </div>
                            </div>
                    </div>

                </div>

                @endforeach

                {{-- {{ $glossary->render() }} --}}

            </div>

        @else
            <div class="empty-data">Nenhum item encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Glossário'])

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