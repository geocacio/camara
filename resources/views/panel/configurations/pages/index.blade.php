@extends('panel.index')
@section('pageTitle', 'Páginas')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-body">

        @if($pages)
        <div class="accordion accordion-flush with-link panel-accordion" id="accordionPage">
            @foreach($pages as $page)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#page-{{$page->id}}" aria-expanded="false" aria-controls="page-{{$page->id}}">
                        <span>{{ $page->name }}</span>
                    </button>
                    <a href="{{ route('pages.show', $page->slug) }}" class="link-icon white" title="Alterar posição das seções"><i class="icon fas fa-arrows-alt"></i></a>
                </h2>
                <div id="page-{{$page->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionPage">
                    <div class="accordion-body">
                        @if($page->sections)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Seção</th>
                                        <th class="text-center">Ativado/Desativado</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page->sections as $section)
                                    <tr>
                                        <td>
                                            <button type="button" class="button-no-style text-hover" data-toggle="modal" data-target="#form-section{{ $section->id}}">
                                                {{ $section->name }}
                                            </button>

                                            <div class="modal fade" id="form-section{{ $section->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-center w-100">{{ $section->name }}</h5>
                                                            <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('sections.update', $section->slug) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="labelsectionname">Nome</label>
                                                                    <input type="text" name="name" id="labelsectionname" class="form-control" value="{{ old('name', $section->name) }}">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success">Salvar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="toggle-switch">
                                                <input type="checkbox" id="toggle-{{$section->id}}" onclick="toggleVisibility(event, '{{ $section->id }}', '/panel/configurations/pages/sections/visibility')" name="visibility" value="{{ $section->visibility }}" class="toggle-input" {{ $section->visibility === 'enabled' ? 'checked' : '' }}>
                                                <label for="toggle-{{$section->id}}" class="toggle-label"></label>
                                            </div>
                                        </td>
                                        <td class="actions">
                                            <a href="{{ route('sections.show', $section->slug) }}" class="link edit" title="Alterar visual"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info">Não existem nenhuma seção para esta página.</div>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @else
        <div class="alert alert-info">Não existem páginas.</div>
        @endif

    </div>
</div>

@endsection

@section('js')

@include('panel.configurations.pages.visibilityJS')

@endsection