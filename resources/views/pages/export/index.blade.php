@extends('layouts.app')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="item">
        <a href="{{ route('home') }}" class="link">Início</a>
    </li>
    <li class="item">
        <a href="{{ route('transparency.show') }}" class="link">Portal da transparência</a>
    </li>
    <li class="item">
        <span>Ambiente exportação de dados</span>
    </li>
</ul>


@endsection

@section('content')

@include('layouts.header')


<section class="section-decrees adjust-min-height no-padding-top">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card main-card container-search-advanced">
                    <div class="search-advanced mb-0">
                        <h3 class="title-sub-page">{{ $page[0] }}</h3>
                        <h3 class="title">Ambiente de exportação de dados</h3>
                        <form onsubmit="event.preventDefault(); exportData();">
                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-0 select-file-container">
                                    <select id="doc_type" multiple>
                                        <option value="xls">XLS</option>
                                        <option value="csv">CSV</option>
                                        <option value="json">JSON</option>
                                        <option value="text">Texto</option>
                                        <option value="pdf">PDF</option>
                                        <option value="doc">DOC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-2 col-md-12">
                                    <div class="h-100 form-group mb-0">
                                        <div class="btn-groups">
                                            <button type="submit" class="btn btn-search btn-sm" data-toggle="tooltip" title="Baixar"><i class="fa-solid fa-file-export"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped table-data-default">
                        <thead>
                            <tr>
                                @foreach ($labels as $label) {{-- Usando os rótulos passados --}}
                                    <th>{{ $label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    {{-- Exibe os dados do modelo principal --}}
                                    @foreach ($columns['columns'] as $column)
                                        @if (!in_array($column, $hidden)) {{-- Verifica se a coluna não está oculta --}}
                                            <td>{{ $item->$column }}</td>
                                        @endif
                                    @endforeach
        
                                    {{-- Exibe os dados dos relacionamentos, se houver --}}
                                    @if (isset($columns['relationships']))
                                        @foreach ($columns['relationships'] as $relationship => $relationshipColumns)
                                            @if ($item->$relationship) {{-- Verifica se o relacionamento foi carregado --}}
                                                @foreach ($relationshipColumns as $relColumn)
                                                    @if (!in_array($relColumn, $hidden)) {{-- Verifica se a coluna não está oculta --}}
                                                        <td>{{ $item->$relationship->$relColumn }}</td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{ $data->render() }}
        </div>
        
        
    </div>
</section>

@include('pages.partials.satisfactionSurvey', ['page_name' => 'Exportação de dados'])

@include('layouts.footer')

@endsection

@section('scripts')
<script>
    async function exportData() {
        // Obter o último segmento da URL
        const pathSegments = window.location.pathname.split('/');
        const model = pathSegments[pathSegments.length - 1]; // Último segmento
        const format = document.getElementById('doc_type').value;

        if (!model || !format) {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        const params = new URLSearchParams();
        params.append('model', model);
        params.append('format', format);

        try {
            const response = await fetch('/api/export?' + params.toString(), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');

                // Obter a data atual e formatá-la como "1-10"
                const today = new Date();
                const options = { day: 'numeric', month: 'numeric' };
                const formattedDate = today.toLocaleDateString('pt-BR', options).replace(/\//g, '-');

                // Definir o nome do arquivo
                a.href = url;
                a.download = `${model}-${formattedDate}.${format}`;
                document.body.appendChild(a);
                a.click();
                a.remove();
            } else {
                const errorData = await response.json();
                alert(errorData.error || 'Erro ao exportar os dados.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao fazer a requisição.');
        }
    }

    document.getElementById('doc_type').addEventListener('change', function() {
        if (this.selectedOptions.length > 1) {
            for (let i = 0; i < this.options.length; i++) {
                this.options[i].selected = false;
            }
            this.options[this.selectedIndex].selected = true;
        }
    });
</script>

@endsection
