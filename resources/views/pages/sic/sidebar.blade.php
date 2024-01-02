<div class="col-md-4">
    <div class="card main-card">
        <h3 class="title">Informações do e-SIC</h3>

        <div class="card-body">
            <div class="group-links">
                <a href="{{ route('sic.show') }}" class="link {{ request()->routeIs('sic.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-columns"></i>
                    Institucional
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('sic.panel') }}" class="link {{ request()->routeIs('sic.login') || request()->routeIs('sic.register') || request()->routeIs('sic.panel') || request()->routeIs('solicitacoes.index')|| request()->routeIs('solicitacoes.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-pointer"></i>
                    Acessar o SIC
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('manifestacao.show') }}" class="link {{ request()->routeIs('manifestacao.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-arrow-pointer"></i>
                    Manifestações
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('sic.reports') }}" class="link {{ request()->routeIs('sic.reports') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    Estatísticas
                </a>
            </div>
            <div class="group-links">
                <a href="{{ route('sic.relatorios.estatisticos') }}" class="link {{ request()->routeIs('sic.relatorios.estatisticos') ? 'active' : '' }}">
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