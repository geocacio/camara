@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('posts.getPosts') }}" class="link">Notícias</a>
    </li>
    <li class="item">
        <span>{{ $post->title }}</span>
    </li>
</ul>
<h3 class="title text-center"></h3>
@endsection

@section('content')

@include('layouts.header')

@section('content')

<section>
    {{-- {{ dd($post) }} --}}
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-post">
                <div class="card-header">
                    <h3 class="mb-3 text-center">{{ $post->title }}</h3>
                    <figure class="img-post">
                        <img src="{{ asset('storage/'.$image->url)}}" class="mb-5" style="max-height: 300px; width: 100%; object-fit: cover">

                        <ul class="social-media-post">
                            <li>
                                <a href="mailto:?subject=Assunto do Email&body={{ url()->current() }}" class="email">
                                    <i class="fa-brands fa-google fa-fw"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" class="facebook" target="_blank">
                                    <i class="fa-brands fa-facebook fa-fw"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/share?url={{ url()->current() }}" class="instagram" target="_blank">
                                    <i class="fa-brands fa-instagram fa-fw"></i>
                                </a>
                            </li>
                        </ul>
                        

                        <ul class="list-info-post">
                            <li>
                                <i class="fa-solid fa-tag fa-fw"></i>
                                #{{ $post->categories[0]->category->name }}
                            </li>
                            <li>
                                <i class="fa-solid fa-calendar-days fa-fw"></i>
                                {{ date('d \d\e F \d\e Y', strtotime($post->created_at)) }}
                            </li>
                            <li>
                                <i class="fa-solid fa-eye fa-fw"></i>
                                {{ isset($post->views) ? $post->views : '0' }}
                             </li>
                        </ul>
                    </figure>
                </div>
                <div class="card-body">
                    {!! $post->content !!}
                </div>
                <ul>
                    <li>

                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-list-sidebar">
                <div class="card-body">
                    @if(count($generalPosts['mostViewedPosts']))
                    <ul class="list-post">
                        <h3>Notícias mais vistas</h3>
                        @foreach($generalPosts['mostViewedPosts'] as $post)
                        <li>
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <figure>
                                    <img src="{{ asset('storage/'.$post->files[0]->file->url) }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #{{ $post->categories[0]->category->name}}
                                    </span>
                                    <h3>{{ $post->title }}</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    @if(count($generalPosts['recentsPosts']))
                    <ul class="list-post">
                        <h3>Notícias mais recentes</h3>
                        @foreach($generalPosts['recentsPosts'] as $post)
                        <li>
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <figure>
                                    <img src="{{ asset('storage/'.$post->files[0]->file->url) }}" />
                                </figure>
                                <div class="info-post-list">
                                    <span class="tags">
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #{{ $post->categories[0]->category->name}}
                                    </span>
                                    <h3>{{ $post->title }}</h3>
                                    <span class="hours"><i class="fa-solid fa-clock fa-fw"></i> {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    @if(count($generalPosts['categories']))
                    <ul class="list-category">
                        <h3>Categorias</h3>
                        @foreach($generalPosts['categories'] as $category)
                        <li>
                            <a href="#" onclick="event.preventDefault();
                            document.getElementById('gotoPost-{{ $category->id }}').submit();">
                                <span class="item-category">
                                    <i class="fa-solid fa-tag fa-fw"></i>
                                    {{ $category->name }}
                                </span>
                                <span class="count-category">
                                    {{ $category->post_count }}
                                </span>
                            </a>
                        </li>

                        <form id="gotoPost-{{ $category->id }}" action="{{ route('posts.getPosts') }}" method="post" style="display: none;">
                            @csrf
                            <input type="hidden" name="title" value="">
                            <input type="hidden" name="category_id" value="{{ $category->id}}">
                        </form>

                        @endforeach
                    </ul>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
</section>
@include('pages.partials.satisfactionSurvey', ['page_name' => 'Portal da transparência'])

@include('layouts.footer')

@endsection