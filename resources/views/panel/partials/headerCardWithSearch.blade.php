@if($withSearch)
    <div class="card-header text-right header-with-search">
@else
    <div class="card-header text-right">
@endif
        <form action="{{ route($routerSearch) }}" method="GET" class="form-search form-inline mb-0">
            <input type="hidden" name="perPage" value="{{ old('perPage', $perPage) }}">
            <div class="form-row align-items-center">
                <div class="input-group mb-0">
                    <input type="text" placeholder="Pesquisar" class="form-control" name="search" value="{{ old('search', $search) }}">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    @if ($search)
                    <a href="{{ route($clearRouterSearch['route'], $clearRouterSearch['params']) }}" class="btn btn-clear-search"><i class="fa-solid fa-times"></i></a>
                    @endif
                </div>
            </div>
        </form>

        <a href="{{ route($routerNew) }}" class="btn-default">Novo</a>
    </div>