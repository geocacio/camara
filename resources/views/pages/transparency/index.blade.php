@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>{{ $transparencyPortal && $transparencyPortal->title ? $transparencyPortal->title : '' }}</span>
    </li>
</ul>
<h3 class="title text-center">{{ $transparencyPortal && $transparencyPortal->title ? $transparencyPortal->title : '' }}</h3>
@endsection

@section('content')

@include('layouts.header')

@if($transparencyPortal && $transparencyPortal->transparencyGroups && !empty($transparencyPortal->transparencyGroups))
<section class="section-transparency adjust-min-height no-padding-top pv-60">
    <div class="container">
        <div class="row">
            @foreach($transparencyPortal->transparencyGroups as $groups)
            @if(!empty($groups->contents->count() > 0))
            <div class="col-12 card">
                <div class="card-header text-center">
                    <h5 class="card-title">{{ $groups->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $groups->description }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($groups->contents && !empty($groups->contents))
                        @foreach($groups->contents as $content)
                        @if($content->pageable->visibility == 'enabled')
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <a href="{{ !$content->pageable->route ? ($content->pageable->url ? $content->pageable->url : '#') : route($content->pageable->route) }}" target="{{ $content->pageable->url ? '_blank' : '_self'}}" class="container-service">
                                <i class="{{ $content->pageable->icon }}"></i>
                                <span class="description">
                                    <p class="title">{{ $content->pageable->title }}</p>
                                    <p class="text">{{ $content->pageable->description }}</p>
                                </span>
                            </a>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Portal da transparência'])

@include('layouts.footer')

@endsection