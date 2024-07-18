@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <span>LRF</span>
    </li>
</ul>

<h3 class="title-sub-page main">Meus LRF</h3>
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
                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Número</label>
                                        <input type="text" name="number" class="form-control input-sm" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Data</label>
                                        <input type="text" name="date" class="form-control input-sm mask-date" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label>Descrição</label>
                                        <input type="text" name="description" class="form-control input-sm" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label for="competenci">Competência</label>
                                        <select class="form-control input-sm" name="competence_id" id="competenci">
                                            <option value="">Competência</option>
                                            @foreach ($competencies[0]->children as $comp)
                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label for="exercice_id">Exercício</label>
                                        <select class="form-control input-sm" name="exercice_id" id="exercice_id">
                                            <option value="">Exercício</option>
                                            @foreach ($exercicies[0]->children as $exercice)
                                                <option value="{{ $exercice->id }}">{{ $exercice->name }}</option>
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
                                            <a href="{{ route('lrf.page') }}" class="btn btn-search close btn-sm" data-toggle="tooltip" title="Limpar pesquisa"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-lrf-menu">
            <div class="search-by">
                <div class="item-lrf-type active-lrf" id="exercicio">
                    Agrupado por exercício
                </div>
                <div class="item-lrf-type" id="document">
                    Agrupado por tipo de documento
                </div>
                <div class="item-lrf-type" id="about">
                    Vamos entender um pouco?
                </div>
            </div>
            <div class="sub-item-container" id="exercicio-conteudo">
                @foreach ($exercicies[0]->children->sortByDesc('name') as $exercice)
                    <div class="sub-item @if($loop->first) active-lrf @endif" id="item-{{ $exercice->name }}">
                        {{ $exercice->name }}
                    </div>
                @endforeach
            </div>
            <div class="sub-item-container" id="document-conteudo" style="display: none">
                @foreach ($allTypes as $type)
                    <div class="sub-item document-filter" id="{{ strtok($type->name, ' ') }}">
                        {{ strtok($type->name, ' ') }}
                    </div>  
                @endforeach
            </div>
            <div class="document-lrf-explain" id="about-conteudo" style="display: none">
                <div class="details-about">
                    <div class="title">
                        <span>PPA - PLANO PLURIANUAL</span>
                    </div>
                    <div class="content-about-document">
                        <span>
                            O Plano Plurianual (PPA), no Brasil, previsto no artigo 165 da Constituição Federal e regulamentado pelo Decreto 2.829, de 29 de outubro de 1998 é um plano de médio prazo, que estabelece as diretrizes, objetivos e metas a serem seguidos pelo Governo Federal, Estadual ou Municipal ao longo de um período de quatro anos.
                        </span>
                    </div>
                </div>
                <div class="details-about">
                    <div class="title">
                        <span>LDO - LEI DE DIRETRIZES ORÇAMENTÁRIA</span>
                    </div>
                    <div class="content-about-document">
                        <span>
                            O Projeto de Lei de Diretrizes Orçamentárias (LDO) estabelece as metas e prioridades para o exercício financeiro seguinte; orienta a elaboração do Orçamento; dispõe sobre alteração na legislação tributária; estabelece a política de aplicação das agências financeiras de fomento (ação do governo que visa o desenvolvimento de um país, de uma região ou de um setor econômico).
                        </span>
                    </div>
                </div>
                <div class="details-about">
                    <div class="title">
                        <span>LOA - LEI ORÇAMENTÁRIA ANUAL</span>
                    </div>
                    <div class="content-about-document">
                        <span>
                            LOA pode ser definida como a lei que estima as receitas que serão arrecadadas no exercício seguinte e autoriza a realização das despesas decorrentes do plano de governo. As ações de governo são limitadas por um teto de despesa, mas, se houver necessidade, a lei prevê que a prefeitura poderá abrir crédito suplementar. Por outro lado, pode-se, em cada ação de governo, não se gastar nada; donde se conclui que as emendas do Legislativo podem não ser realizadas.
                        </span>
                    </div>
                </div>
                <div class="details-about">
                    <div class="title">
                        <span>RREO - RELATÓRIO RESUMIDO DA EXECUÇÃO ORÇAMENTÁRIA</span>
                    </div>
                    <div class="content-about-document">
                        <span>
                            O Relatório Resumido da Execução Orçamentária (RREO) tem por finalidade evidenciar a situação fiscal do município, demonstrando a execução orçamentária da receita e da despesa. O relatório permite aos órgãos de controle interno e externo, aos usuários e à sociedade em geral conhecer, acompanhar e analisar o desempenho das ações governamentais estabelecidas na Lei de Diretrizes Orçamentárias (LDO) e na Lei Orçamentária Anual (LOA). É pressuposto da responsabilidade na gestão fiscal a ação planejada e transparente em que se previnam riscos e corrijam desvios capazes de afetar o equilíbrio das contas públicas
                        </span>
                    </div>
                </div>
                <div class="details-about">
                    <div class="title">
                        <span>RGF - RELATÓRIO DE GESTÃO FISCAL</span>
                    </div>
                    <div class="content-about-document">
                        <span>
                            O RGF é um dos instrumentos de Transparência da Gestão Fiscal criados pela Lei de Responsabilidade Fiscal (LRF). Especificamente, o RGF objetiva o controle, o monitoramento e a publicidade do cumprimento, por parte dos entes federativos, dos limites estabelecidos pela LRF: Despesas com Pessoal, Dívida Consolidada Líquida, Concessão de Garantias e Contratação de Operações de Crédito. Todos esses limites são definidos em percentuais da Receita Corrente Líquida (RCL), que é apurada em demonstrativo próprio. Ao final do exercício, a LRF exige ainda a publicação de demonstrativos que evidenciem as Disponibilidades de Caixa e a Inscrição de Restos a Pagar.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- @include('partials.cardByDecreeOrLaw', ['data' => $lrfs, 'type' => 'lrfs']) --}}
        @foreach($resultArray as $lrfIndex => $items)
            @foreach($items as $index => $item)
                <div class="document-type-{{ strtok($item->types[0]->name, ' ') }} col-md-12 lrf-item-a item-{{ $lrfIndex }}-lrf" @if($lrfIndex != $exercicies[0]->children[0]->name) style="display: none;" @endif>
                    <div class="card-with-links">
                        {{-- <div class="header">
                            <i class="fa-regular fa-file-lines"></i>
                        </div> --}}
                        <div class="second-part">
                            <div class="body">
                                <h3 class="title">{{ strtok($item->types[0]->name, ' ') }} - {{ $item['title'] }}</h3>
                                <p class="description">Exercício: {{ $lrfIndex }}</p>
                                <p class="description">{{ Str::limit($item['details'], 75, '...') }}</p>
                            </div>
                            <div class="footer">
                                <span class="d-inline-block" data-toggle="tooltip" title="Ver">
                                    <a href="#" class="links" data-toggle="modal" data-target="#showDecree-{{ $item['id'] }}"><i class="fa fa-eye"></i></a>
                                </span>
                                @if(!empty($item['files'][0]))
                                    <a href="{{ asset('storage/'.$item['files'][0]['file']['url']) }}" target="_blank" class="links" data-toggle="tooltip" title="Ver documento"><i class="fa-solid fa-file-pdf"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <p style="word-wrap: break-word;">{{ $item->details }}</p>
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
            @endforeach
        @endforeach
    
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'lrfs'])

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
                $(".document-lrf-explain").hide();
            }
        });
    });

    // filter by yaer
    $(document).ready(function(){
        $("#exercicio").trigger("click");
    });

    
    $(document).ready(function(){
        console.log('document is ready');

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

    // filter by document
    $(document).ready(function(){
        $(".document-filter:first").trigger("click");

        $(".document-filter").click(function(){
            var divClicada = $(this).attr('id');
            $(".lrf-item-a").hide();
            let lrf = $(".document-type-" + divClicada).show();
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