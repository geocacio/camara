@extends('panel.index')
@section('pageTitle', 'Atualizar Banner')

@section('breadcrumb')
<li><a href="{{ route('banners.index') }}">Banners</a></li>
<li><span>Atualizar</span></li>
@endsection

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
        <form action="{{ route('banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="type_id">Tipo</label>
                <select id="select_type" name="type" class="form-control">
                    <option value="link">Link</option>
                    <option value="simples">Apenas a imagem</option>
                </select>
            </div>

            <div class="form-group form-group-links">
                <label for="type_id">Link</label>
                <select id="select_links" name="link_id" class="form-control search-select">
                    @foreach($links as $link)
                    <option value="{{ $link->id }}">{{ $link['name'] ? $link['name'] : $link['icon'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type_id">Cor de fundo?</label>
                        <select id="with_color" name="with_color" class="form-control">
                            <option value="sim">Sim</option>
                            <option value="nao">Não</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-background-color">
                    <div class="form-group">
                        <label>Cor de fundo</label>
                        <div class="input-color">
                            <input type="color" name="color" value="transparent">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-input-file">
                    <label for="logo">Imagem</label>
                    <input type="file" name="image" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                    <div class="container-temp-file">
                        @if($banner->files->count() > 0)
                        <img class="image" src="{{ asset('storage/'.$banner->files[0]->file->url) }}" />
                        <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$banner->files[0]->file->id}}')">
                            <svg viewBox="0 0 24 24" style="fill: white; width: 20px; height: 20px;">
                                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" style="stroke-width: 4px;"></path>
                            </svg>
                        </button>
                        @endif
                        <button type="button" class="btn btn-toggle-file" onclick="toggleFile(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </button>
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

<script>
    const type = document.querySelector('#select_type');
    const fromGroupLinks = document.querySelector('.form-group-links');
    type.addEventListener('change', e => e.target.value == 'simples' ? fromGroupLinks.style.display = 'none' : fromGroupLinks.style.display = 'block');

    const withColor = document.querySelector('#with_color');
    const colBG = document.querySelector('.col-background-color');
    withColor.addEventListener('change', e => e.target.value == 'nao' ? colBG.style.display = 'none' : colBG.style.display = 'block');
</script>

@endsection