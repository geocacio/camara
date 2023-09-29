<div class="col-12">

    @if($data && count($data) > 0)
        
        <div class="table-responsive">
            <table class="table table-striped table-data-default">
                <thead>
                    <tr>
                        @foreach($data[0] as $key => $values)
                        <th>{{ $key }}</th>
                        @endforeach
                        @if($actions)
                        <th class="text-center">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach($data as $items)
                    <tr>
                        @foreach($items as $item)
                            @if (strtotime($item) !== false && preg_match('/^\d+\.\d+$/', $item) !== 1)
                                <td>{{ date('d/m/Y', strtotime($item)) }}</td>
                            @else
                                <td>{{ $item }}</td>
                            @endif
                        @endforeach
                        @if($actions)
                        <td class="actions">
                            <a href="#" data-toggle="tooltip" title="Ver mais" class="link-view">
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