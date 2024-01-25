@extends('panel.index')
@section('pageTitle', 'Atalhos da Transparência na home')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-header text-right header-with-search">
            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>

        @if($pages && $pages->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Página</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $index => $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>{{ $page->name }}</td>
                        <td class="actions text-center">
                            @if($page->favs->count() > 0)
                                <a href="#" title="Remover dos destaques" class="link destaque" onclick="event.preventDefault();
                                    document.getElementById('destaque-{{ $page->id }}').submit();">
                                    <i class="fa-solid fa-star"></i>
                                </a>
                            @else
                                <a title="Adicionar do destaque" href="#" class="link destaque" onclick="event.preventDefault();
                                    document.getElementById('destaque-{{ $page->id }}').submit();">
                                    <i class="fa-regular fa-star"></i>
                                </a>
                            @endif
                            <form id="destaque-{{ $page->id }}" action="{{ route('favorite.store') }}" method="post" style="display: none;">
                                @csrf
                                <input name="page_id" type="hidden" value="{{ $page->id }}"/>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>Ainda não existem leis cadastradas.</span>
        </div>
        @endif

    </div>
    
    {{-- @include('panel.partials.footerCardWithPagination', ['routePerPage' => 'pages.index', 'paginate' => $pages]) --}}
    
</div>
@endsection

@section('js')
@endsection