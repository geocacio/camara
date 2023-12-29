@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Resultados da busca</span>
    </li>
</ul>
<h3 class="title text-center">Resultados da busca</h3>
{{-- <br/> --}}
{{-- <h5 class="text-center">({{ count($data) }}) Resultados encontrados</h5> --}}
@endsection

@section('content')

@include('layouts.header')

<section class="section-transparency adjust-min-height no-padding-top pv-60">
    <div class="container all-results">
        @include('pages.advanced-search.results')
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Busca avançada'])

@include('layouts.footer')

@endsection

<style>
.all-results {
    gap: 10px;
    display: flex;
    flex-direction: column;
}
</style>