@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('sic.panel') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('ouvidoria.show') }}" class="link">Ouvidoria</a>
    </li>
    <li class="item">
        <span>Faq</span>
    </li>
</ul>
<h3 class="title text-center">Perguntas frequentes FAQ</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-ombudsman-faq pv-60">
    <div class="container">
        <div class="row">
            
            @include('pages.ombudsman.sidebar')

            @if($faqs && $faqs->count() > 0)
            <div class="col-md-8">
                <div class="container-faq">
                    <div class="body">
                        <div class="accordion" id="accordionFaq">
                            @foreach($faqs as $index => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="true" aria-controls="collapse-{{ $faq->id }}">
                                        <i class="fa-solid {{ $index == 0 ? 'fa-minus' : 'fa-plus' }}"></i>
                                        <!-- <i class="fa-solid fa-minus"></i> -->
                                        <span>{{ $faq->question }}</span>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : ''}}" aria-labelledby="heading-{{ $faq->id }}" data-bs-parent="#accordionFaq">
                                    <div class="accordion-body">{{ $faq->answer }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
        </div>
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'FAQ da Ouvidoria'])

@include('layouts.footer')

@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        //toggle accordion icon
        const accordionFaq = document.querySelector('#accordionFaq');
        const allItems = accordionFaq ? accordionFaq.querySelectorAll('.accordion-item') : [];
        
        allItems.forEach(item => {
            item.querySelector('.accordion-button').addEventListener('click', e => {
                const icon = e.target.querySelector('i');
                const currentClass = icon.classList.contains('fa-plus') ? 'fa-plus' : 'fa-minus';
                allItems.forEach(item => item.querySelector('.accordion-button i').classList.replace('fa-minus', 'fa-plus'));
                console.log('laele ', currentClass)
                if (currentClass == 'fa-plus') {
                    icon.classList.replace('fa-plus', 'fa-minus');
                } else {
                    icon.classList.replace('fa-minus', 'fa-plus');
                }
            });
        });

    });
</script>

@endsection