<ul id="accordion" class="sidebar-menu">
    <li class="menu-item">
        <button class="menu-link active" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Dashboard</span>
        </button>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item">
                    <a href="#" class="sub-link">Dashboard 1</a>
                </li>
                <li class="sub-item">
                    <a href="#" class="sub-link">Dashboard 2</a>
                </li>
                <li class="sub-item">
                    <a href="#" class="sub-link">Dashboard 3</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('banners.index') ? 'active' : '' }}">
        <a href="{{ route('banners.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Banners</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('settings.page') || request()->routeIs('pcs.index') || request()->routeIs('pcg.index') || request()->routeIs('constructions.index') || request()->routeIs('construnctions.index') || request()->routeIs('agreements.index') || request()->routeIs('serviceLetter.indexPage') || request()->routeIs('serviceLetter.index') || Str::contains(url()->current(), 'categories/cartas-de-servicos') || request()->routeIs('proccess.selective.page') || request()->routeIs('selective-process.index') || request()->routeIs('publications.page') || request()->routeIs('all-publications.index') || Str::contains(url()->current(), 'types/publications') || request()->routeIs('ordinances.page') || request()->routeIs('ordinances.index') || Str::contains(url()->current(), 'types/ordinances') || request()->routeIs('decrees.index') || request()->routeIs('decrees.page') || Str::contains(url()->current(), 'types/decrees') || request()->routeIs('laws.page') || request()->routeIs('laws.index') || Str::contains(url()->current(), 'types/law') || request()->routeIs('symbols.index') || request()->routeIs('payrolls.index') || request()->routeIs('managers.index') || request()->routeIs('sic.faq.index') || request()->routeIs('solicitations.index') || request()->routeIs('esic.index') || request()->routeIs('ombudsman-survey.index') || request()->routeIs('dailies.index') || request()->routeIs('dailies.page') || request()->routeIs('ombudsman-feedback.index') || request()->routeIs('ombudsman-faq.index') || request()->routeIs('ombudsman-institutional.index') || request()->routeIs('ombudsman-feedback.index') || request()->routeIs('ombudsman.index') || request()->routeIs('external-links.index') || request()->routeIs('transparency.groups.index') || request()->routeIs('transparency.index') || request()->routeIs('ombudsman-faq.index') || request()->routeIs('ombudsman-institutional.index') || request()->routeIs('ombudsman-feedback.index') || request()->routeIs('all-publications.index') || request()->routeIs('all-publications.create') || request()->routeIs('all-publications.edit') || request()->routeIs('dailies.index') || request()->routeIs('ordinances.index') || Str::contains(url()->current(), 'types/ordinances') || request()->routeIs('lrfs.index') || Str::contains(url()->current(), 'types/lrfs') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z" />
            </svg>
            <span>Transparência</span>
        </button>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('transparency.index') ? 'active' : '' }}">
                    <a href="{{ route('transparency.index') }}" class="sub-link">Página</a>
                </li>
                <li class="sub-item {{ request()->routeIs('settings.page') ? 'active' : '' }}">
                    <a href="{{ route('settings.page') }}" class="sub-link">Sobre a Câmara</a>
                </li>
                <li class="sub-item {{ request()->routeIs('transparency.groups.index') ? 'active' : '' }}">
                    <a href="{{ route('transparency.groups.index') }}" class="sub-link">Grupos</a>
                </li>
                <li class="sub-item-menu {{ request()->routeIs('ombudsman-survey.index') || request()->routeIs('ombudsman-feedback.index') || request()->routeIs('ombudsman-faq.index') || request()->routeIs('ombudsman-institutional.index') || request()->routeIs('ombudsman-feedback.index') || request()->routeIs('ombudsman.index') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseOmbudsman">
                        <span>Ouvidoria</span>
                    </button>

                    <div id="collapseOmbudsman" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('ombudsman.index') ? 'active' : '' }}">
                                <a href="{{ route('ombudsman.index') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('ombudsman-feedback.index') ? 'active' : '' }}">
                                <a href="{{ route('ombudsman-feedback.index') }}" class="sub-link">Manifestações</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('ombudsman-institutional.index') ? 'active' : '' }}">
                                <a href="{{ route('ombudsman-institutional.index') }}" class="sub-link">Institucional</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('ombudsman-faq.index') ? 'active' : '' }}">
                                <a href="{{ route('ombudsman-faq.index') }}" class="sub-link">FAQ</a>
                            </li>

                            <li class="sub-item {{ request()->routeIs('ombudsman-survey.index') ? 'active' : '' }}">
                                <a href="{{ route('ombudsman-survey.index') }}" class="sub-link">Pesquisa de Satisfação</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item {{ request()->routeIs('serviceLetter.indexPage') || request()->routeIs('serviceLetter.index') || Str::contains(url()->current(), 'categories/cartas-de-servicos') ? 'active' : '' }}">
                    <a href="{{ route('serviceLetter.index') }}" class="sub-link">Cartas de Serviços</a>
                </li>
                <li class="sub-item-menu {{ request()->routeIs('sic.faq.index') || request()->routeIs('solicitations.index') || request()->routeIs('esic.index') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseSic">
                        <span>SIC</span>
                    </button>

                    <div id="collapseSic" class="collapse" aria-labelledby="headingOne">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('esic.index') ? 'active' : '' }}">
                                <a href="{{ route('esic.index') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('solicitations.index') ? 'active' : '' }}">
                                <a href="{{ route('solicitations.index') }}" class="sub-link">Solicitações</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('sic.faq.index') ? 'active' : '' }}">
                                <a href="{{ route('sic.faq.index') }}" class="sub-link">FAQ</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item {{ request()->routeIs('laws.page') || request()->routeIs('laws.index') || Str::contains(url()->current(), 'types/law') ? 'active' : '' }}">
                    <a href="{{ route('laws.index') }}" class="sub-link">Leis</a>
                </li>
                <li class="sub-item {{ request()->routeIs('external-links.index') ? 'active' : '' }}">
                    <a href="{{ route('external-links.index') }}" class="sub-link">Serviços Externos</a>
                </li>
                <li class="sub-item-menu {{ request()->routeIs('lrfs.index') || Str::contains(url()->current(), 'types/lrfs') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseLRF">
                        <span>LRF</span>
                    </button>

                    <div id="collapseLRF" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('lrf-edit.page') ? 'active' : '' }}">
                                <a href="{{ route('lrf-edit.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('lrfs.index') ? 'active' : '' }}">
                                <a href="{{ route('lrfs.index') }}" class="sub-link">Todas</a>
                            </li>
                            <li class="sub-item {{ Str::contains(url()->current(), 'types/lrfs') ? 'active' : '' }}">
                                <a href="{{ route('subtypes.index', 'lrfs') }}" class="sub-link">Tipos</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item {{ request()->routeIs('pcg.index') ? 'active' : '' }}">
                    <a href="{{ route('pcg.index') }}" class="sub-link">PCG</a>
                </li>
                <li class="sub-item {{ request()->routeIs('pcs.index') ? 'active' : '' }}">
                    <a href="{{ route('pcs.index') }}" class="sub-link">PCS</a>
                </li>
                <li class="sub-item-menu {{  request()->routeIs('ordinances.page') || request()->routeIs('ordinances.index') || Str::contains(url()->current(), 'types/ordinances') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseOrdinance">
                        <span>Portarias</span>
                    </button>

                    <div id="collapseOrdinance" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('ordinances.page') ? 'active' : '' }}">
                                <a href="{{ route('ordinances.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('ordinances.index') ? 'active' : '' }}">
                                <a href="{{ route('ordinances.index') }}" class="sub-link">Todas</a>
                            </li>
                            <li class="sub-item {{ Str::contains(url()->current(), 'types/ordinances') ? 'active' : '' }}">
                                <a href="{{ route('subtypes.index', 'ordinances') }}" class="sub-link">Tipos</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item-menu {{ request()->routeIs('dailies.page') || request()->routeIs('dailies.index') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseDailies">
                        <span>Diárias</span>
                    </button>

                    <div id="collapseDailies" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('dailies.page') ? 'active' : '' }}">
                                <a href="{{ route('dailies.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('dailies.index') ? 'active' : '' }}">
                                <a href="{{ route('dailies.index') }}" class="sub-link">Todas</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item-menu {{ request()->routeIs('decrees.index') || request()->routeIs('decrees.page') || Str::contains(url()->current(), 'types/decrees') ? 'active' : '' }}">
                    <button class="menu-link" data-toggle="collapse" data-target="#collapseDecree" aria-expanded="true" aria-controls="collapseDecree">
                        <span>Decretos</span>
                    </button>

                    <div id="collapseDecree" class="collapse" aria-labelledby="headingOne">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('decrees.page') ? 'active' : '' }}">
                                <a href="{{ route('decrees.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('decrees.index') ? 'active' : '' }}">
                                <a href="{{ route('decrees.index') }}" class="sub-link">Todos</a>
                            </li>
                            <li class="sub-item {{ Str::contains(url()->current(), 'types/decrees') ? 'active' : '' }}">
                                <a href="{{ route('subtypes.index', 'decrees') }}" class="sub-link">Tipos</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sub-item-menu {{ request()->routeIs('publications.page') || request()->routeIs('all-publications.index') || Str::contains(url()->current(), 'types/publications') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapsePublications">
                        <span>Publicações</span>
                    </button>

                    <div id="collapsePublications" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('publications.page') ? 'active' : '' }}">
                                <a href="{{ route('publications.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('all-publications.index') ? 'active' : '' }}">
                                <a href="{{ route('all-publications.index') }}" class="sub-link">Todas</a>
                            </li>
                            <li class="sub-item {{ Str::contains(url()->current(), 'types/publications') ? 'active' : '' }}">
                                <a href="{{ route('subtypes.index', 'publications') }}" class="sub-link">Tipos</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item {{ request()->routeIs('proccess.selective.page') || request()->routeIs('selective-process.index') ? 'active' : '' }}">
                    <a href="{{ route('selective-process.index') }}" class="sub-link">Processo Seletivo</a>
                </li>
                <li class="sub-item {{ request()->routeIs('managers.index') ? 'active' : '' }}">
                    <a href="{{ route('managers.index') }}" class="sub-link">Gestores</a>
                </li>
                <li class="sub-item {{ request()->routeIs('payrolls.index') ? 'active' : '' }}">
                    <a href="{{ route('payrolls.index') }}" class="sub-link">Folhas de pagamento</a>
                </li>
                <li class="sub-item {{ request()->routeIs('symbols.index') ? 'active' : '' }}">
                    <a href="{{ route('symbols.index') }}" class="sub-link">Símbolos</a>
                </li>
                <li class="sub-item {{ request()->routeIs('agreements.index') ? 'active' : '' }}">
                    <a href="{{ route('agreements.index') }}" class="sub-link">Convênios</a>
                </li>
                <li class="sub-item {{ request()->routeIs('constructions.index') ? 'active' : '' }}">
                    <a href="{{ route('constructions.index') }}" class="sub-link">Obras</a>
                </li>
                <li class="sub-item {{ request()->routeIs('constructions.index') ? 'active' : '' }}">
                    <a href="{{ route('constructions.index') }}" class="sub-link">Obras</a>
                </li>
                <li class="sub-item {{ request()->routeIs('atricon.index') ? 'active' : '' }}">
                    <a href="{{ route('atricon.index') }}" class="sub-link">Atricon</a>
                </li>
                <li class="sub-item-menu {{ request()->routeIs('veiculos.index') || Str::contains(url()->current(), 'types/veiculos') ? 'active' : '' }}">

                    <button class="menu-link no-padding" data-toggle="collapse" href="#collapseVeiculos">
                        <span>Veiculos</span>
                    </button>

                    <div id="collapseVeiculos" class="collapse" aria-labelledby="headingOne" data-parent="#collapseTwo">
                        <ul class="sub-menu">
                            <li class="sub-item {{ request()->routeIs('veiculos.page') ? 'active' : '' }}">
                                <a href="{{ route('veiculos.page') }}" class="sub-link">Página</a>
                            </li>
                            <li class="sub-item {{ request()->routeIs('veiculos.index') ? 'active' : '' }}">
                                <a href="{{ route('veiculos.index') }}" class="sub-link">Todas</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="sub-item {{ request()->routeIs('mapa.page.show') ? 'active' : '' }}">
                    <a href="{{ route('mapa.page.show') }}" class="sub-link">Mapa do Site</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('posts.index') || Str::contains(url()->current(), 'posts') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapsePost" aria-expanded="true" aria-controls="collapsePost">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Posts</span>
        </button>

        <div id="collapsePost" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('posts.index') ? 'active' : '' }}">
                    <a href="{{ route('posts.index') }}" class="sub-link">Todos</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/posts') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'posts') }}" class="sub-link">Categorias</a>
                </li>
            </ul>
        </div>
    </li>
    <!-- <li class="menu-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
        <a href="{{ route('categories.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Categorias</span>
        </a>
    </li> -->
    <li class="menu-item {{ Str::contains(url()->current(), 'categories/exercicios') || Str::contains(url()->current(), 'categories/competencias') || Str::contains(url()->current(), 'categories/grupos') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#otherCategories" aria-expanded="true" aria-controls="otherCategories">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span>Categorias</span>
        </button>

        <div id="otherCategories" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/exercicios') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'exercicios') }}" class="sub-link">Exercícios</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/competencias') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'competencias') }}" class="sub-link">Competencias</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/grupos') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'grupos') }}" class="sub-link">Grupos</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('legislatures.index') ? 'active' : '' }}">
        <a href="{{ route('legislatures.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Legislaturas</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('contact-us.page') ? 'active' : '' }}">
        <a href="{{ route('contact-us.page') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Contato</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('sessions.index') ? 'active' : '' }}">
        <a href="{{ route('sessions.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Sessões</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('affiliations.index') ? 'active' : '' }}">
        <a href="{{ route('affiliations.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Partidos</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('councilors.index') ? 'active' : '' }}">
        <a href="{{ route('councilors.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Vereadores</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('commissions.index') ? 'active' : '' }}">
        <a href="{{ route('commissions.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Comissões</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('materials.index') ? 'active' : '' }}">
        <a href="{{ route('materials.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Materiais</span>
        </a>
    </li>


    <li class="menu-item {{ request()->routeIs('role.councilor.page') || request()->routeIs('role-councilor.index') ? 'active' : '' }}">
        <button class="menu-link active" data-toggle="collapse" data-target="#roleCouncilor" aria-expanded="true" aria-controls="roleCouncilor">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Papel do Vereador</span>
        </button>

        <div id="roleCouncilor" class="collapse">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('role.councilor.page') ? 'active' : '' }}">
                    <a href="{{ route('role.councilor.page') }}" class="sub-link">Página</a>
                </li>
                <li class="sub-item {{ request()->routeIs('role-councilor.index') ? 'active' : '' }}">
                    <a href="{{ route('role-councilor.index') }}" class="sub-link">Novo</a>
                </li>
            </ul>
        </div>
    </li>

    <li class="menu-item {{ request()->routeIs('chamber.page') || request()->routeIs('role-chambers.index') ? 'active' : '' }}">
        <button class="menu-link active" data-toggle="collapse" data-target="#roleChamber" aria-expanded="true" aria-controls="roleChamber">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span>Papel da Câmara</span>
        </button>

        <div id="roleChamber" class="collapse">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('chamber.page') ? 'active' : '' }}">
                    <a href="{{ route('chamber.page') }}" class="sub-link">Página</a>
                </li>
                <li class="sub-item {{ request()->routeIs('role-chambers.index') ? 'active' : '' }}">
                    <a href="{{ route('role-chambers.index') }}" class="sub-link">Novo</a>
                </li>
            </ul>
        </div>
    </li>


    <li class="menu-item {{ request()->routeIs('secretaries.index') ? 'active' : '' }}">
        <a href="{{ route('secretaries.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Secretarias</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('organs.index') ? 'active' : '' }}">
        <a href="{{ route('organs.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Orgãos</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('departments.index') ? 'active' : '' }}">
        <a href="{{ route('departments.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Departamentos</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('sectors.index') ? 'active' : '' }}">
        <a href="{{ route('sectors.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Setores</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('employees.index') || request()->routeIs('offices.index') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true" aria-controls="collapseEmployee">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span>Funcionários</span>
        </button>

        <div id="collapseEmployee" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('employees.index') ? 'active' : '' }}">
                    <a href="{{ route('employees.index') }}" class="sub-link">Todos</a>
                </li>
                <li class="sub-item {{ request()->routeIs('offices.index') ? 'active' : '' }}">
                    <a href="{{ route('offices.index') }}" class="sub-link">Cargos</a>
                </li>
                <li class="sub-item {{ request()->routeIs('terceirizados.page') ? 'active' : '' }}">
                    <a href="{{ route('terceirizados.page') }}" class="sub-link">Página de Terceirizados</a>
                </li>
                <li class="sub-item {{ request()->routeIs('treinee.page') ? 'active' : '' }}">
                    <a href="{{ route('treinee.page') }}" class="sub-link">Página de Estagiários</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('schedules.index') ? 'active' : '' }}">
        <a href="{{ route('schedules.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Agenda</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('services.index') ? 'active' : '' }}">
        <a href="{{ route('services.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Serviços</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('official-diary.index') || request()->routeIs('configure-official-diary.index') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseDiary" aria-expanded="true" aria-controls="collapseDiary">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span>Diário Oficial</span>
        </button>

        <div id="collapseDiary" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('official-diary.index') ? 'active' : '' }}">
                    <a href="{{ route('official-diary.index') }}" class="sub-link">Todos</a>
                </li>
                <li class="sub-item {{ request()->routeIs('configure-official-diary.index') ? 'active' : '' }}">
                    <a href="{{ route('configure-official-diary.index') }}" class="sub-link">Configurações</a>
                </li>
                <li class="sub-item {{ request()->routeIs('diary.expedient') ? 'active' : '' }}">
                    <a href="{{ route('diary.expedient') }}" class="sub-link">Expediente</a>
                </li>
                <li class="sub-item {{ request()->routeIs('diary.expedient') ? 'active' : '' }}">
                    <a href="{{ route('normative.index') }}" class="sub-link">Normativas</a>
                </li>
                <li class="sub-item {{ request()->routeIs('presentation.index') ? 'active' : '' }}">
                    <a href="{{ route('presentation.index') }}" class="sub-link">Apresentação</a>
                </li>
                <li class="sub-item {{ request()->routeIs('journal.page') ? 'active' : '' }}">
                    <a href="{{ route('journal.page') }}" class="sub-link">Página</a>
                </li>
            </ul>
        </div>
    </li>
    <!-- {{-- <li class="menu-item {{ request()->routeIs('secretary-publication.index') ? 'active' : '' }}">
        <a href="{{ route('secretary-publication.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Publicações</span>
        </a>
    </li> --}} -->
    <li class="menu-item {{ Str::contains(url()->current(), 'categories/sumario') ? 'active' : '' }}">
        <a href="{{ route('subcategories.index', 'sumario') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Sumário</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('glossary.index') ? 'active' : '' }}">
        <a href="{{ route('glossary.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Glossário</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('dictionary.index') ? 'active' : '' }}">
        <a href="{{ route('dictionary.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Dicionário</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('biddings.index') || Str::contains(url()->current(), 'categories/modalidades') || Str::contains(url()->current(), 'categories/responsabilidades') || Str::contains(url()->current(), 'types/biddings') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseBidding" aria-expanded="true" aria-controls="collapseBidding">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Licitações</span>
        </button>

        <div id="collapseBidding" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('biddings.index') ? 'active' : '' }}">
                    <a href="{{ route('biddings.index') }}" class="sub-link">Todas</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/modalidades') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'modalidades') }}" class="sub-link">Modalidades</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/responsabilidades') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'responsabilidades') }}" class="sub-link">Responsabilidades</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/concorrencia') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'concorrencia') }}" class="sub-link">Concorrências</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'types/biddings') ? 'active' : '' }}">
                    <a href="{{ route('subtypes.index', 'biddings') }}" class="sub-link">Tipos</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'dispesas-inexigibilidade/biddings') ? 'active' : '' }}">
                    <a href="{{ route('dispensa.index', 'biddings') }}" class="sub-link">Dispensa e Inexigibilidade</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'register-price') ? 'active' : '' }}">
                    <a href="{{ route('register-price.index') }}" class="sub-link">Atas de registro de preço</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'bidding/dispesas-inexigibilidade/create') ? 'active' : '' }}">
                    <a href="{{ route('bidding.page.create', 'biddings') }}" class="sub-link">Página</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('fiscais.index') ? 'active' : '' }}">
        <a href="{{ route('fiscais.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Fiscais de Contratos</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('videos.index') || Str::contains(url()->current(), 'categories/videos') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseVideo" aria-expanded="true" aria-controls="collapseVideo">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>Vídeos</span>
        </button>

        <div id="collapseVideo" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('videos.index') ? 'active' : '' }}">
                    <a href="{{ route('videos.index') }}" class="sub-link">Todos</a>
                </li>
                <li class="sub-item {{ Str::contains(url()->current(), 'categories/videos') ? 'active' : '' }}">
                    <a href="{{ route('subcategories.index', 'videos') }}" class="sub-link">Categorias</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="menu-item {{ request()->routeIs('acessibility.index') ? 'active' : '' }}">
        <a href="{{ route('acessibility.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <span>Acessibilidade</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('lai.index') ? 'active' : '' }}">
        <a href="{{ route('lai.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <span>Lai</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('recipes.index') ? 'active' : '' }}">
        <a href="{{ route('recipes.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <span>Receitas</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
        <a href="{{ route('expenses.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <span>Gastos</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('board.page') ? 'active' : '' }}">
        <a href="{{ route('board.page') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>
            <span>Mesa Diretora</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('chambers-financials.index') ? 'active' : '' }}">
        <a href="{{ route('chambers-financials.index') }}" class="menu-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smile"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            <span>Balancetes Financeiros</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('pages.index') || request()->routeIs('links.index') || request()->routeIs('menus.index') || request()->routeIs('settings.index') ? 'active' : '' }}">
        <button class="menu-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
            </svg>
            <span>Configurações</span>
        </button>

        <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
            <ul class="sub-menu">
                <li class="sub-item {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}" class="sub-link">Sistema</a>
                </li>
                <li class="sub-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="sub-link">Usuários</a>
                </li>
                <li class="sub-item {{ request()->routeIs('pages.index') ? 'active' : '' }}">
                    <a href="{{ route('pages.index') }}" class="sub-link">Páginas</a>
                </li>
                <li class="sub-item {{ request()->routeIs('links.index') ? 'active' : '' }}">
                    <a href="{{ route('links.index') }}" class="sub-link">Links</a>
                </li>
                <li class="sub-item {{ request()->routeIs('menus.index') ? 'active' : '' }}">
                    <a href="{{ route('menus.index') }}" class="sub-link">Menus</a>
                </li>
                <li class="sub-item {{ request()->routeIs('favorite.index') ? 'active' : '' }}">
                    <a href="{{ route('favorite.index') }}" class="sub-link">Favoritos</a>
                </li>
                <li class="sub-item {{ request()->routeIs('maintenance.index') ? 'active' : '' }}">
                    <a href="{{ route('maintenance.index') }}" class="sub-link">Manutenções</a>
                </li>
                <li class="sub-item {{ request()->routeIs('login.page') ? 'active' : '' }}">
                    <a href="{{ route('login.page') }}" class="sub-link">Página de Login</a>
                </li>
                <li class="sub-item {{ request()->routeIs('terms-use.create') ? 'active' : '' }}">
                    <a href="{{ route('terms-use.create') }}" class="sub-link">Termos de Uso</a>
                </li>
            </ul>
        </div>
    </li>
</ul>