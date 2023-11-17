@if($videos && $videos->count() > 0 && $section->visibility === 'enabled')
<section id="videosSection" class="videos-section">
    <div class="container">
        <div class="row row-gap-15">
            <div class="col-12">
                <h3 class="title text-center mb-3">Vídeos relacionados a gestão</h3>
            </div>
            @foreach($videos as $video)
            @if($video->video_source == 'internal')
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <video class="videos video-interno" width="640" height="360" controls>
                            <source src="{{ asset('storage/'.$video->files[0]->file->url) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-6">
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

                <div class="card">
                    <div class="card-body">
                        <iframe class="videos video-incorporado" width="560" height="315" src="https://www.youtube.com/embed/{{$videoID}}" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @elseif ($video->video_source == 'facebook')
                @php
                // Obter o ID do vídeo do Facebook a partir do URL
                $videoURLComponents = parse_url($video->url);
                $videoPath = trim($videoURLComponents['path'], '/');
                $videoID = basename($videoPath);
                @endphp

                <div class="card">
                    <div class="card-body">
                        <iframe class="videos video-incorporado" width="560" height="315" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2F{{$videoID}}&show_text=0&width=560" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                @elseif ($video->video_source == 'instagram')
                @php
                // Obter o ID do vídeo do Instagram a partir do URL
                $videoURLComponents = parse_url($video->url);
                $videoPath = trim($videoURLComponents['path'], '/');
                $videoID = basename($videoPath);
                @endphp

                <div class="card">
                    <div class="card-body">
                        <blockquote class="instagram-media" data-instgrm-permalink="{{ $video->url }}" data-instgrm-version="13">
                            <a href="{{ $video->url }}" target="_blank" rel="noopener noreferrer">View this post on Instagram</a>
                        </blockquote>
                        <script async src="//www.instagram.com/embed.js"></script>
                    </div>
                </div>
                @endif
            </div>
            @endif
            @endforeach
            <div class="col-12 text-center mt-3"><a href="{{ route('videos-all')}}" class="btn btn-link-page">Clique aqui para visualizar todos os vídeos do nosso site</a></div>
        </div>
    </div>
</section>
@endif