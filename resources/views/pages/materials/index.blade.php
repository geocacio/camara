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
        <span>Materiais</span>
    </li>
</ul>

<h3 class="title-sub-page main">Materiais</h3>
{{-- <p class="description-text main mb-30">{{ $page_law->description }}</p> --}}
@endsection

@section('content')

@include('layouts.header')



<section class="section-materials adjust-min-height no-padding-top">
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
                                        <label>Tipo</label>
                                        <select name="type_id" class="form-control">
                                            <option value="">Selecione</option>
                                            @if($types->count() > 0)
                                            @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Situação</label>
                                        <select name="status_id" class="form-control">
                                            <option value="">Selecione</option>
                                            @if($situations->count() > 0)
                                            @foreach($situations as $situation)
                                            <option value="{{ $situation->id }}">{{ $situation->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="description" class="form-control input-sm" value="{{ old('description', $searchData ? $searchData['description'] : '') }}" />
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

        @if($materials->count() > 0)

            <div class="row">
                
                @foreach($materials as $material)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="{{ route('materiais.single', $material->slug) }}">
                            <div class="header">
                                <i class="fa-solid fa-copy"></i>
                            </div>
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $material->type->name }}: {{ $material->id }}/{{ date('Y', strtotime($material->date)) }}</h3>
                                    <p class="description">{{ $material->description }}</p>
                                    <ul>
                                        <li>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            {{ date('d/m/Y', strtotime($material->date)) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                @endforeach

                {{ $materials->render() }}

            </div>

        @else
            <div class="empty-data">Nenhum material encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Leis'])

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