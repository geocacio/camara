@if($section->visibility === 'enabled')
<section id="sec-blog-section" class="blog-section">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <h3 class="title text-center mb-5">Publicações</h3>
            </div>
            @if($lrfs && $lrfs->count() > 0)
            <div class="col-md-6">
                <div class="card-publications">
                    <div class="card-header">
                        <h4 class="title">LEI DE RESPONSABILIDADE FISCAL</h4>
                    </div>
                    <div class="card-body">
                        @foreach($lrfs as $lrf)
                            <div class="link-publication">
                                <div class="top">
                                    <div>
                                        <h5 class="title-card-pub"><b>{{ $lrf->title }}</b></h5>
                                        <p class="">{{ Str::limit($lrf->details, '120', '...') }}</p>
                                    </div>
                                    <h5 class="title"><i class="fa-solid fa-calendar-days"></i> {{ date('d/m/Y', strtotime($lrf->date)) }}</h5>
                                </div>
                                <div class="bottom justify-content-end">
                                    <span class="d-inline-block" data-toggle="tooltip" title="Ver">
                                        <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $lrf->id }}"><i class="fa fa-eye"></i></a>
                                    </span>
                                </div>
                            </div>
                            <!-- Modal decree  -->
                            <div class="modal fade modal-show-info-data" id="showDecree-{{ $lrf->id }}" tabindex="-1" role="dialog" aria-labelledby="showDecree-{{ $lrf->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $lrf->title}}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="view-date">
                                                <span>
                                                    <i class="fa-solid fa-calendar-days"></i> <span>{{ date('d/m/Y', strtotime($lrf->date)) }}</span>
                                                </span>
                                            </div>
                                            <div class="description">
                                                <p style="word-wrap: break-word;">{{ $lrf->details }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            @if(!empty($lrf->files[0]))
                                                <a href="{{ asset('storage/'.$lrf->files[0]->file->url) }}" target="_blank" class="link" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                            @endif
                                            <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- endModal decree  -->
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('lrf.page') }}" class="btn btn-link-page">Ver mais</a>
            </div>
            @endif

            @if($leis && $leis->count() > 0)
            <div class="col-md-6">
                <div class="card-publications">
                    <div class="card-header">
                        <h4 class="title">LEIS, ATOS E NORMATIVOS MUNICIPAIS</h4>
                    </div>
                    <div class="card-body">

                        @foreach($leis as $lei)
                            <div class="link-publication">
                                <div class="top">
                                    <div>
                                        <h5 class="title-card-pub"><b>{{ $lei->title }}</b></h5>
                                        <p class="">{{ Str::limit($lei->description, '120', '...') }}</p>
                                    </div>
                                    <h5 class="title"><i class="fa-solid fa-calendar-days"></i> {{ date('d/m/Y', strtotime($lei->date)) }}</h5>
                                </div>
                                <div class="bottom">
                                    <span class="d-inline-block" data-toggle="tooltip" title="Ver">
                                        <a href="#" class="links" data-toggle="modal" data-target="#showLaw-{{ $lei->id }}"><i class="fa fa-eye"></i></a>
                                    </span>

                                    @if(!empty($lei->files[0]))
                                        <span class="d-inline-block" data-toggle="tooltip" title="Ver">
                                            <a href="{{ asset('storage/'.$lei->files[0]->file->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Modal law  -->
                            <div class="modal fade modal-show-info-data" id="showLaw-{{ $lei->id }}" tabindex="-1" role="dialog" aria-labelledby="showLaw-{{ $lei->id }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"> {{ $lei->id }}/{{ date('Y', strtotime($lei->date)) }}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="view-date">
                                                <span>
                                                    <i class="fa-solid fa-calendar-days"></i> <span>{{ date('d/m/Y', strtotime($lei->date)) }}</span>
                                                </span>
                                            </div>
                                            <div class="description">
                                                <p>{{ $lei->description }}</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            @if(!empty($lei->files[0]))
                                                <a href="{{ asset('storage/'.$lei->files[0]->file->url) }}" target="_blank" class="link" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                            @endif
                                            <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- endModal law  -->
                        @endforeach

                    </div>
                </div>
                <a href="{{ route('leis.show') }}" class="btn btn-link-page">Ver mais</a>
            </div>
            @endif

        </div>
    </div>
</section>
@endif
