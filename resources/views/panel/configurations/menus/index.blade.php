@extends('panel.index')
@section('pageTitle', 'Menus')

@section('content')

@if($menus)
<div class="row margin-bottom-cols">
    @foreach($menus as $menu)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="button-and-text">
                    <span class="title">Links do {{ $menu->name }}</span>
                    <a href="{{ route('menus.show', $menu->slug) }}" class="btn-default">{{ $menu->links->count() > 0 ? 'Editar' : 'Criar'}}</a>
                </div>
            </div>
            <div class="card-body {{ $menu->links->count() <= 0 ? 'no-padding' : ''}}">
                @if($menu->links->count() > 0)
                <ul class="list-links">
                    @foreach($menu->links as $link)
                    <li>
                        <i class="fa-solid fa-link"></i>
                        @if($link->name)
                        <p>{{ $link->name }}</p>
                        @else
                        <p><i class="{{ $link->icon }}"></i></p>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="no-data">
                    <span>Ainda não existem links para este menu</span>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card">
    <div class="card-body">Não existem menus cadastrados!</div>
</div>
@endif
@endsection