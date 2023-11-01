@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Prefeito e Vice-prefeito</span>
    </li>
</ul>

<h3 class="title text-center mb-30">Gestores</h3>

@endsection

@section('content')

@include('layouts.header')



<section class="section-managers adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card main-card card-manager">

                    <h1 class="title">Prefeito</h1>

                    <ul class="manager-networks">
                        <!-- <li>
                            <a href="#" class="twitter">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li> -->
                        @if($mayor && $mayor->instagram)
                        <li>
                            <a href="{{ $mayor->instagram }}" target="_blank" class="instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        @endif
                        @if($mayor && $mayor->facebook)
                        <li>
                            <a href="{{ $mayor->facebook }}" target="_blank" class="facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="#" class="whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </li> -->
                    </ul>
                    <figure class="img-managers">
                        @if($mayor && $mayor->files->count() > 0)
                        <img src="{{ asset('storage/'.$mayor->files[0]->file->url) }}" class="" />
                        @endif
                    </figure>
                    <h3 class="name-managers">{{ $mayor ? $mayor->name : '' }}</h3>
                    <div class="text-page">
                        <p>{{ $mayor ? $mayor->biography : '' }}</p>
                    </div>
                </div>

                <div class="card main-card card-manager">
                    <h1 class="title">Vice-Prefeito</h1>

                    <ul class="manager-networks">
                        <!-- <li>
                            <a href="#" class="twitter">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li> -->
                        @if($viceMayor && $viceMayor->instagram)
                        <li>
                            <a href="{{ $viceMayor->instagram }}" target="_blank" class="instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        @endif
                        @if($viceMayor && $viceMayor->facebook)
                        <li>
                            <a href="{{ $viceMayor->facebook }}" target="_blank" class="facebook">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="#" class="whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </li> -->
                    </ul>
                    <figure class="img-managers">
                        @if($viceMayor && $viceMayor->files->count() > 0)
                            <img src="{{ asset('storage/'.$viceMayor->files[0]->file->url) }}" class="" />
                        @endif
                    </figure>
                    <h3 class="name-managers">{{ $viceMayor ? $viceMayor->name : '' }}</h3>
                    <div class="text-page">
                        <p>{{ $viceMayor ? $viceMayor->biography : '' }}</p>
                    </div>
                </div>

            </div>

            @include('partials.tableWithoutPaginate', ['data' => $managers, 'actions' => false])
        </div>
    </div>

</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Prefeito e Vice-Prefeito'])

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