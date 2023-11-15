@if($banners && $banners->count() > 0 && $section->visibility === 'enabled')
<div class="owl-carousel carousel-header colorful">
    @foreach($banners as $banner)
        <a class="link" href="{{ $banner->links ? ($banner->links->route ? route($banner->links->route) : $banner->links->url) : '#' }}" style="background-color: {{ $banner->color }};"><img src="{{ asset('storage/'.$banner->files[0]->file->url) }}"></a>
    @endforeach
</div>
@endif