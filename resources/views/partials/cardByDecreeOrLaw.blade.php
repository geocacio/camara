
@if($data && $data->count() > 0)
<div class="row">
    @foreach($data as $item)
    <div class="col-md-12">
        <div class="card-with-links">

            <div class="header">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div class="second-part">
                <div class="body">
                    <h3 class="title">{{ $type }} {{ $item->number }}/{{ $item->exercicy->name }}</h3>
                    <p class="description">{{ Str::limit($item->description, '75', '...') }}</p>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ $type }} {{ $item->number }}/{{ $item->exercicy->name }}</h5>
                </div>
                <div class="modal-body">
                    <div class="view-date">
                        <span>
                            <i class="fa-solid fa-calendar-days"></i> <span>{{ date('d/m/Y', strtotime($item->date)) }}</span>
                        </span>
                    </div>
                    <div class="description">
                        <p>{{ $item->description }}</p>
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

    <div class="col-12 mt-20">
        {{ $data->render() }}
    </div>
</div>
@else
<div class="empty-data">Nenhuma informação encontrada.</div>
@endif