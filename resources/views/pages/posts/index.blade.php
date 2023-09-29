@extends('layouts.app')

@section('content')
@if($posts)
<section>
<div class="container">
    <div class="row">
        @foreach($posts as $post)
        <div class="col">
            <a href="{{ route('posts.show', $post->slug) }}" class="mb-3 text-center">{{ $post->title }}</a>
            <a href="{{ route('posts.show', $post->slug) }}"><img src="{{ asset('storage/'.$post->featured_image)}}" class="mb-5" style="max-height: 300px; width: 100%; object-fit: cover"></a>
        </div>
        @endforeach
    </div>
</div>
</section>
@endif
@endsection