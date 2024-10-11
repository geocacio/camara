@extends('panel.index')

@section('pageTitle', 'Cadastro de Cartas de Serviços ao Cidadão')
@section('breadcrumb')
{{-- <li><a href="{{ route('serviceCharters.index') }}">Cartas de Serviços</a></li> --}}
<li><span>Cadastro de Cartas de Serviços</span></li>
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

        <form action="{{ route('cartaservicos.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Título</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Horário de Atendimento</label>
                        <input type="text" name="service_hours" class="form-control" value="{{ old('service_hours') }}" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Previsão de Prazo</label>
                        <input type="text" name="service_completion_time" class="form-control" value="{{ old('service_completion_time') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Custo para o Usuário</label>
                        <input type="number" step="0.01" name="user_cost" class="form-control" value="{{ old('user_cost') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Formas de Prestação de Serviço</label>
                        <input type="text" name="service_provision_methods" class="form-control" value="{{ old('service_provision_methods') }}" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descrição do Serviço</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Principais Etapas do Serviço</label>
                        <textarea name="service_steps" class="form-control">{{ old('service_steps') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Requisitos - Documentos Necessários</label>
                        <textarea name="requirements_documents" class="form-control">{{ old('requirements_documents') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Links</label>
                        <input type="text" name="links" class="form-control" value="{{ old('links') }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Categoria</label>
                        @if($categories->isEmpty())
                            <input type="text" name="new_category" class="form-control" placeholder="Crie uma nova categoria" />
                        @else
                            <select name="category_id" class="form-control">
                                <option value="">Selecione a Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Cadastrar Carta de Serviço</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')

@include('panel.scripts')

@endsection
