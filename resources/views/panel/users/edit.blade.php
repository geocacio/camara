@extends('panel.index')
@section('pageTitle', 'Atualizar Usuário')
@section('breadcrumb')
<li><a href="{{ route('users.index') }}">Usuários</a></li>
<li><span>Atualizar Usuário</span></li>
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

        <form action="{{ route('users.update', $user->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" />
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" />
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Ativado</option>
                    <option value="disabled" {{ $user->status == 'disabled' ? 'selected' : '' }}>Desativado</option>
                </select>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <select name="role_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id}}" {{ $user->roles[0]->id == $role->id ? 'selected' : ''}}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Funcionário</label>
                <select name="employee_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id}}" {{ $user->employee_id == $employee->id ? 'selected' : ''}}>{{ $employee->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}" />
            </div>

            <div class="form-group">
                <label>Confirmar Senha</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" />
            </div>

            <div class="form-footer text-right">
                <button type="submit" class="btn-submit-default">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection