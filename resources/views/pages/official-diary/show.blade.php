@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('official.diary.page') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Edições</a>
    </li>
</ul>
<h3 class="title text-center">Edições</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-diary margin-fixed-top">
    <div class="container">
        <div class="row">
            @include('pages.official-diary.sidebar')
            @include('pages.official-diary.diary-component', ['many' => true])
        </div>
    </div>
</section>

{{-- @include('pages.partials.satisfactionSurvey', ['page_name' => 'eSIC']) --}}

@include('layouts.footer')

@endsection