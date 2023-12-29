
{{-- card --}}
@if(isset($data['construction']) && count($data['construction']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['construction']) }} resultados relacionados a Construções</h6>
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
@if(isset($data['laws']) && count($data['laws']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['laws']) }} resultados relacionados a Leis</h6>
            @foreach($data['laws'] as $law)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <p class="title">
                                        {{ substr($law->description, 0, 100) }}{{ strlen($law->description) > 100 ? '...' : '' }}
                                    </p>
                                    <p class="description">
                                        {{ $law->date }}
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
@if(isset($data['lrfs']) && count($data['lrfs']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['lrfs']) }} resultados relacionados a LRFS</h6>
            @foreach($data['lrfs'] as $lrf)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
                            <div class="second-part">
                                <div class="body">
                                    <p class="title">
                                        {{ $lrf->title }}
                                    </p>
                                    <p class="description">
                                        {{ substr($lrf->details, 0, 100) }}{{ strlen($lrf->details) > 100 ? '...' : '' }}
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
@if(isset($data['expenses']) && count($data['expenses']) > 0)
    <div class="row">
        <div style="padding-top: 10px;" class="col-12 card">
            <h6 style="color:#30358c;">{{ count($data['expenses']) }} resultados relacionados a Despesas</h6>
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
            <h6 style="color:#30358c;">{{ count($data['service_letters']) }} resultados relacionados a Cartas de serviços</h6>
            @foreach($data['service_letters'] as $service_letter)
                <div class="col-md-12">
                    <div class="card-with-links">
                        <a href="#">
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