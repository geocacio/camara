@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Obras</span>
    </li>
</ul>

<h3 class="title-sub-page main">Obras</h3>
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
                        <form action="{{ route('obras.page') }}" method="post">
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
                                        <label>Nome, Número, Ano, ou Descrição</label>
                                        <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $searchData['description'] ?? '') }}" />
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

        @if($construction->count() > 0)

        <div class="row">
            
            @foreach($construction as $obra)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $obra->description }}</h3>
                                    <p class="description">{{ $obra->types[0]->name }}</p>
                                    @if(isset($obra->generalProgress[0]))
                                        <p class="description">
                                            {{ $obra->generalProgress[0]->situation }}
                                        </p>
                                    @else
                                        <p class="description">
                                            <span>Data esperada</span> 
                                            {{ date('d/m/Y', strtotime($obra->expected_date)) }}
                                        </p>
                                    @endif
                                    <ul>
                                        <li class="description">
                                            <span>Data Inicio: </span> 
                                            {{ date('d/m/Y', strtotime($obra->date)) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif


            {{-- {{ $construction->render() }} --}}

        @if ($noInformatios->count() > 0)
            <h4>Periodos sem obras</h4>
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

        {{-- @else
            <div class="empty-data">Nenhuma obra encontrada.</div> --}}
        

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Obras'])

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