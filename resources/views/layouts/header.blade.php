@if(!empty($menus['menuTopo']) && $menus['menuTopo']->links->count() > 0)
<div class="container-fluid" id="menu-topo">

    <div class="row">
        <ul class="menu-topo">
            @foreach($menus['menuTopo']->links as $link)
            
            @if($link->visibility == 'enabled')
            <li class="menu-item">
                @if(in_array($link->slug, ['contraste', 'aumentar', 'diminuir', 'restaurar']))
                <button type="button" {{ $link->slug == 'contraste' ? 'toggle-mode' : ''}} class="menu-link {{ $link->slug == 'aumentar' ? 'increase-font' : ($link->slug == 'diminuir' ? 'decrease-font' : ($link->slug == 'restaurar' ? 'restore-default-font' : '')) }}">
                    @if($link->icon)
                    <i class="{{ $link->icon }}"></i>
                    @endif
                    @if($link->name)
                    <span class="label">{{ $link->name}}</span>
                    @endif
                </button>
                @else
                <a href="{{ $link->target_type == 'page' ? route($link->route) : $link->url }}" class="menu-link">
                    <i class="{{ $link->icon }}"></i>
                    <span class="label">{{ $link->name}}</span>
                </a>
                @endif
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
@endif

<section class="section-header">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-12">
                <div class="content">
                    <div class="container-logo">
                        @if(is_object($logo) && !is_null($logo) && $logo->url != '')
                        <a href="{{ route('home') }}" class="link-logo">
                            <img class="logo" src="{{ asset('/storage/'.$logo->url) }}">
                        </a>
                        @endif
                    </div>
                    <form method="post" action="{{ route('advanced.search') }}" class="form-search-default form-inline">
                        @csrf
                        <div class="form-group form-search">
                            <input type="text" name="search" value="{{ old('search', isset($data['query']) ? $data['query'] : '') }}" class="form-control" placeholder="Busca avançada">
                            <button type="submit" class="btn btn-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>

                    <ul class="social-networks">
                        <li class="item">
                            <a href="#" class="link"><i class="fa-brands fa-facebook"></i></a>
                        </li>
                        <li class="item">
                            <a href="#" class="link"><i class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li class="item">
                            <a href="#" class="link"><i class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li class="item">
                            <a href="#" class="link"><i class="fa-brands fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($menus['menuPrincipal']) && $menus['menuPrincipal']->links->count() > 0)
<section class="main-header no-padding">
    <nav class="navbar navbar-expand-lg custom-menu main-menu">
        <div class="container">
            <div class="align-right d-block d-lg-none">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    {{-- {{dd($menus['menuPrincipal']->links)}} --}}
                    @foreach($menus['menuPrincipal']->links as $link)
                    
                        @if($link->visibility == 'enabled')
                        
                            @if($link->type == 'dropdown' && $link->group->count() > 0)
                                <li class="nav-item dropdown dropdown-hover">
                                    <a class="nav-link dropdown-toggle" href="{{ $link->url }}" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $link->name }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach($link->group as $sublink)
                                            @if($sublink->visibility == 'enabled')
                                                <li><a class="dropdown-item" href="{{ $sublink->target_type == 'page' ? route($sublink->route) : $sublink->url }}">{{ $sublink->name }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                
                            @elseif($link->type == 'link')
                                
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ $link->target_id ? route($link->target->route) : $link->url }}">
                                        @if($link->icon)
                                            <i class="{{ $link->icon }}"></i>
                                        @endif
                                        @if($link->name)
                                            <span class="label">{{ $link->name }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif

                        @endif

                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</section>
@endif

@hasSection('breadcrumb')
<section class="section-page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">@yield('breadcrumb')</div>
        </div>
    </div>
</section>
@endif


<!-- <section class="smaller-header no-padding" style="background-image: url('{{ asset('/images/header/Background47.png') }}')">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="mh-150 d-flex align-items-center sm-justify-content-center md-justify-content-between">
                    @if(is_object($logo) && !is_null($logo) && $logo->url != '')
                    <a href="{{ route('home') }}" class="link-logo">
                        <img class="logo" src="{{ asset('/storage/'.$logo->url) }}">
                    </a>
                    @endif
                    <ul class="container-menu-header d-none d-md-flex">
                        <li class="item">
                            <a href="#" class="link"><i class="fa fa-bars"></i>Ouvidoria</a>
                        </li>
                        <li class="item">
                            <a href="#" class="link">Ouvidoria</a>
                        </li>
                        <li class="item">
                            <a href="#" class="link">Ouvidoria</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section> -->