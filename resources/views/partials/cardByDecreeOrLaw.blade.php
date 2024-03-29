
@if($data && $data->count() > 0)
<div class="row" id="law-lrf-content">
    @foreach($data as $item)
    <div class="col-md-12">
        <div class="card-with-links">

            <div class="header">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="second-part">
                <div class="body">
                    <h3 class="title">{{ $item->title }}</h3>
                    @if($type ==  'lrfs')
                        <p class="description">{{ Str::limit($item->details, '75', '...') }}</p>
                    @endif
                    @if($type == 'Lei')
                        <p class="description">{{ Str::limit($item->description, '75', '...') }}</p>
                    @endif
                </div>

                <div class="footer">
                    <span class="d-inline-block" data-toggle="tooltip" title="Ver {{ $type }}">
                        <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $item->id }}"><i class="fa fa-eye"></i></a>
                    </span>
                    @if(!empty($item->files[0]))
                        <a href="{{ asset('storage/'.$item->files[0]->file->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal decree  -->
    <div class="modal fade modal-show-info-data" id="showDecree-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="showDecree-{{ $item->id }}Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $item->title }}</h5>
                </div>
                <div class="modal-body">
                    <div class="view-date">
                        <span>
                            <i class="fa-solid fa-calendar-days"></i> <span>{{ date('d/m/Y', strtotime($item->date)) }}</span>
                        </span>
                    </div>
                    <div class="description">
                        @if($type ==  'lrfs')
                            <p style="word-wrap: break-word;">{{ $item->details }}</p>
                        @endif
                        @if($type == 'Lei')
                            <p style="word-wrap: break-word;">{{ $item->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    @if(!empty($item->files[0]))
                        <a href="{{ asset('storage/'.$item->files[0]->file->url) }}" target="_blank" class="link" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                    @endif
                    <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- endModal decree  -->

    @endforeach

    @if($type != 'lrf')
        <div class="col-12 mt-20">
            {{ $data->render() }}
        </div>
    @endif
</div>
@else
<div class="empty-data">Nenhuma informação encontrada.</div>
@endif