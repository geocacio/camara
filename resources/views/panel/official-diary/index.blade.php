@extends('panel.index')
@section('pageTitle', 'Diários oficiais')

@section('content')
<div class="card">
    <div class="card-body">

        <div class="card-header text-right">
            <div class="btn-group dropleft">
                <button type="button" class="btn-dropdown-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-menu">
                    {{-- <a class="dropdown-item" href="{{ route('publications.create', $official_diary->id) }}">Novo</a> --}}
                    <a class="dropdown-item" href="#upload">Enviar PDF pronto</a>
                </div>
            </div>
        </div>

        @if($diaries && $diaries->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Publicado</th>
                        <th>PDF</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diaries as $diary)
                    <tr>
                        <td>{{ $diary->id }}</td>
                        <td>{{ $diary->created_at }}</td>
                        <td>
                            @if($diary->files->count() > 0)
                            <a href="{{ asset('storage/'.$diary->files[0]->file->url) }}" target="_blank">{{ $diary->files[0]->file->name }}</a>
                            @endif
                        </td>
                        <td>
                            @if ($officialJournal->id == $diary->id && $currentDate == $diary->created_at->toDateString())
                            {{ ucfirst( $currentTime >= $timeLimit ? ucfirst($diary->status) : 'Em andamento') }}
                            @else
                            {{ ucfirst($diary->status) }}
                            @endif
                        </td>
                        <td class="actions text-right">
                            @if($currentDate == $diary->created_at->toDateString() && $currentTime < $timeLimit) <a href="{{ route('publications.index', $diary->id) }}" class="link edit"><i class="fas fa-edit"></i></a>
                                @endif
                                <a data-toggle="modal" data-target="#myModal{{$diary->id}}" class="link delete"><i class="fas fa-trash-alt"></i></a>

                                <div id="myModal{{$diary->id}}" class="modal fade modal-warning" role="dialog">
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
                                                document.getElementById('delete-form-{{ $diary->id }}').submit();">
                                                    Deletar
                                                </a>

                                                <form id="delete-form-{{ $diary->id }}" action="{{ route('official-diary.destroy', $diary->id) }}" method="post" style="display: none;">
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
            <span>Ainda não existem Diários cadastrados.</span>
        </div>
        @endif
        <div class="modal fade" id="uploadPdfModal" tabindex="-1" role="dialog" aria-labelledby="uploadPdfModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="uploadPdfModalLabel">Enviar PDF</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ route('testes.swas') }}" method="post" id="uploadPdfForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required/>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="title1">Selecione a categoria</label>
    
                                <select required name="summary_id" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach($summaries->children as $summary)
                                    <option value="{{ $summary->id}}">{{ $summary->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label>Data de publicação</label>
                                <input type="date" id="datePicker" name="publication_date" class="form-control" value="{{ old('publication_date') }}" required/>
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="pdfFile">Escolha o arquivo PDF</label>
                        <input type="file" name="exportedDiary" class="form-control-file" id="pdfFile" accept="application/pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<link rel="stylesheet" href="/path/to/bootstrap.min.css">
<script src="/path/to/jquery.min.js"></script>
<script src="/path/to/bootstrap.bundle.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('a[href="#upload"]').addEventListener('click', function(event) {
            event.preventDefault();
            $('#uploadPdfModal').modal('show');
        });
        document.getElementById('datePicker').valueAsDate = new Date();
    });


</script>
@endsection