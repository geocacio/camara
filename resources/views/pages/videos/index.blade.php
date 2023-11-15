@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Vídeos</span>
    </li>
</ul>

<h3 class="title-sub-page main">Vídeos</h3>
@endsection

@section('content')

@include('layouts.header')



<section class="section-videos adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="#" method="post">
                            @csrf

                            <div class="form-group mb-0">
                                <label>Título</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $searchData ? $searchData['title'] : '') }}" />
                            </div>

                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('videos-all') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($videos->count() > 0)

            <div class="row">
                
                @foreach($videos as $video)
                    @if($video->video_source == 'internal')
                    <div class="col-md-6">
                        <div class="card-video">
                            <video class="videos video-interno" width="640" height="360" controls>
                                <source src="{{ asset('storage/'.$video->files[0]->file->url) }}" type="video/mp4">
                            </video>
                            <a href="{{ route('video.single', $video->slug) }}" class="title-video">{{ $video->title }}</a>
                            <p class="date mb-0"><i class="fa-solid fa-calendar-days"></i> {{ date('d/m/Y', strtotime($video->created_at)) }}</p>
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="card-video">
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

                            <a href="{{ route('video.single', $video->slug) }}" class="title-video">{{ $video->title }}</a>
                            <p class="date mb-0"><i class="fa-solid fa-calendar-days"></i> {{ date('d/m/Y', strtotime($video->created_at)) }}</p>
                        </div>
                    </div>
                    @endif
                @endforeach

                {{ $videos->render() }}

            </div>

        @else
            <div class="empty-data">Nenhum vídeo encontrado.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Vídeos'])

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