@extends('panel.index')
@section('pageTitle', 'Fazer chamada')

@section('breadcrumb')
<li><a href="{{ route('sessions.index') }}">Sessões</a></li>
<li><span>Chamada</span></li>
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
        <form action="{{ route('attendances.store', $session->slug) }}" method="post">
            @csrf
            <div class="row">
                
                @if($councilors->count() > 0)
                @foreach($councilors as $councilor)
                <input type="hidden" name="councilors[{{ $loop->index }}][id]" value="{{ $councilor->id }}">
                    <div class="col-md-6">
                        <div class="form-group group-inline-form">
                            @if($councilor->files->count() > 0)
                            <figure class="img-councilor-list">
                                <img src="{{ asset('storage/'.$councilor->files[0]->file->url) }}"/>
                            </figure>
                            @endif

                            <div class="align-center">
                                <h1>{{ $councilor->surname }}</h1>
                                <div class="text-left">
                                    <label class="cursor-pointer" for="toggle-{{$loop->index}}">Ausente/Presente</label>
                                    <div class="toggle-switch">
                                        <input type="checkbox" id="toggle-{{$loop->index}}" name="councilors[{{ $loop->index }}][visibility]" value="" class="toggle-input" {{ $councilor->present ? 'checked' : ''}}>
                                        <label for="toggle-{{$loop->index}}" class="toggle-label"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif

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