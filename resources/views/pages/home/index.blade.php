@extends('layouts.app')

@section('content')

@include('layouts.header')

@if($sections && !empty($sections))

@foreach($sections as $section)

@php
$isStyles = $section->styles;
if($isStyles){
$styles = $isStyles;
}
@endphp
@include('pages.home.sections.' . $section->component)
@endforeach

@endif

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Home'])


@include('layouts.footer')

@endsection


@section('scripts')
<script>
    //carrousel
    $(document).ready(function() {
        $('.carousel-posts').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });

        $('.carousel-header').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });

        $('.carousel-councilors').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 4
                },
                1300: {
                    items: 7
                }
            }
        });
    });
</script>
@endsection