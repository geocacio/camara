@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Posts</span>
    </li>
</ul>

<h3 class="title-sub-page main">Posts</h3>
@endsection

@section('content')

@include('layouts.header')

@if($posts)
<section>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-post">
                <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="card-body card-post-list-blog">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <figure>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/FILE0101.jpg">
                            </figure>
                            <div class="content-post-blog">
                                {{-- <img src="{{ asset('storage/'.$post->featured_image)}}"> --}}
                                <p>{{ $post->title }}</p>
                                <ul>
                                    <li>
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #Desenvolvimento
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-clock fa-fw"></i>
                                        Há 2 dias
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>
</section>
@endif

@include('layouts.footer')

@endsection