@extends('panel.index')
@section('pageTitle', 'Links')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('links.create') }}" class="btn-default">Novo</a>
        </div>

        @if($links && $links->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Tipo</th>
                        <th>Url</th>
                        <th class="text-center">Ativado/Desativado</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($links as $link)
                    <tr>
                        <td>{{ $link->id }}</td>
                        <td><i class="{{$link->icon}}"></i> {{ $link->name }}</td>
                        <td>{{ !$link->target ? ($link->url ? 'Link externo' : 'Dropdown Menu') :  $link->target_type}}</td>
                        <td>
                            @if($link->url)
                            <a href="{{$link->url}}" target="_blank" class="link edit" title="Ir para {{ $link->name }}">{{ $link->url }}</a>
                            @elseif($link->name)
                            {{ $link->slug }}
                            @endif
                        </td>
                        <td>
                            <div class="toggle-switch">
                                <input type="checkbox" id="toggle-{{$link->id}}" onclick="toggleVisibility(event, '{{ $link->id }}', '/panel/configurations/links/visibility')" name="visibility" value="{{ $link->visibility }}" class="toggle-input" {{ $link->visibility === 'enabled' ? 'checked' : '' }}>
                                <label for="toggle-{{$link->id}}" class="toggle-label"></label>
                            </div>
                        </td>
                        <td class="actions">
                            <a href="{{ route('links.edit', $link->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            @if(!$link->target_id && !$link->target_type)
                            <a data-toggle="modal" data-target="#myModal{{$link->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$link->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $link->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $link->id }}" action="{{ route('links.destroy', $link->slug) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>Ainda não existem posts cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')

@include('panel.configurations.pages.visibilityJS')

@endsection