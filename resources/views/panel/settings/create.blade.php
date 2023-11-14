@extends('panel.index')

@section('pageTitle', 'Configurações do Sistema')

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

        <form action="{{ route('settings.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome do sistema</label>
                        <input type="text" name="system_name" class="form-control" value="{{ old('system_name') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Plenário</label>
                        <input type="text" name="plenary" class="form-control" value="{{ old('plenary') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control mask-phone" value="{{ old('phone') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" name="cnpj" class="form-control mask-cnpj" value="{{ old('cnpj') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="text" name="cep" class="form-control mask-cep" value="{{ old('cep') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood') }}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Horário de funcionamento</label>
                    <input type="text" name="opening_hours" class="form-control" value="{{ old('opening_hours') }}" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-input-file">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-input-file">
                            <label for="logo">Logo do rodapé</label>
                            <input type="file" name="logo_footer" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="custom-input-file">
                            <label for="logo">Imagem da guia</label>
                            <input type="file" name="favicon" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
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
@endsection

@section('js')

@include('panel.scripts')

@endsection