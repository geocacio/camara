@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('official.diary.page') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Diário Oficial Eletrônico</span>
    </li>
</ul>

<h3 class="title-sub-page main">Publicações</h3>
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
                        <form action="{{ route('official.diary.search') }}" method="post">
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
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('official.diary.search') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($dayles->count() > 0)

        <div class="row">
            
            @foreach($dayles as $index => $dayle)
                @if($dayle->files->count() > 0)
                    <div class="col-md-12">
                        <div class="card-with-links">

                            @if($dayle->files->count() > 0)
                                <a style="width: 62px;" href="{{ asset('storage/'.$dayle->files[0]->file->url) }}" target="_blank" class="header">
                                    <div>
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                </a>
                            @else
                                <div class="header">
                                    <i class="fa-regular fa-file-lines"></i>
                                </div>
                            @endif


                            <div class="second-part">
                                <div class="body">
                                    <p class="description">Vol: {{ $index + 1 }}/{{ $dayle->created_at->format('Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

        @else
            <div class="empty-data">Nenhuma publicação encontrada.</div>
        @endif

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