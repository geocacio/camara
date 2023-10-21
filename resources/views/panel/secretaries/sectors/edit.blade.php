@extends('panel.index')

@section('pageTitle', 'Atualizar Setor')
@section('breadcrumb')
<li><a href="{{ route('sectors.index') }}">Setores</a></li>
<li><span>Atualizar Setor</span></li>
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

        <form action="{{ route('sectors.update', $sector->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $sector->name) }}" />
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email', $sector->email) }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone', $sector->phone) }}" />
                    </div>
                </div>
            </div>  

            {{-- <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description', $sector->description) }}</textarea>
            </div> --}}

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