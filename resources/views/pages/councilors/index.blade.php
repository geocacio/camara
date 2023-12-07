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
        <span>Legislatura: ({{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }})</span>
    </li>
</ul>

<h3 class="title-sub-page main"># {{ $currentLegislaturePosition }}  Legislatura: ({{ date('d/m/Y', strtotime($legislature->start_date)) }} - {{ date('d/m/Y', strtotime($legislature->end_date)) }})</h3>
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
                        <form action="#" method="post">
                            @csrf

                            <div class="form-group mb-0">
                                <label>Legislatura</label>
                                <select name="legislature_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @if($allLegislatures->count() > 0)
                                    @foreach($allLegislatures as $item)
                                    <option value="{{ $item->id }}" {{ count($searchData) > 0 ? ($item->id == $searchData['legislature_id'] ? 'selected' : '') : '' }}>({{ date('d/m/Y', strtotime($item->start_date)) }} {{ date('d/m/Y', strtotime($item->end_date)) }})</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('legislaturas-all') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($legislature->legislatureRelations)

            <div class="row gd-councilor-container">
                <div class="col-12">
                    <div class="card main-card">
                        @foreach($legislature->legislatureRelations as $councilor)
                            <div class="col-lg-6">
                                <a href="{{ route('vereador.single', $councilor->legislatureable->slug) }}" class="councilor-items">
                                    @if($councilor->legislatureable->files && count($councilor->legislatureable->files) > 0)
                                    <figure class="figure">
                                        <img class="image" src="{{ asset('storage/'.$councilor->legislatureable->files[0]->file->url) }}" alt="">
                                    </figure>
                                    @endif
                                    <div class="info">
                                        <span class="title">{{  $councilor->legislatureable->surname }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                
                @foreach($legislatures as $legislature)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="{{ route('vereadores-all', $legislature->slug) }}">
                            <div class="header">
                                <i class="fa-solid fa-microphone-lines"></i>
                            </div>
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">Legislatura: ({{ date('Y', strtotime($legislature->start_date)) }} - {{ date('Y', strtotime($legislature->end_date)) }})</h3>
                                    <ul>
                                        <li>Início:
                                            {{ date('d/m/Y', strtotime($legislature->start_date)) }}
                                        </li>
                                        <li>
                                            Fim:
                                            {{ date('d/m/Y', strtotime($legislature->end_date)) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                @endforeach

                {{ $legislatures->render() }}

            </div> --}}

        @else
            <div class="empty-data">Nenhum vereador encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Vereadores'])

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