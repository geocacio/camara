@if($currentLegislature && $currentLegislature->count() > 0 && $section->visibility === 'enabled')
<section id="sec-ombudsman-list" class="ombudsman-list">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="title text-center mb-5">Vereadores Vigentes</h3>
                <div class="ombudsman-carousel owl-carousel carousel-councilors">
                    @foreach($currentLegislature->legislatureRelations as $legislature)
                    
                    <a href="{{ route('vereador.single', $legislature->legislatureable->slug) }}" class="item">
                        @if($legislature->legislatureable->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$legislature->legislatureable->files[0]->file->url) }}" alt="">
                        @endif
                        <div class="info">
                            <h3 class="name">{{ $legislature->legislatureable->surname }}</h3>
                            <p class="office">{{ $legislature->office->office }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif