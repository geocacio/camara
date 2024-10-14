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
        <span>{{ $pageServiceLetter ? $pageServiceLetter->main_title : '' }}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ $pageServiceLetter ? $pageServiceLetter->main_title : '' }}</h3>
<p class="description-text main mb-30">{{ $pageServiceLetter ? $pageServiceLetter->description : '' }}</p>
@endsection

@section('content')

@include('layouts.header')


<section class="section-service-letters adjust-min-height">
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
                                        <label>Título</label>
                                        <input type="text" name="title" class="form-control input-sm" value="{{ old('title', $searchData ? $searchData['title'] : '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Categoria</label>
                                        <select name="category_id" class="form-control input-sm">
                                            <option>Todas</option>
                                            @foreach($categories->children as $category)
                                            <option value="{{ $category->id}}" {{ $searchData && $category->id == $searchData['category_id'] ? 'selected' : ''}}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <div class="form-group mb-0">
                                            <label>Descrição</label>
                                            <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $searchData ? $searchData['description'] : '') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('serviceLetter.page') }}" class="btn btn-search close btn-sm" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($serviceLetter && $serviceLetter->count() > 0)

        <div class="row">

            @foreach($serviceLetter as $service)
            <div class="col-md-12">
                <div class="card-with-links">
                    <a href="{{ route('serviceLetter.show', $service->slug) }}">
                        <div class="header">
                        @if($pageServiceLetter)
                            <i class="{{ $pageServiceLetter->icon }}"></i>
                        @endif
                        </div>
                        <div class="second-part">
                            <div class="body">
                                <h3 class="title">{{ $service->title }}</h3>
                                <p class="description">{{ $service->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            @endforeach

            {{ $serviceLetter->render() }}

        </div>

        @else
        <div class="empty-data">Nenhuma secretaria encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Cartas de Serviços'])

@include('layouts.footer')

@endsection