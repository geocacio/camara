@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Secretarias</span>
    </li>
</ul>

<h3 class="title-sub-page main">Secretarias</h3>
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
                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        <label>Pesquisa</label>
                                        <input type="text" name="name" class="form-control input-sm" value="{{ old('name', $searchData ? $searchData['name'] : '') }}" placeholder="Nome da Secretaraia" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('secretarias.show') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($secretaries && $secretaries->count() > 0)

        <div class="row">
            
            @foreach($secretaries as $secretary)
            <div class="col-md-12">
                <div class="card-with-links">
                    <a href="{{ route('secretarias.single', $secretary->slug) }}">
                        <div class="header">
                            <i class="fa-solid fa-house fa-fw"></i>
                        </div>
                        <div class="second-part">
                            <div class="body">
                                <h3 class="title">{{ $secretary->name }}</h3>
                                <ul>
                                    <li>
                                        <i class="fa-solid fa-location-dot fa-fw"></i>
                                        {{ $secretary->address }} - CEP: {{ $secretary->cep }}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-clock fa-fw"></i>
                                        {{ $secretary->business_hours }}
                                    </li>
                                </ul>
                                <p class="description">{{ $secretary->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            @endforeach

            {{ $secretaries->render() }}

        </div>

        @else
        <div class="empty-data">Nenhuma secretaria encontrada.</div>
        @endif

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Secretarias'])

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