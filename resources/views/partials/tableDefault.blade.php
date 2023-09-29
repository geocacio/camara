<div class="col-12">
    @if($data && $data->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-data-default">
                <thead>
                    <tr>
                        @foreach($data->first()->getAttributes() as $key => $values)
                            @if($key != 'id')
                                <th>{{ $key }}</th>
                            @endif
                        @endforeach
                        @if($actions)
                        <th class="text-center">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach($data as $items)
                    <tr>
                        @foreach($items->getAttributes() as $key =>  $item)
                            @if ($key != 'id')
                                @if (strtotime($item) !== false && preg_match('/^\d+\.\d+$/', $item) !== 1)
                                    <td>{{ date('d/m/Y', strtotime($item)) }}</td>
                                @else
                                    <td>{{ $item }}</td>
                                @endif
                            @endif
                        @endforeach
                        @if($actions)
                        <td class="actions">
                            <a href="{{ route($actions['route'], $items->id) }}" data-toggle="tooltip" title="Ver mais" class="link-view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    
    @else
        <div class="empty-data">Nenhuma informação encontrada.</div>
    @endif
</div>