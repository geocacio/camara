
{{-- card --}}
@if(isset($data['construction']) && count($data['construction']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">Encontrados {{ count($data['construction']) }} registros relacionados a Contruções</h6>
            @foreach($data['construction'] as $obra)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $obra->title }}</h3>
                                    <p class="description">{{ $obra->types[0]->name }}</p>
                                    @if(isset($obra->generalProgress[0]))
                                        <p class="description">
                                            {{ $obra->generalProgress[0]->situation }}
                                        </p>
                                    @else
                                        <p class="description">
                                            <span>Data esperada</span> 
                                            {{ date('d/m/Y', strtotime($obra->expected_date)) }}
                                        </p>
                                    @endif
                                    <ul>
                                        <li class="description">
                                            <span>Data Inicio: </span> 
                                            {{ date('d/m/Y', strtotime($obra->date)) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- end card --}}

{{-- card --}}
@if(isset($data['lrfs']) && count($data['lrfs']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">Encontrados {{ count($data['lrfs']) }} registros relacionados a Lrfs</h6>
            @include('partials.cardByDecreeOrLaw', ['data' => $data['lrfs'], 'type' => 'lrf'])
        </div>
    </div>
@endif
{{-- end card --}}

{{-- card --}}
@if(isset($data['expenses']) && count($data['expenses']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">Encontrados {{ count($data['expenses']) }} registros relacionados a Despesas</h6>
            @foreach($data['expenses'] as $expense)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <p class="title">
                                        {{ \Illuminate\Support\Carbon::parse($expense->date)->format('d/m/Y') }}
                                    </p>
                                    <p class="description">
                                        {{ $expense->organ }}
                                    </p>
                                    <p class="description">
                                        Valor: {{ $expense->valor }} Fase: {{ $expense->fase }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- end card --}}

{{-- card --}}
@if(isset($data['service_letters']) && count($data['service_letters']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">Encontrados {{ count($data['service_letters']) }} registros relacionados a Cartas de serviços</h6>
            @foreach($data['service_letters'] as $service_letter)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="/cartaservicos/{{ $service_letter->slug }}">
                            <div class="second-part">
                                <div class="body">
                                    <p class="title">
                                        {{ $service_letter->title }}
                                    </p>
                                    <p class="description">
                                        {{ substr($service_letter->description, 0, 100) }}{{ strlen($service_letter->description) > 100 ? '...' : '' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{-- end card --}}

{{-- leis --}}
@if (isset($data['laws']) && count($data['laws']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['laws']) }} resultados relacionados a Leis</h6>
            @foreach($data['laws'] as $law)
            <div class="col-md-12">
                <div class="card-with-links">

                    <div class="header">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="second-part">
                        <div class="body">
                            <h3 class="title">{{ date('d/m/Y', strtotime($law->date)) }}</h3>
                            <p class="description">{{ Str::limit($law->description, '75', '...') }}</p>
                        </div>

                        <div class="footer">
                            <span class="d-inline-block" data-toggle="tooltip" title="Ver lei">
                                <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $law->id }}"><i class="fa fa-eye"></i></a>
                            </span>
                            @if(!empty($law->files[0]))
                                <a href="{{ asset('storage/'.$law->files[0]->file->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal decree  -->
            <div class="modal fade modal-show-info-data" id="showDecree-{{ $law->id }}" tabindex="-1" role="dialog" aria-labelledby="showDecree-{{ $law->id }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $law->title }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="view-date">
                                <span>
                                    <i class="fa-solid fa-calendar-days"></i> <span>{{ date('d/m/Y', strtotime($law->date)) }}</span>
                                </span>
                            </div>
                            <div class="description">
                                <p style="word-wrap: break-word;">{{ $law->description }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if(!empty($law->files[0]))
                                <a href="{{ asset('storage/'.$law->files[0]->file->url) }}" target="_blank" class="link" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                            @endif
                            <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- endModal decree  -->
@endif

{{-- publicações --}}
@if (isset($data['publications']) && count($data['publications']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['publications']) }} resultados relacionados a Publicações</h6>
            @foreach($data['publications'] as $publication)
            <div class="col-md-12">
                <div class="card-with-links">

                    <div class="header">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="second-part">
                        <div class="body">
                            <h3 class="title">{{ $publication->title }}</h3>
                            <p class="description">{{ Str::limit($publication->description, '75', '...') }}</p>
                        </div>

                        <div class="footer">
                            <span class="d-inline-block" data-toggle="tooltip" title="Ver lei">
                                <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $publication->id }}"><i class="fa fa-eye"></i></a>
                            </span>
                            @if(!empty($publication->files[0]))
                                <a href="{{ asset('storage/'.$publication->files[0]->file->url) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal decree  -->
            <div class="modal fade modal-show-info-data" id="showDecree-{{ $publication->id }}" tabindex="-1" role="dialog" aria-labelledby="showDecree-{{ $publication->id }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ $publication->title }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="description">
                                <p style="word-wrap: break-word;">{{ $publication->description }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if(!empty($publication->files[0]))
                                <a href="{{ asset('storage/'.$publication->files[0]->file->url) }}" target="_blank" class="link" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                            @endif
                            <button type="button" class="link" data-dismiss="modal" data-toggle="tooltip" title="Fechar"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- endModal decree  -->
@endif
