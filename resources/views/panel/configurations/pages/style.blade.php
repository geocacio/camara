@extends('panel.index')
@section('pageTitle', 'Visual da seção')

@section('breadcrumb')
<li><a href="{{ route('pages.index') }}">Pages</a></li>
<li><span>Visual</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <form id="submitServiceStyle" class="form-style" method="post" action="{{ route('section.store') }}">
            {{ csrf_field() }}
            <input type="hidden" name="page_id" value="{{ $section->page_id}}">
            <input type="hidden" name="section_id" value="{{ $section->id}}">
            <div class="form-group">
                <label class="cursor-pointer" for="toggle">Ativar/Desativar</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="toggle" name="visibility" value="{{ $section->visibility }}" class="toggle-input" {{ $section->visibility === 'enabled' ? 'checked' : '' }}>
                    <label for="toggle" class="toggle-label"></label>
                </div>
            </div>
            @if($section->styles->count() > 0)
            @foreach($section->styles as $style)
            <input type="hidden" name="classes[]" value="{{ $style->classes }}" />
            @if(!empty($style->background_color))
            <div class="row">
                <label class="main-label">Fundo</label>
                <div class="col-sm-4 form-group">
                    <label>Cor dia</label>
                    <div class="input-color">
                        <input type="color" name="background_color" value="{{ $section->styles->count() > 0 ? old('background_color', $style->background_color) : old('background_color') }}">
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Cor noite</label>
                    <div class="input-color">
                        <input type="color" name="background_color_night" value="{{ $section->styles->count() > 0 ? old('background_color_night', $style->background_color_night) : old('background_color_night') }}">
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($style->title_size) || !empty($style->title_color))
            <div class="row">
                <label class="main-label">Título</label>
                <div class="col-sm-4 form-group">
                    <label>Tamanho</label>
                    <input type="number" name="title_size" class="form-control" value="{{ $section->styles->count() > 0 ? old('title_size', $style->title_size) : old('title_size') }}">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Cor dia</label>
                    <div class="input-color">
                        <input type="color" name="title_color" value="{{ $section->styles->count() > 0 ? old('title_color', $style->title_color) : old('title_color') }}">
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Cor noite</label>
                    <div class="input-color">
                        <input type="color" name="title_color_night" value="{{ $section->styles->count() > 0 ? old('title_color_night', $style->title_color_night) : old('title_color_night') }}">
                    </div>
                </div>
            </div>
            @endif
            
            @if(!empty($style->subtitle_size) || !empty($style->subtitle_color))
            <div class="row">
                <label class="main-label">Subtítulo</label>

                <div class="col-sm-4 form-group">
                    <label>Tamanho</label>
                    <input type="number" name="subtitle_size" class="form-control" value="{{ $section->styles->count() > 0 ? old('subtitle_size', $style->subtitle_size) : old('subtitle_size') }}">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Cor dia</label>
                    <div class="input-color">
                        <input type="color" name="subtitle_color" value="{{ $section->styles->count() > 0 ? old('subtitle_color', $style->subtitle_color) : old('subtitle_color') }}">
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Cor noite</label>
                    <div class="input-color">
                        <input type="color" name="subtitle_color_night" value="{{ $section->styles->count() > 0 ? old('subtitle_color_night', $style->subtitle_color_night) : old('subtitle_color_night') }}">
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($style->description_size) || !empty($style->description_color))
            <div class="row">
                <label class="main-label">Descrição</label>

                <div class="col-sm-4 form-group">
                    <label>Tamanho</label>
                    <input type="number" name="description_size" class="form-control" value="{{ $section->styles->count() > 0 ? old('description_size', $style->description_size) : old('description_size') }}">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Cor</label>
                    <div class="input-color">
                        <input type="color" name="description_color" value="{{ $section->styles->count() > 0 ? old('description_color', $style->description_color) : old('description_color') }}">
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($style->button_text_size) || !empty($style->button_text_color) || !empty($style->button_background_color))
            <div class="row">
                <label class="main-label">Botão</label>

                <div class="col-sm-4 form-group">
                    <label>Tamanho da label</label>
                    <input type="number" name="button_text_size" class="form-control" value="{{ $section->styles->count() > 0 ? old('button_text_size', $style->button_text_size) : old('button_text_size') }}">
                </div>

                <div class="col-sm-4 form-group">
                    <label>Cor da label</label>
                    <div class="input-color">
                        <input type="color" name="button_text_color" value="{{ $section->styles->count() > 0 ? old('button_text_color', $style->button_text_color) : old('button_text_color') }}">
                    </div>
                </div>

                <div class="col-sm-4 form-group">
                    <label>Cor de fundo dia</label>
                    <div class="input-color">
                        <input type="color" name="button_background_color" value="{{ $section->styles->count() > 0 ? old('button_background_color', $style->button_background_color) : old('button_background_color') }}">
                    </div>
                </div>
                <div class="col-sm-4 form-group">
                    <label>Cor de fundo noite</label>
                    <div class="input-color">
                        <input type="color" name="button_background_color_night" value="{{ $section->styles->count() > 0 ? old('button_background_color_night', $style->button_background_color_night) : old('button_background_color_night') }}">
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>

        </form>

    </div>
</div>
@endsection