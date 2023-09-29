@extends('layouts.app')

@section('content')

<section>
<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">{{ $post->title }}</h3>
            @if($image)
            <img src="{{ asset('storage/'.$image->url)}}" class="mb-5" style="max-height: 300px; width: 100%; object-fit: cover">
            @endif
            {!! $post->content !!}
        </div>
    </div>
</div>
</section>
@endsection