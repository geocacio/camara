@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Termos de uso</span>
    </li>
</ul>

<div class="text-term">
    {!! $term->content !!}
</div>

@endsection

@section('content')

@include('layouts.header')

<section class="section-sessions adjust-min-height no-padding-top">
    <div class="container">
        
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'veiculos'])

@include('layouts.footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<style>
    .no-vehicle {
        font-size: 13px;
        color: #0c0c0c;
        text-align: justify;
        margin-bottom: 0;
        text-overflow: ellipsis;
    }
</style>

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection