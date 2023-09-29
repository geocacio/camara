@extends('panel.index')
@section('pageTitle', $menu->name)


@section('breadcrumb')
<li><a href="{{ route('menus.index') }}">Menu</a></li>
<li><span>{{ $menu->name }}</span></li>
@endsection

@section('content')

@if($menu)
<div class="row margin-bottom-cols">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="button-and-text">
                    <span class="title">Links do {{ $menu->name }}</span>
                    <a href="{{ route('menus.create.link', $menu->slug) }}" class="btn-default">Novo</a>
                </div>
            </div>
            <div class="card-body {{ $menu->links->count() <= 0 ? 'no-padding' : ''}}">
                @if($menu->links->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Tipo</th>
                                <th>url</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menu->links as $link)
                            <tr>
                                <td>{{ $link->id }}</td>
                                <td>{{ $link->name }}</td>
                                <td>{{ !$link->target ? ($link->url ? 'Link externo' : 'Dropdown Menu') :  $link->target->name}}</td>
                                <td>
                                    @if($link->url)
                                    <a href="{{$link->url}}" target="_blank" class="link edit" title="Ir para {{ $link->name }}">{{ $link->url }}</a>
                                    @else
                                    {{ $link->slug }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center w-fit-content actions">
                                        <div class="toggle-switch cmt-4">
                                            <input type="checkbox" id="toggle-{{$link->id}}" onclick="toggleVisibility(event, '{{ $link->id }}')" name="status" value="{{ $link->status }}" class="toggle-input" {{ $link->status === 'enabled' ? 'checked' : '' }}>
                                            <label for="toggle-{{$link->id}}" class="toggle-label no-margin"></label>
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
                    <span>Ainda não existem links para este menu</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">Não existem menus cadastrados!</div>
</div>
@endif
@endsection