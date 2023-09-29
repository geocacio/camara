@extends('panel.index')
@section('pageTitle', $menu->name)

@section('breadcrumb')
<li><a href="{{ route('menus.index') }}">Menu</a></li>
<li><span>{{ $menu->name }}</span></li>
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
@if($menu)
<div class="row margin-bottom-cols">

    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="button-and-text">
                    <span class="title">Links</span>
                    <a href="{{ route('links.create') }}" class="btn-default">Novo</a>
                </div>
            </div>
            <div class="card-body no-horizontal">
                <div class="drag-and-drop custom-drag-and-drop">
                    <div class="card">
                        @if($links->count() > 0)
                        @foreach($links as $link)
                        <div class="dad-item justify-content-between" data-id="{{ $link->id }}">
                            <div class="d-flex align-items-center gap-20">
                                @if($link->name)
                                <p>{{ $link->name }}</p>
                                @else
                                <p><i class="{{ $link->icon }}"></i></p>
                                @endif
                            </div>
                            <a href="{{ route('links.edit', $link->slug) }}" class="btn-edit"><i class="fas fa-edit"></i></a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <div class="button-and-text">
                    <span class="title">{{ $menu->name }}</span>
                    <button type="button" onclick="updateMenu('/panel/configurations/menus/{{$menu->slug}}')" class="btn-default">Atualizar</button>
                </div>
            </div>
            <div class="card-body no-horizontal">
                <div class="drag-and-drop custom-drag-and-drop current-menu">
                    <div class="card">
                        @if($menu->links->count() > 0)
                        @foreach($menu->links as $link)
                        <div class="dad-item justify-content-between" data-id="{{ $link->id }}">
                            <div class="d-flex align-items-center gap-20">
                                @if($link->name)
                                <p>{{ $link->name }}</p>
                                @else
                                <p><i class="{{ $link->icon }}"></i></p>
                                @endif
                            </div>
                            <a href="{{ route('links.edit', $link->slug) }}" class="btn-edit"><i class="fas fa-edit"></i></a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">Não existem menus cadastrados!</div>
</div>
@endif
@endsection

@section('js')
<script>
    function updateMenu(url) {
        const links = document.querySelectorAll('.current-menu .card .dad-item');
        console.log(links)
        let positions = [];
        links.forEach((link, index) => {
            positions.push({
                link_id: link.dataset.id,
                position: index + 1
            });
        });

        let requestData = {
            positions: positions
        };

        const csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        axios.post(url, requestData, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf_token,
                    "Content-Type": "multipart/form-data",
                    'Accept': 'application/json'
                },
                params: {
                    _method: 'PUT'
                }
            }).then(response => {
                localStorage.setItem('successMessage', response.data.success);
                location.reload();
                // Após a atualização da página
                if (localStorage.getItem('successMessage')) {
                    localStorage.removeItem('successMessage');
                }
            })
            .catch(error => console.log(error));
    }
</script>
@endsection