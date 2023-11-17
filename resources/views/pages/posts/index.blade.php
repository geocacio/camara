@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Notícias</span>
    </li>
</ul>

<h3 class="title-sub-page main">Notícias</h3>
@endsection

@section('content')

@include('layouts.header')

@if($posts)
<section>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card main-card container-search-advanced">
                <div class="search-advanced mb-0">
                    <h3 class="title">Campos para pesquisa</h3>
                    <form action="{{ route('posts.getPosts') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label>Título</label>
                                    <input type="text" name="title" class="form-control input-sm" value="{{ old('title', $searchData ? $searchData['title'] : '') }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label>Categoria</label>
                                    <select name="category_id" class="form-control input-sm">
                                        <option value="">Selecione</option>
                                        @if($categories->count() > 0)
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ isset($searchData['category_id']) && $searchData['category_id'] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-2 col-md-12">
                                <div class="h-100 form-group mb-0">
                                    <div class="btn-groups">
                                        <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        <a href="{{ route('posts.getPosts') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-post">
                <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="card-body card-post-list-blog">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            <figure>
                                <img src="{{ asset('storage/'.$post->files[0]->file->url)}}">
                            </figure>
                            <div class="content-post-blog">
                                <p>{{ $post->title }}</p>
                                <ul>
                                    <li>
                                        <i class="fa-solid fa-tag fa-fw"></i>
                                        #{{ $post->categories[0]->category->name}}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-clock fa-fw"></i>
                                        {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                    </li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach

                {{ $posts->render() }}

            </div>
            </div>
        </div>
    </div>
</div>
</section>
@endif

@include('layouts.footer')

@endsection