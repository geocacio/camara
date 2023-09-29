@extends('panel.index')

@section('pageTitle', 'Atualizar Publicação')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><a href="{{ route('biddings.publications.index', $bidding->slug) }}">Publicações</a></li>
<li><span>Atualizar Publicação</span></li>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        @endif

        <form action="{{ route('biddings.publications.update', ['bidding' => $bidding->slug, 'publicationForm' => $publication->slug]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Data da publicação</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $publication->date) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="type" class="form-control">
                            <option value="">Selecione</option>
                            <option value="DIÁRIO OFICIAL DO MUNICÍPIO" {{ $publication->type == 'DIÁRIO OFICIAL DO MUNICÍPIO' ? 'selected' : ''}}>DIÁRIO OFICIAL DO MUNICÍPIO</option>
                            <option value="JORNAL DE GRANDE CIRCULAÇÃO" {{ $publication->type == 'JORNAL DE GRANDE CIRCULAÇÃO' ? 'selected' : ''}}>JORNAL DE GRANDE CIRCULAÇÃO</option>
                            <option value="DIÁRIO OFICIAL DA UNIÃO" {{ $publication->type == 'DIÁRIO OFICIAL DA UNIÃO' ? 'selected' : ''}}>DIÁRIO OFICIAL DA UNIÃO</option>
                            <option value="DIÁRIO OFICIAL DO ESTADO" {{ $publication->type == 'DIÁRIO OFICIAL DO ESTADO' ? 'selected' : ''}}>DIÁRIO OFICIAL DO ESTADO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description', $publication->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection