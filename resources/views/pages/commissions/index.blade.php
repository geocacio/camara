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
        <span>Comissões</span>
    </li>
</ul>

<h3 class="title-sub-page main">Comissões</h3>
{{-- <p class="description-text main mb-30">{{ $page_law->description }}</p> --}}
@endsection

@section('content')

@include('layouts.header')



<section class="section-commissions adjust-min-height no-padding-top">
    <div class="container">

        @if($commissions->count() > 0)

            <div class="row">
                
                @foreach($commissions as $commission)
                
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="{{ route('comissoes.single', $commission->slug) }}">
                            <div class="header">
                                <i class="fa-solid fa-copy"></i>
                            </div>
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $commission->description }}</h3>
                                    <p class="description">{{ $commission->types[0]->name }}</p>
                                    {{-- <ul>
                                        <li>
                                            <i class="fa-solid fa-calendar-days"></i>
                                            {{ date('d/m/Y', strtotime($commission->date)) }}
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                @endforeach

                {{ $commissions->render() }}

            </div>

        @else
            <div class="empty-data">Nenhum comissão encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Comissões'])

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