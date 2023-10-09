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
            @csrf
            <input type="hidden" name="page_id" value="{{ $section->page_id }}">
            <input type="hidden" name="section_id" value="{{ $section->id }}">
            <div class="form-group">
                <label class="cursor-pointer" for="toggle">Ativar/Desativar</label>
                <div class="toggle-switch">
                    <input type="checkbox" id="toggle" name="visibility" value="{{ $section->visibility }}" class="toggle-input" {{ $section->visibility === 'enabled' ? 'checked' : '' }}>
                    <label for="toggle" class="toggle-label"></label>
                </div>
            </div>

            @foreach($section->styles as $style)
            @php
            $attributes = $style->getAttributes();
            @endphp
            <div class="row">
                <label class="main-label">{{ $style->name }}</label>
                @foreach ($properties as $property)
                    @if (isset($attributes[$property]) && $attributes[$property] !== null)
                    <div class="col-sm-6 form-group">
                        <label>{{ $propertyLabels[$property] }}</label>
                        <div class="input-color">
                            <input type="color" name="class[{{ $style->classes }}][{{ $property }}]" value="{{ $attributes[$property] }}">
                        </div>
                    </div>
                    <div class="col-sm-6 form-group">
    <label>{{ $propertyLabels[$property] }} (Modo noite)</label>
    <div class="input-color">
        <input type="color" name="class[{{ $style->classes }}][{{ $property }}_night]" value="{{ $attributes[$property.'_night'] }}">
    </div>
</div>

                    @endif
                @endforeach
            </div>
            @endforeach

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>



    </div>
</div>
@endsection