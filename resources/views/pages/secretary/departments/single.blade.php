@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('secretarias.show') }}" class="link">Secretarias</a>
    </li>
    <li class="item">
        <a href="{{ route('secretarias.single', $secretary->slug) }}" class="link">{{ $secretary->name }}</a>
    </li>
    <li class="item">
        <span>{{ $department->name }}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ $department->name }}</h3>
@endsection

@section('content')

@include('layouts.header')



<section class="section-laws adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card main-card">
                </div>
            </div>
            <div class="col-md-8">
                <div class="card main-card">
                </div>
            </div>
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => $department->name])

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