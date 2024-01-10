@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>Portarias</span>
    </li>
</ul>

<h3 class="title-sub-page main">Portarias</h3>
@endsection

@section('content')

@include('layouts.header')

<section class="section-laws adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title">Campos para pesquisa</h3>
                        <form action="{{ route('portarias.show') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>De:</label>
                                        <input type="date" name="start_date" value="{{ old('start_date', $searchData['start_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Até:</label>
                                        <input type="date" name="end_date" value="{{ old('end_date', $searchData['end_date'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="{{ old('number', $searchData['number'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Tipo portaria</label>
                                        <select name="type" class="form-control input-sm">
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}" {{ old('type', $searchData['type'] ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="details" class="form-control input-sm" value="{{ old('details', $searchData['details'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Agente</label>
                                        <input type="text" name="agent" class="form-control input-sm" value="{{ old('agent', $searchData['agent'] ?? '') }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Pesquisar pelo cargo</label>
                                        <select name="cargo" class="form-control input-sm">
                                            @foreach ($cargos as $cargo)
                                                <option value="{{ $cargo->id }}" {{ old('cargo', $searchData['cargo'] ?? '') == $cargo->id ? 'selected' : '' }}>{{ $cargo->office }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('obras.page') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- @if($ordinances->count() > 0) --}}

        {{-- <div class="row"> --}}
            
            {{-- @foreach($ordinances as $ordinance)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <h3 class="title">{{ $ordinance->number }}/{{ date('Y', strtotime($ordinance->date)) }}</h3>
                                    <p class="description">{{ $ordinance->detail }}</p>
                                    <p class="description">{{ $ordinance->number }}</p>
                                    <p class="description">
                                        <span>Data</span> 
                                        {{ date('d/m/Y', strtotime($ordinance->date)) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach --}}


            {{-- {{ $construction->render() }} --}}

        {{-- </div> --}}
        
        
        @if($ordinances && $ordinances->count() > 0)
        <div class="row">
            @foreach($ordinances as $item)
            <div class="col-md-12">
                <div class="card-with-links">

                    <div class="header">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div class="second-part">
                        <div class="body">
                            <h3 class="title">{{ $item->number }}/{{ date('Y', strtotime($item->date)) }}</h3>
                            <p class="description">{{ Str::limit($item->detail, '75', '...') }}</p>
                            {{-- <p class="description">{{ $item->number }}</p> --}}
                        </div>

                        <div class="footer">
                            <span class="d-inline-block" data-toggle="tooltip" title="Ver">
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
        </div>
        @else
            <div class="empty-data">Nenhuma portaria encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Portarias'])

@include('layouts.footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $('.mask-date').mask('00-00-0000');
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection