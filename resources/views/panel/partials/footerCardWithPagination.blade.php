<div class="card-footer bg-white no-margin-top">
    <div class="pagination-container">
        <div class="form-group mb-0 per-page-container">
            <form action="{{ route($routePerPage) }}" method="GET" class="form-inline mb-0">

                <input type="hidden" name="search" value="{{ $search }}">
                <label for="qtd-per-page">Items por página</label>
                <select class="form-control qtd-per-page" id="qtd-per-page" name="perPage" onchange="this.form.submit()">
                    <option value="10" selected>10</option>
                    <option value="1" {{ $perPage == 1 ? 'selected' : ''  }}>1</option>
                    <option value="2" {{ $perPage == 2 ? 'selected' : ''  }}>2</option>
                    <option value="3" {{ $perPage == 3 ? 'selected' : ''  }}>3</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : ''  }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : ''  }}>100</option>
                    <option value="150" {{ $perPage == 150 ? 'selected' : ''  }}>150</option>
                    <option value="200" {{ $perPage == 200 ? 'selected' : ''  }}>200</option>
                </select>
            </form>
        </div>

        {{ $paginate->render() }}

    </div>
</div>