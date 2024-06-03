<div class="col-md-4">
    <div class="card main-card">
        <h3 class="title">Diário oficial</h3>

        <div class="card-body">
            <div class="group-links">
                <a href="{{ route('official.diary.page') }}" class="link {{ request()->routeIs('official.diary.page') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-columns"></i>
                    Inicio
                </a>
            </div>
            {{-- <div class="group-links">
                <a href="{{ route('official.diary.all') }}" class="link {{ request()->routeIs('official.diary.all') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    Edições
                </a>
            </div> --}}
            <div class="group-links">
                <a href="{{ route('official.diary.search') }}" class="link {{ request()->routeIs('official.diary.search') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Publicações
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('official.diary.normative') }}" class="link {{ request()->routeIs('official.diary.normative') ? 'active' : '' }}">
                    <i class="fa-solid fa-scale-balanced"></i>
                    Normativas
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('official.diary.presentation') }}" class="link {{ request()->routeIs('official.diary.presentation') ? 'active' : '' }}">
                    <i class="fa-solid fa-bookmark"></i>
                    Apresentação
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('expediente.show') }}" class="link {{ request()->routeIs('expediente.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-info"></i>
                    Expediente
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('entidade.show') }}" class="link {{ request()->routeIs('entidade.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-info"></i>
                    Entidade
                </a>
            </div>
        </div>
    </div>
</div>