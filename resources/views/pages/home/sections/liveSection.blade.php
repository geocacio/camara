
@if($services && $services->count() > 0 && $section->visibility === 'enabled')
<section id="sec-live-section" class="live-section teste">
    <div class="container">
        <div class="row row-gap-30">
            @if($styles->count() > 0)
            <h3 class="featured-title mt-3 mb-3">Serviços online</h3>
            @else
            <h3 class="featured-title mt-3 mb-3">Serviços online</h3>
            @endif
            @foreach($services as $service)
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <a href="{{ $service->type == 'internal' ? route($service->url) : $service->url }}" {{ $service->type == 'external' ? 'target="_blank"' : ''}} class="container-service">
                    <i class="{{ $service->icon}}"></i>
                    <span class="description">
                        <p class="title">{{ $service->title }}</p>
                        <p class="text">{{ $service->text }}</p>
                    </span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif