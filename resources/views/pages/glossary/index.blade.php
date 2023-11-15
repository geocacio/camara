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
        <span>{{ !empty($page_glossary->title) ? $page_glossary->title : 'Glossário'}}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ !empty($page_glossary->title) ? $page_glossary->title : 'Glossário'}}</h3>
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

                            <div class="form-group mb-0">
                                <label>Pesquisar por palavra</label>
                                <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $searchData ? $searchData['description'] : '') }}" />
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

        @if($glossary->count() > 0)

            <div class="row">
                
                @foreach($glossary as $item)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                            {{-- <div class="header">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div> --}}
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $item->title }}</h3>
                                    <ul>
                                        <li class="description">{{ $item->description }}</li>
                                    </ul>
                                </div>
                            </div>
                    </div>

                </div>

                @endforeach

                {{ $glossary->render() }}

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