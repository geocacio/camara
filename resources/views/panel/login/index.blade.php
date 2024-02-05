@extends('panel.index')

@section('pageTitle', 'Configurações do login')

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

        <form action="{{ route('login.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estilo do fundo</label>
                        <select name="style_background" class="form-control" onchange="toggleBackgroundFields(this.value)">
                            <option value="">Selecione o estilo do background</option>
                            <option value="solid" @if($login->style_background == 'solid') selected @endif>Cor sólida</option>
                            <option value="image" @if($login->style_background == 'image') selected @endif>Imagem</option>
                        </select>
                    </div>                 
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Exibir logo ou "Imagem do usuário"</label>
                        <select name="show_logo" class="form-control" onchange="toggleHeaderModalFields(this.value)">
                            <option value="1" @if($login->show_logo == '1') selected @endif>Exbir logo do sistema</option>
                            <option value="0" @if($login->show_logo == '0') selected @endif>exibir ilustração do usuário</option>
                        </select>
                    </div>                 
                </div>
            </div>
            <div class="row">
                <div class="form-group row">
                    <div class="col-md-5">
                        <div class="form-group" id="colorBackground">
                            <div class="col-md-3">
                                <label>Cor do fundo</label>
                                <input type="color" class="form-control" id="background" name="background" value="{{ old('background', $login->background) }}">
                            </div>
                        </div>
                        <div class="form-group" id="imageBackground" >
                            <div class="custom-input-file">
                                <label for="background">Imagem de fundo</label>
                                <input type="file" name="background" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                <div class="container-temp-file">
                                    @if($login->background != '')
                                    <img class="image" src="{{ asset('storage/'.$login->background) }}" />
                                    <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/files/{{$login->background}}')">
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
                    </div>
                    <div class="col-md-4" id="imgLogo">
                        <div class="form-group">
                            <div class="custom-input-file">
                                <label for="logo">Logo do sistema</label>
                                <input type="file" name="logo" accept="image/*" class="form-control" onchange="showTempFile(event, 'custom-input-file', 'container-temp-file')">
                                <div class="container-temp-file">
                                    @if($login->logo != '')
                                    <img class="image" src="{{ asset('storage/'.$login->logo) }}" />
                                    <button class="btn-delete" onclick="removeFile(event, 'container-temp-file', '/panel/login/{{$login->logo}}')">
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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tipo do form</label>
                        <select name="modal" class="form-control">
                            <option value="1" @if($login->modal == 1) selected @endif>Modal</option>
                            <option value="0" @if($login->modal == 0) selected @endif>Card</option>
                        </select>
                    </div>                    
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Estilo do form</label>
                        <select name="style_modal" class="form-control" onchange="toggleBackgroundModal(this.value)">
                            <option value="solid" @if($login->style_modal == 'solid') selected @endif>Cor Sólida</option>
                            <option value="transparency" @if($login->style_modal == 'transparency') selected @endif>Fundo Transparente</option>
                        </select>
                    </div>                    
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Posição do Form</label>
                        <select name="card_position" class="form-control">
                            <option value="center" @if($login->card_position === 'center') selected @endif>Centro</option>
                            <option value="end" @if($login->card_position === 'end') selected @endif>Direita</option>
                            <option value="start" @if($login->card_position === 'start') selected @endif>Esquerda</option>
                        </select>
                    </div>
                </div>                
                <div class="col-md-3" id="modalSolido">
                    <div class="form-group">
                        <label>Cor do modal</label>
                        <div class="col-md-3">
                            <input type="color" class="form-control" id="card_color" name="card_color" value="{{ old('card_color', $login->card_color) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Cor do botão</label>
                        <div class="col-md-3">
                            <input type="color" class="form-control" id="button_color" name="button_color" value="{{ old('button_color', $login->button_color) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cor do botão quando passar o mouse</label>
                        <div class="col-md-3">
                            <input type="color" class="form-control" id="button_hover" name="button_hover" value="{{ old('button_hover', $login->button_hover) }}">
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

<script>
    // Função para exibir/ocultar os campos com base na seleção
    function toggleBackgroundFields(selectedValue) {
        const colorBackground = document.getElementById('colorBackground');
        const imageBackground = document.getElementById('imageBackground');

        // Oculta ambos os campos
        colorBackground.style.display = 'none';
        imageBackground.style.display = 'none';

        // Exibe o campo correspondente com base na seleção
        if (selectedValue === 'solid') {
            colorBackground.style.display = 'block';
        } else if (selectedValue === 'image') {
            imageBackground.style.display = 'block';
        }
    }

    // Inicializa o estado dos campos com base na seleção inicial
    toggleBackgroundFields("{{ $login->style_background }}");


    // Função para exibir/ocultar os campos com base na seleção do estilo do modal
    function toggleBackgroundModal(selectedValue) {
        const modalSolido = document.getElementById('modalSolido');

        // Oculta ambos os campos
        modalSolido.style.display = 'none';

        // Exibe o campo correspondente com base na seleção
        if (selectedValue === 'solid') {
            modalSolido.style.display = 'block';
        }else {
            modalSolido.style.display = 'none';
        }
    }

    // Inicializa o estado dos campos com base na seleção inicial
    toggleBackgroundModal("{{ $login->style_modal }}");

    // Função para exibir/ocultar os campos com base na seleção do estilo do modal
    function toggleHeaderModalFields(selectedValue) {
        const imgLogo = document.getElementById('imgLogo');

        // Oculta ambos os campos
        imgLogo.style.display = 'none';

        // Exibe o campo correspondente com base na seleção
        if (selectedValue === '1') {
            imgLogo.style.display = 'block';
        }else {
            imgLogo.style.display = 'none';
        }
    }

    // Inicializa o estado dos campos com base na seleção inicial
    toggleHeaderModalFields("{{ $login->show_logo }}");
</script>


@include('panel.scripts')

@endsection