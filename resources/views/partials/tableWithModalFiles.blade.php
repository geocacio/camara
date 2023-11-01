<div class="col-12">
    @if($data && $data->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-data-default">
                <thead>
                    <tr>
                        @foreach($data->first()->getAttributes() as $key => $values)
                        <th>{{ $key == 'exercicy_id' ? 'Exercício' : ($key == 'id' ? 'Número' : $key) }}</th>
                        @endforeach
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($data as $key => $items)
                    <tr>
                        @foreach($items->getAttributes() as $key => $item)
                            @if(strtotime($item) !== false && preg_match('/^\d+\.\d+$/', $item) !== 1)
                                <td>{{ date('d/m/Y', strtotime($item)) }}</td>
                            @elseif($key == 'exercicy_id')
                                <td>{{ $items->exercicy->name }}</td>
                            @else
                                <td>{{ $item }}</td>
                            @endif
                        @endforeach
                        <td class="actions">
                            <a href="#" data-toggle="modal" data-target="#showProccess-{{ $items->id }}" class="link-view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- modal -->
                    <div class="modal fade modal-show-info-data" id="showProccess-{{ $items->id }}" tabindex="-1" role="dialog" aria-labelledby="showProccess-{{ $items->id }}Title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">  
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $item }}</h5>
                                </div>
                                <div class="modal-body">
                                    <h3 class="subtitle-default">Lista de arquivos</h3>
                                    <div class="container-files">
                                        @foreach($items->files as $file)
                                        <a href="{{ asset('storage/'.$file->file->url) }}" target="_blank" class="link"><i class="fa-solid fa-file-pdf"></i> {{ $file->file->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end modal -->

                    @endforeach

                </tbody>
            </table>
        </div>
    
        {{ $data->render() }}
        
    @else
        <div class="empty-data">Nenhuma informação encontrada.</div>
    @endif
</div>