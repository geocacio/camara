<div class="col-md-4">
    <div class="card main-card">
        <h3 class="title">Informações da ouvidoria</h3>

        <div class="card-body">
            <div class="group-links">
                <a href="{{ route('institucional.show') }}" class="link {{ request()->routeIs('institucional.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-columns"></i>
                    Institucional
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('manifestacao.show') }}" class="link {{ request()->routeIs('manifestacao.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-pointer"></i>
                    Manifestações
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('estatisticas.reports') }}" class="link {{ request()->routeIs('estatisticas.reports') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    Estatísticas
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('relatorios.estatisticos.reports') }}" class="link {{ request()->routeIs('relatorios.estatisticos.reports') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-simple"></i>
                    Relatório estatísticos
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('ombudsman.faqs.show') }}" class="link {{ request()->routeIs('ombudsman.faqs.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-question"></i>
                    Faq
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('seekManifestation.show') }}" class="link {{ request()->routeIs('manifestacao.search') || request()->routeIs('seekManifestation.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Acompanhar manifestação
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('survey.show') }}" class="link {{ request()->routeIs('survey.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-face-smile"></i>
                    Pesquisa de satisfação
                </a>
            </div>
        </div>
    </div>
</div>