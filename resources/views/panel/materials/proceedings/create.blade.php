@extends('panel.index')
@section('pageTitle', 'Novo expediente')

@section('breadcrumb')
    <li><a href="{{ route('material-proceedings.index', $material->slug) }}">Expedientes</a></li>
    <li><span>Novo</span></li>
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
            <form action="{{ route('material-proceedings.store', $material->slug) }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="session_id">Sessão</label>
                            <select name="session_id" class="form-control" onchange="carregarExpedientes(this)">
                                <option value="">Selecione</option>
                                @if ($sessions->count() > 0)
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->id }}"
                                            data-expediente="{{ json_encode($session->proceedings) }}">
                                            {{ $session->date }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="expediente-container" style="display: none;">
                        <div class="form-group">
                            <label for="proceeding_id">Expediente</label>
                            <select id="lista-expediente" name="proceeding_id" class="form-control"></select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Fase</label>
                    <select name="phase" class="form-control">
                        <option value="">Selecione</option>
                        <option value="leitura">Leitura</option>
                        <option value="votacao">Votação</option>
                    </select>
                    {{-- <input type="text" name="phase" class="form-control" value="{{ old('phase') }}" /> --}}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observações</label>
                            <textarea name="observations" class="form-control">{{ old('observations') }}</textarea>
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
        function carregarExpedientes(select) {
            var expedienteContainer = document.getElementById('expediente-container');
            document.getElementById('lista-expediente').innerHTML = '';

            var expedientes = JSON.parse(select.options[select.selectedIndex].getAttribute('data-expediente'));
            console.log(expedientes)

            if (expedientes && expedientes.length > 0) {
                expedienteContainer.style.display = ''; 
                expedientes.forEach(function(expediente) {
                    var novoExpediente = criarElementoExpediente(expediente);
                    document.getElementById('lista-expediente').appendChild(novoExpediente);
                });
            }else{
                expedienteContainer.style.display = 'none'; 
            }
        }

        function criarElementoExpediente(expediente) {
            var novoElemento = document.createElement('option');
            novoElemento.value = expediente.id;
            novoElemento.text = expediente.category.name;

            return novoElemento;
        }

        // function carregarExpedientes(select) {
        //     document.getElementById('lista-expediente').innerHTML = '';

        //     var expedientes = JSON.parse(select.options[select.selectedIndex].getAttribute('data-expediente'));
        //     console.log(expedientes)

        //     if(expedientes && expedientes.length > 0){
        //         expedientes.forEach(function(expediente) {
        //             console.log(expediente.category.name)
        //             var novoExpediente = criarElementoExpediente(expediente);
        //             document.getElementById('lista-expediente').appendChild(novoExpediente);
        //         });
        //     }
        // }

        // function criarElementoExpediente(expediente) {
        //     var novoElemento = document.createElement('div');
        //     novoElemento.innerHTML = `
    //     <div class="">
    //         <label>${expediente.category.name}</label>
    //         <div class="d-flex align-items-center justify-content-center w-fit-content actions">
    //             <div class="toggle-switch cmt-4">
    //                 <input type="checkbox" id="${expediente.id}" name="expediente[${expediente.id}]" value="${expediente.id}" class="toggle-input">
    //                 <label for="${expediente.id}" class="toggle-label no-margin"></label>
    //             </div>
    //         </div>
    //     </div>
    // `;
        //     return novoElemento;
        // }
    </script>

@endsection
