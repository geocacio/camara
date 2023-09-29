@extends('panel.index')

@section('pageTitle', 'Novo Responsável')
@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><a href="{{ route('biddings.responsibilities.index', $bidding->slug) }}">Responsabilidades</a></li>
<li><span>Novo Responsável</span></li>
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

        <form action="{{ route('biddings.responsibilities.store', $bidding->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="bidding_id" value="{{$bidding->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione a responsabilidade</label>
                        <select name="responsibility_id" class="form-control">
                            @if($categories)
                            @foreach($categories[0]->children as $category)
                            <option value="{{$category->id}}">{{ $category->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title1">Selecione o responsável</label>
                        <select name="employee_id" class="form-control">
                            @if($employees)
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{ $employee->name}}</option>
                            @endforeach
                            @endif
                        </select>
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