@extends('panel.index')
@section('pageTitle', 'Arquivos disponíveis')

@section('breadcrumb')
<li><a href="{{ route('biddings.index') }}">Licitações</a></li>
<li><span>Arquivos disponíveis</span></li>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <a href="{{ route('biddings.available.files.create', $bidding->slug) }}" class="btn-default">Novo</a>
        </div>

        @if($availableFiles && $availableFiles->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome do arquivo</th>
                        <th>Arquivo</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($availableFiles as $file)
                    <tr>
                        <td>{{ $file->id }}</td>
                        <td>{{ $file->file->name }}</td>
                        <td><a href="#" class="btn btn-link" data-toggle="modal" data-target="#showModal-{{ $file->file->id }}">{{ pathinfo($file->file->url, PATHINFO_FILENAME) }}</a></td>
                        <td class="actions text-right">
                            <a href="{{ route('biddings.available.files.edit', ['id' => $file->file->id, 'bidding' => $bidding->slug]) }}" class="link edit"><i class="fas fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#myModal{{$file->file->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                            <div id="myModal{{$file->file->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $file->id }}').submit();">
                                                Deletar
                                            </a>



                                            <form id="delete-form-{{ $file->id }}" action="{{ route('biddings.available.files.destroy', ['id' => $file->id, 'bidding' => $bidding->slug]) }}" method="post" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>                    

                    <div class="modal fade modal-preview-file" id="showModal-{{ $file->file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (pathinfo($file->file->url, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset('storage/'.$file->file->url) }}" width="100%" height="500px" type="application/pdf">
                                    @elseif (in_array(pathinfo($file->file->url, PATHINFO_EXTENSION), ['doc', 'docx']))
                                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode(asset('storage/' .$file->file->url)) }}" width="100%" height="500px"></iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="no-data">
            <span>Ainda não existem arquivos cadastrados.</span>
        </div>
        @endif

    </div>
</div>
@endsection

@section('js')
@endsection