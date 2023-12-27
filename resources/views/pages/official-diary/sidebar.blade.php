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
            <div class="group-links">
                <a href="{{ route('official.diary.all') }}" class="link {{ request()->routeIs('official.diary.all') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    Todos os diários
                </a>
            </div>
        </div>
    </div>
</div>