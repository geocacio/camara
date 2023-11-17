@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('videos-all') }}" class="link">Vídeos</a>
    </li>
    <li class="item">
        <span>{{ $video->title }}</span>
    </li>
</ul>

<h3 class="title-sub-page main">{{ $video->title }}</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body content-video-box">
                    <h3 class="title">{{ $video->title }}</h3>
                    @if($video->video_source == 'youtube')
                    @php
                    if (parse_url($video->url, PHP_URL_QUERY)) {
                    // Obter a query string do URL
                    $urlQuery = parse_url($video->url, PHP_URL_QUERY);

                    // Extrair os parâmetros da query string
                    parse_str($urlQuery, $url);

                    // O ID do vídeo estará disponível em $url['v']
                    $videoID = isset($url['v']) ? $url['v'] : '';
                    } else {
                    // O URL não contém uma query string, então o ID do vídeo é obtido diretamente do caminho (path)
                    $videoID = basename(parse_url($video->url, PHP_URL_PATH));
                    }
                    @endphp
                    <iframe class="videos video-incorporado" width="560" height="315" src="https://www.youtube.com/embed/{{$videoID}}" frameborder="0" allowfullscreen></iframe>
                    @elseif ($video->video_source == 'facebook')
                    @php
                    // Obter o ID do vídeo do Facebook a partir do URL
                    $videoURLComponents = parse_url($video->url);
                    $videoPath = trim($videoURLComponents['path'], '/');
                    $videoID = basename($videoPath);
                    @endphp
                    <iframe class="videos video-incorporado" width="560" height="315" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2F{{$videoID}}&show_text=0&width=560" frameborder="0" allowfullscreen></iframe>
                    @elseif ($video->video_source == 'instagram')
                    @php
                    // Obter o ID do vídeo do Instagram a partir do URL
                    $videoURLComponents = parse_url($video->url);
                    $videoPath = trim($videoURLComponents['path'], '/');
                    $videoID = basename($videoPath);
                    @endphp
                    <blockquote class="instagram-media" data-instgrm-permalink="{{ $video->url }}" data-instgrm-version="13">
                        <a href="{{ $video->url }}" target="_blank" rel="noopener noreferrer">View this post on Instagram</a>
                    </blockquote>
                    <script async src="//www.instagram.com/embed.js"></script>
                    @endif
                    
                    <span class="time-post-video"><i class="fa-solid fa-calendar fa-fw"></i> {{ date('d \d\e F \d\e Y', strtotime($video->created_at)) }}</span>
                    <div class="text-box">
                        <p>{{ $video->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if($recentVideos && $recentVideos->count() > 0)
        <div class="col-md-4">
            <div class="card card-list-sidebar">
                <div class="card-body">
                    <ul class="list-post list-video">
                        <h3>Videos mais recentes</h3>
                        @foreach($recentVideos as $video)
                        <li>
                            <a href="{{ route('video.single', $video->slug) }}">
                                @if($video->video_source == 'youtube')
                                @php
                                if (parse_url($video->url, PHP_URL_QUERY)) {
                                // Obter a query string do URL
                                $urlQuery = parse_url($video->url, PHP_URL_QUERY);

                                // Extrair os parâmetros da query string
                                parse_str($urlQuery, $url);

                                // O ID do vídeo estará disponível em $url['v']
                                $videoID = isset($url['v']) ? $url['v'] : '';
                                } else {
                                // O URL não contém uma query string, então o ID do vídeo é obtido diretamente do caminho (path)
                                $videoID = basename(parse_url($video->url, PHP_URL_PATH));
                                }
                                @endphp
                                <iframe class="videos video-incorporado" width="560" height="315" src="https://www.youtube.com/embed/{{$videoID}}" frameborder="0" allowfullscreen></iframe>
                                @elseif ($video->video_source == 'facebook')
                                @php
                                // Obter o ID do vídeo do Facebook a partir do URL
                                $videoURLComponents = parse_url($video->url);
                                $videoPath = trim($videoURLComponents['path'], '/');
                                $videoID = basename($videoPath);
                                @endphp
                                <iframe class="videos video-incorporado" width="560" height="315" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2F{{$videoID}}&show_text=0&width=560" frameborder="0" allowfullscreen></iframe>
                                @elseif ($video->video_source == 'instagram')
                                @php
                                // Obter o ID do vídeo do Instagram a partir do URL
                                $videoURLComponents = parse_url($video->url);
                                $videoPath = trim($videoURLComponents['path'], '/');
                                $videoID = basename($videoPath);
                                @endphp
                                <blockquote class="instagram-media" data-instgrm-permalink="{{ $video->url }}" data-instgrm-version="13">
                                    <a href="{{ $video->url }}" target="_blank" rel="noopener noreferrer">View this post on Instagram</a>
                                </blockquote>
                                <script async src="//www.instagram.com/embed.js"></script>
                                @endif
                                <div class="info-post-list">
                                    <h3>{{ $video->title }}</h3>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Vídeo'])

@include('layouts.footer')

@endsection