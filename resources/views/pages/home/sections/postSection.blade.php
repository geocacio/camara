@if($posts && $posts->count() > 0 && $section->visibility === 'enabled')
<section id="sec-blog-section" class="blog-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="owl-carousel carousel-posts carousel-default">
                    @foreach($posts as $post)
                    @if(!$post->files->isEmpty())
                    <a href="#"><img src="{{ asset('storage/'.$post->files[0]->file->url) }}"></a>
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
                                <!-- {{-- <span class="category">#{{ $post->categories[0]->category->name}}</span> --}} -->
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
            {{-- <div class="col">
                <a href="{{ route('posts.getPosts')}}">Todos os posts</a>
            </div> --}}
        </div>
    </div>
</section>
@endif