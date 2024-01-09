@if($banners && $banners->count() > 0 && $section->visibility === 'enabled')
<div class="owl-carousel carousel-header colorful">
    @foreach($banners as $banner)
    @if(isset($banner->external_url))
        <a class="link" href="{{ $banner->external_url }}" style="background-color: {{ $banner->color }};" target="_blank" ><img src="{{ asset('storage/'.$banner->files[0]->file->url) }}"></a>
    @else
        <a class="link" href="{{ $banner->links ? ($banner->links->route ? route($banner->links->route) : $banner->links->url) : '#' }}" style="background-color: {{ $banner->color }};"><img src="{{ asset('storage/'.$banner->files[0]->file->url) }}"></a>
    @endif
    @endforeach
</div>
@endif