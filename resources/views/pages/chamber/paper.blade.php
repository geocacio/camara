@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>{{ $paper->title }}</span>
    </li>
</ul>
@if($paper)
<h3 class="title text-center">{{ $paper->title}}</h3>
@endif
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman section-ombudsman-institutional margin-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card main-card card-manager">
                    <p class="title">{!! $paper->description !!}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Papel da câmara'])

@include('layouts.footer')

@endsection