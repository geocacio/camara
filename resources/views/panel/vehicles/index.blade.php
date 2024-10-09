@extends('panel.index')
@section('pageTitle', 'Veiculos')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('veiculos.create') }}" class="btn-default">Novo</a>
            <a data-toggle="modal" data-target="#modalNoData" class="btn-default">Período sem Veículo</a>
        </div>
                
        <x-modal-no-info modalId="modalNoData" modalTitle="Período sem Veículo" formAction="{{ route('noInformationstore') }}">
            <div class="form-group row">
                <div class="col-6">
                    <label for="logo">Arquivo</label>
                    <input type="file" name="file" accept="application/pdf" class="form-control">
                </div>
        
                <div class="col-6">
                    <label for="logo">Periodo</label>
                    <input type="text" name="periodo" value="{{ old('periodo') }}" placeholder="10/10/2020 - 12/11/2023" class="form-control mask-period">
                    <input type="hidden" value="Veículos" name="page">
                </div>
            </div>
        
            <div class="form-group">
                <label>Descrição</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <x-slot name="list">
                <div class="mt-5 list">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Descrição</th>
                                    <th>Periodo</th>
                                    <th>Periodo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($infos as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ Str::limit($info->description, 10, '...') }}</td>
                                    <td>{{ $info->periodo }}</td>
                                    <td class="">
                                        <a href="{{ route('no-vehicle.edit', $info->id) }}" class="link edit"><i class="fas fa-edit"></i></a>
                                        <a style="cursor: pointer; color: #cd4646;" class="link delete" onclick="openPopup({{ $info->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        
                                        <!-- Popup -->
                                        <div class="popup" id="popup-{{ $info->id }}" style="display: none;">
                                            <div class="popup-content">
                                                <span class="popup-icon">&#9432;</span>
                                                <span class="popup-message">Você realmente quer apagar este item?</span>
                                                <div class="popup-footer">
                                                    <button class="btn cancel" onclick="closePopup({{ $info->id }})">Cancelar</button>
                                                    <a class="btn delete" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $info->id }}').submit();">Deletar</a>
                                                </div>

                                                <form id="delete-form-{{ $info->id }}" action="{{ route('info.destroy', $info->id) }}" method="post" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot>
        </x-modal-no-info>
        
        @if($vehicles && $vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Placa</th>
                            <th>Situação</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->brand }}</td>
                            <td>{{ $vehicle->plate }}</td>
                            <td>{{ $vehicle->situation }}</td>
                            {{-- <td>{{ $vehicle->roles[0]->name }}</td> --}}
                            <td class="actions">
                                <a href="{{ route('veiculos.edit', $vehicle->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                                <a data-toggle="modal" data-target="#myModal{{$vehicle->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                                <div id="myModal{{$vehicle->id}}" class="modal fade modal-warning" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <span class="icon" data-v-988dbcee=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon" data-v-988dbcee="">
                                                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" data-v-988dbcee=""></polygon>
                                                        <line x1="12" y1="8" x2="12" y2="12" data-v-988dbcee=""></line>
                                                        <line x1="12" y1="16" x2="12.01" y2="16" data-v-988dbcee=""></line>
                                                    </svg></span>
                                                <span class="title">Você tem certeza?</span>
                                                <span class="message">Você realmente quer apagar este item?<br> Esta ação não poderá ser desfeita.</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancelar</button>
                                                <a href="#" class="btn btn-default" onclick="event.preventDefault();
                                                    document.getElementById('delete-form-{{ $vehicle->id }}').submit();">
                                                    Deletar
                                                </a>

                                                <form id="delete-form-{{ $vehicle->id }}" action="{{ route('veiculos.destroy', $vehicle->slug) }}" method="post" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <span>Ainda não existem veículos cadastrados.</span>
            </div> 
        @endif

    </div>
</div>
@endsection

@section('js')
<script>
function openPopup(id) {
    // Exibe o popup correspondente ao ID
    document.getElementById('popup-' + id).style.display = 'block';
}

function closePopup(id) {
    // Oculta o popup correspondente ao ID
    document.getElementById('popup-' + id).style.display = 'none';
}

</script>
@endsection