@extends('panel.index')
@section('pageTitle', 'Página de Normativas')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        <li>{{ $errors->first() }}</li>
    </ul>
</div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('normative.store') }}" method="post" id="normativeForm" enctype="multipart/form-data">
            @csrf
            <div id="container">
                <div class="form-normative">
                    <div class="form-group">
                        <label for="logo">Arquivo Existente</label>
                        @if (!empty($file))
                        <td>{{ Illuminate\Support\Str::limit($file->description, $limit = 50, $end = '...') }}</td>
                        @else
                            <p>Nenhum arquivo existente</p>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="logo">Atualizar Arquivo</label>
                        <input type="file" name="file" accept="application/pdf" class="form-control">
                    </div>

                    <div class="form-group">
                        {{-- <label for="logo">Título</label>
                        <input type="text" name="name" value="{{ isset($file) ? old('name', $file->name) : old('name') }}" class="form-control"> --}}
                        @if(isset($file->id))
                        <input type="hidden" name="id" value="{{ isset($file) ? old('id', $file->id) : old('id') }}" class="form-control">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Descrição da lei</label>
                        <textarea name="description" class="form-control">{{ isset($file) ? old('description', $file->description) : old('description') }}</textarea>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('js')

@include('panel.scripts')
@endsection
