@extends('panel.index')
@section('pageTitle', 'Veiculos')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('veiculos.create') }}" class="btn-default">Novo</a>
            <a href="{{ route('no-vehicle.create') }}" class="btn-default">Não há veiculos</a>
        </div>

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
@endsection