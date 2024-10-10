@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('sic.panel') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>eSic - Solicitações</span>
    </li>
</ul>

<h3 class="title-sub-page main">eSic - Solicitações</h3>
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
                        <form action="{{ route('sic.search') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Filtro por protocolo/resumo</label>
                                        <input type="text" name="protocol" value="{{ old('protocol', $searchData['protocol'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label>Filtro por exercício:</label>
                                        <input type="number" name="exercicy" value="{{ old('exercicy', $searchData['exercicy'] ?? '') }}" class="form-control input-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <a href="{{ route('sic.search') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($solicitations->count() > 0)

            
        <div class="container-lrf-menu">
            <div class="search-by">
                <div class="item-lrf-type active-lrf" id="com-sigilo">
                    Solicitações não classificadas com sigilo
                </div>
                <div class="item-lrf-type" id="sem-sigilo">
                    Solicitações com sigilo
                </div>
            </div>
            <div class="sub-item-container" id="com-sigilo-conteudo">
                @foreach ($solicitations as $solicitation)
                    <div class="sub-item-sic @if($loop->first) active-lrf @endif">
                        <div class="body">
                            <p class="description">Solicitação: {{ $solicitation->anonymous }}</p>
                            <p class="description">Protocolo: {{ $solicitation->protocol }} data {{  $solicitation->created_at->format('d/m/Y')}}</p>
                            <p class="description">Situação: {{ $solicitation->situations[0]->situation }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="sub-item-container" id="sem-sigilo-conteudo" style="display: none">
                @foreach ($solicitations as $solicitation)
                    <div class="sub-item-sic">
                        <div class="body">
                            <p class="description">Solicitação: {{ $solicitation->solicitation }}</p>
                            <p class="description">Protocolo: {{ $solicitation->protocol }} data {{  $solicitation->created_at->format('d/m/Y')}}</p>
                            <p class="description">Situação: {{ $solicitation->situations[0]->situation }}</p>
                        </div>
                    </div>  
                @endforeach
            </div>
        </div>


        @else
            <div class="empty-data">Nenhum comissão encontrada.</div>
        @endif

    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Obras'])

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

    $(document).ready(function(){
        $(".item-lrf-type").click(function(){
            // Esconde todas as divs
            $(".sub-item-container").hide();

            // Obtém o ID da div clicada
            var divClicada = $(this).attr('id');
            // Exibe a div correspondente ao ID
            let item = $("#" + divClicada + "-conteudo").show();

            if(item.attr("id") == "about-conteudo"){
                $("#law-lrf-content").hide();
                $(".lrf-item-a").hide();
            }else {
                $("#law-lrf-content").show();
                $(".sem-sigilo-lrf-explain").hide();
            }
        });
    });

    // filter by yaer
    $(document).ready(function(){
        $("#com-sigilo").trigger("click");
    });

    
    $(document).ready(function(){
        $(".sub-item").click(function(){
            var divClicada = $(this).attr('id');
            console.log(divClicada + ' foi clicado');
            $(".lrf-item-a").hide();
            $("." + divClicada + "-lrf").show();
        });

        setTimeout(function(){
            var firstItem = $(".sub-item:first");
            if (firstItem.length) {
                firstItem.click();
            }
        }, 100);
    });

    // filter by sem-sigilo
    $(document).ready(function(){
        $(".sem-sigilo-filter:first").trigger("click");

        $(".sem-sigilo-filter").click(function(){
            var divClicada = $(this).attr('id');
            $(".lrf-item-a").hide();
            let lrf = $(".sem-sigilo-type-" + divClicada).show();
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        var itemTypes = document.querySelectorAll('.item-lrf-type');
        var subItems = document.querySelectorAll('.sub-item');

        // Adiciona evento de clique para os itens em search-by
        itemTypes.forEach(function (item) {
            item.addEventListener('click', function () {
                // Remove a classe ativa de todos os itens em search-by
                itemTypes.forEach(function (i) {
                    i.classList.remove('active-lrf');
                });
                
                // Adiciona a classe ativa apenas ao item clicado
                item.classList.add('active-lrf');
            });
        });

        // Adiciona evento de clique para os sub-itens
        subItems.forEach(function (subItem) {
            subItem.addEventListener('click', function () {
                // Remove a classe ativa de todos os sub-itens
                subItems.forEach(function (s) {
                    s.classList.remove('active-lrf');
                });
                
                // Adiciona a classe ativa apenas ao sub-item clicado
                subItem.classList.add('active-lrf');
            });
        });
    });

</script>
@endsection