@extends('panel.index')
@section('pageTitle', 'Símbolos')

@section('content')
<div class="card">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
    @endif

    <div class="card-body">
        <form action="{{ route('symbols.store') }}" method="post" enctype="multipart/form-data">
            @csrf


            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Ícone</label>
                        <input type="text" name="icon" class="form-control icon" autocomplete="off" value="{{ old('icon') }}" onfocus="getIconInputValues(event)">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título Principal</label>
                        <input type="text" name="main_title" class="form-control" autocomplete="off" value="{{ old('main_title') }}">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" autocomplete="off" value="{{ old('title') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Text</label>
                <input type="text" name="description" class="form-control" autocomplete="off" value="{{ old('description') }}">
            </div>

            <div class="form-group">
                <label>Grupo (onde será exibido no portal da transparência)</label>
                <select name="transparency_group_id" class="form-control">
                    <option value="">Selecione o grupo</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}" 
                            {{ $pageSymbol && $pageSymbol->groupContents && $pageSymbol->groupContents->transparency_group_id && $group->id == $pageSymbol->groupContents->transparency_group_id ? 'selected' : '' }}>
                            {{ $group->title }} - {{ $group->description }}
                        </option>
                    @endforeach
                </select>
            </div>
            

            <div class="form-group">
                <label>Ativado/Desativado</label>
                <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                    <div class="toggle-switch cmt-4">
                        <input type="checkbox" id="checklist" name="visibility" value="enabled" class="toggle-input" 
                            {{ $pageSymbol && $pageSymbol->visibility == 'enabled' ? 'checked' : '' }}>
                        <label for="checklist" class="toggle-label no-margin"></label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Url do Hino (Youtube)</label>
                <input type="text" name="himn_url" class="form-control" value="{{ old('himn_url') }}" />
            </div>

            <div class="form-group">
                <label>Hino</label>
                <textarea name="himn" class="form-control">{{ old('himn') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-input-file">
                            <label for="logo">Brasão</label>
                            <input type="file" name="coat_of_arms" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                            <div class="container-temp-file">
                                <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-input-file">
                            <label for="logo">Bandeira</label>
                            <input type="file" name="flag" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                            <div class="container-temp-file">
                                <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-icon-list" id="modalIconList" tabindex="-1" role="dialog" aria-labelledby="iconListModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="iconListModalTitle">Escolha seu ícone</h5>
                <button type="button" class="close simple-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('panel.partials.iconLists')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection