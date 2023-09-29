@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Mapa do site</span>
    </li>
</ul>

<h3 class="title text-center mb-30">Mapa do site</h3>

@endsection

@section('content')

@include('layouts.header')



<section class="section-site-map adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card main-card">
                    <div class="accordion accordion-site-map">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#siteMap" aria-expanded="true" aria-controls="siteMap">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" y1="9" x2="6" y2="21"></line></svg>
                                    Mapa do site
                                </button>
                            </h2>
                            <div id="siteMap" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <div class="accordion">

                                        @foreach($menus['menuPrincipal']->links as $link)
                                            @if($link->name)
                                            
                                                @if($link->type == 'dropdown' && $link->group->count() > 0)
                                                    <div class="accordion-item">

                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-{{ $link->id }}" aria-expanded="true">
                                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" y1="9" x2="6" y2="21"></line></svg>
                                                                {{ $link->name}}
                                                            </button>
                                                        </h2>

                                                        <div id="accordion-{{ $link->id }}" class="accordion-collapse collapse">

                                                            <div class="accordion-body">

                                                                @foreach($link->group as $sublink)
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header">
                                                                            <a class="accordion-button" href="{{ $sublink->target_type == 'page' ? route($sublink->route) : $sublink->url }}">
                                                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                                            {{ $sublink->name }}
                                                                            </a>
                                                                        </h2>
                                                                    </div>
                                                                @endforeach
                                                                
                                                            </div>

                                                        </div>

                                                    </div>
                                                @else
                                                    @if($link->type != 'dropdown')
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <a class="accordion-button" href="{{ route($link->route) }}">
                                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                                                {{ $link->name }}
                                                            </a>
                                                        </h2>
                                                    </div>
                                                    @endif
                                                
                                                @endif
                                            @endif
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Mapa do site'])

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