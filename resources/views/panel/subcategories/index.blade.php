@extends('panel.index')
@section('pageTitle', $category->name)
@section('content')

<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('subcategories.create', $category->slug) }}" class="btn-default">Novo</a>
        </div>

        @if($categories && $categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $subCategories)
                    <tr>
                        <td>{{ $subCategories->id }}</td>
                        <td>{{ $subCategories->name }}</td>
                        <td class="actions">
                            <a href="{{ route('categories.edit', $subCategories->slug) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$subCategories->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>
                            @if($category->slug == 'posts')
                                @if(!$subCategories->fav)
                                    <a href="#" title="Adicionar ao destaque" class="link destaque" onclick="event.preventDefault();
                                        document.getElementById('destaque-{{ $subCategories->id }}').submit();">
                                        <i class="fa-regular fa-star"></i>
                                    </a>
                                @else
                                    <a title="remover do destaque" href="#" class="link destaque" onclick="event.preventDefault();
                                        document.getElementById('destaque-{{ $subCategories->id }}').submit();">
                                        <i class="fa-solid fa-star"></i>
                                    </a>
                                @endif
                                <form id="destaque-{{ $subCategories->id }}" action="{{ route('subcategories.highlighted') }}" method="post" style="display: none;">
                                    @csrf
                                    <input name="category_id" type="hidden" value="{{ $subCategories->id }}"/>
                                </form>
                            @endif

                            <div id="myModal{{$subCategories->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $subCategories->id }}').submit();">
                                                Deletar
                                            </a>

                                            <form id="delete-form-{{ $subCategories->id }}" action="{{ route('categories.destroy', $subCategories->slug) }}" method="post" style="display: none;">
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
            @php
                $arrayName = ['Posts', 'Vídeos'];
            @endphp
            <span>Ainda não existem {{in_array($category->name, $arrayName) ? 'Categorias' : $category->name}}.</span>
        </div>
        @endif

    </div>
</div>
@endsection

<style>
    .destaque {
        border: none;
        width: 22px;
        height: 22px;
        background-color: transparent;
        border-radius: 5px;
    }

    .destaque:hover {
        background-color: #2c373d;
        color: #fff;
    }
</style>

@section('js')
@endsection