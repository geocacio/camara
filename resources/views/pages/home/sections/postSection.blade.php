@if(is_array($postsPorCategoria) && count($postsPorCategoria) > 0 && $section->visibility === 'enabled')
<section id="sec-blog-section" class="blog-section">
    @if($categories->count() > 0)
        <div class="categories-content">
            <div class="categories-news active-cat" id="0">#todos</div>
            @foreach ($categories as $cat)
                <div class="categories-news" id="{{ $cat->id }}">#{{ $cat->name }}</div>
            @endforeach
        </div>
    @endif

    @foreach($postsPorCategoria as $categoriaKey => $posts)
        <div @if($categoriaKey != 0) style="display: none;" @endif class="container post-content" id="category-{{ $categoriaKey }}">
            <div class="row">
                <div class="col-sm-6">
                    <div class="owl-carousel carousel-posts carousel-default">
                        @foreach($posts as $post)
                            @if(!$post->files->isEmpty())
                            <a href="{{ route('posts.show', $post->slug) }}"><img src="{{ asset('storage/'.$post->files[0]->file->url) }}"></a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="posts-container">
                        @foreach($posts as $post)
                        <div class="post">
                            <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="image-container">
                                @if(!$post->files->isEmpty())
                                <img src="{{ asset('storage/'.$post->files[0]->file->url) }}">
                                @endif
                            </a>
                            <div class="content">
                                <div>
                                    <span class="date">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans(\Carbon\Carbon::now()) }}</span>
                                </div>
                                <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="title">{{ $post->title }}</a>
                                @if($post->description)
                                <p class="text">{{ $post->description }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if(count($posts) > 0 )
                    <div class="col-12 mt-4">
                        <a href="{{ route('posts.getPosts')}}" class="btn btn-link-page">Todos os posts</a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</section>
@endif
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Adiciona a classe "active-cat" ao primeiro elemento
        $(".categories-news:first").addClass("active-cat");

        // Manipula o clique nos elementos categories-news
        $(".categories-news").click(function () {
            // Remove a classe "active-cat" de todos os elementos
            $(".categories-news").removeClass("active-cat");

            // Adiciona a classe "active-cat" ao elemento clicado
            $(this).addClass("active-cat");

            // Obtém o ID clicado, que já inclui "category-"
            var clickedId = $(this).attr("id");
            console.log(clickedId);

            // Esconde todos os contêineres
            $(".post-content").hide();

            // Mostra o contêiner correspondente ao ID clicado
            $("#category-" + clickedId).show();
        });
    });
</script>


