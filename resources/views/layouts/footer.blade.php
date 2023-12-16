@if($showMap && $showMap->visibility == 'enabled')
    @include('partials.mapsSection')
@endif

@if($alert)
    @include('partials.maintenance')
@endif

<footer class="footer">
    <div class="container">
        @if(!empty($logo_footer))
        <div class="row mb-3">
            <div class="col-12 text-center">
                <img src="{{ asset('storage/'.$logo_footer) }}" class="footer-logo">
            </div>
        </div>
        @endif
        @if(!empty($menus['menuRodape']) && $menus['menuRodape']->links->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="footer-menu">
                    @foreach($menus['menuRodape']->links as $link)
                    @if($link->visibility == 'enabled')
                    <a href="#" class="btn-site">
                        @if($link->icon)
                        <i class="{{ $link->icon }}"></i>
                        @endif
                        @if($link->name)
                        <span>{{ $link->name }}</span>
                        @endif
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="row row-gap-15 pb-3">
            <div class="col-md-4">
                <div class="container-list">
                    <h3 class="title">INSTITUCIONAL</h3>
                    <ul class="list">
                        <li class="item">
                            <i class="fa fa-user"></i>
                            <span>PRESIDENTE: {{ $currentPresident && !empty($currentPresident->name) ? $currentPresident->name : '' }}</span>
                        </li>
                        <li class="item">
                            <i class="fa fa-credit-card"></i>
                            <span>CNPJ: {{ !empty($settings->cnpj) ? $settings->cnpj : '' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container-list">
                    <h3 class="title">CONTATOS</h3>
                    <ul class="list">
                        <li class="item">
                            <a href="tel:{{ !empty($settings->phone) ? $settings->phone : '' }}" class="item-link">
                                <i class="fa fa-phone"></i>
                                <span>{{ !empty($settings->phone) ? $settings->phone : '' }}</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="mailto:{{ !empty($settings->email) ? $settings->email : null }}" class="item-link">
                                <i class="fa fa-envelope"></i>
                                <span>{{ !empty($settings->email) ? $settings->email : null }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container-list">
                    <h3 class="title">ENDEREÇO E HORÁRIO</h3>
                    <ul class="list">
                        <li class="item">
                            <i class="fa fa-map-marker"></i>
                            <span>{{ !empty($settings->address) ? $settings->address : null }}, Nº {{ !empty($settings->number) ? $settings->number : null }} {{ !empty($settings->neighborhood) ? $settings->neighborhood : null }}, CEP: {{ !empty($settings->cep) ? $settings->cep : null }}</span>
                        </li>
                        <li class="item">
                            <i class="fa fa-clock-o"></i>
                            <span>{{ !empty($settings->opening_hours) ? $settings->opening_hours : null }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if(!empty($menus['menuRedeSocial']) && $menus['menuRedeSocial']->links->count() > 0)
    <section class="social-media">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="menu-social-media">
                        @foreach($menus['menuRedeSocial']->links as $link)
                        @if($link->icon && $link->visibility == 'enabled')
                        <li class="item">
                            <a href="{{ $link->url }}" class="link">
                                <i class="{{ $link->icon }}"></i>
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif
</footer>