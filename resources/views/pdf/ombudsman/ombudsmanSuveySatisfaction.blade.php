<html>

<head>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -100px;
            left: 0px;
            right: 0px;
        }



        header .about {
            font-size: 11px;
        }

        header .image {
            width: 120px;
            height: auto;
            margin: auto;
        }

        header .title {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 0;
        }

        main {
            position: relative;
            top: 90px;
            margin-bottom: 50px;
        }

        main .title {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 25px;
            margin-bottom: 0;
        }

        main .description {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
        }

        main .content .content-item {
            margin-bottom: 15px;
        }

        main .content .content-item .title {
            text-align: left;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
        }

        main .content .content-item .description {
            text-align: left;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
            margin-top: 0;
        }

        main .content .content-item .description-list {
            list-style: circle;
            padding-left: 15px;
            margin-top: 0;
        }

        main .content .content-item .description-list li {
            text-align: left;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
        }

        footer .title {
            margin-bottom: 5px;
        }

        footer .link {
            color: #000;
            font-size: 13px;
            text-decoration: none;
        }

        footer .published {
            color: #000;
            font-size: 13px;
            text-decoration: none;
            margin-top: 5px;
        }

        .table {
            width: 100%;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .table thead {
            background: #00668b;
            color: #fff;
            position: sticky;
            top: 0;
        }

        .table tbody tr {
            border-width: 0px;
        }

        .table tbody tr td {
            font-size: 14px;
            font-weight: 500;
            line-height: 1;
            color: #454545;
            text-align: center;
            border-style: solid;
            border-width: 1px;
            border-color: #000;
        }

        .img-graphic {
            width: 100%;
            height: 300px;
            object-fit: contain;
            margin: auto;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        @if($logo)
        <img class="image" src="{{ storage_path('app/public/'.$logo->url) }}">
        @endif

        @if($settings)
        <h3 class="title">{{ $settings->system_name }}</h3>
        <div class="about">
            {{ $settings->address }}, {{ $settings->number }} - {{ $settings->neighborhood }} - CEP:{{ $settings->cep }} - {{ $settings->city }}\{{ $settings->state }}<br>
            CNPJ: {{ $settings->cnpj }} - Tel: {{ $settings->phone }} - Site {{ route('home') }}
        </div>
        @endif
    </header>

    <footer>
        @if($settings)
        <h3 class="title">{{ $settings->system_name }}</h3>
        @endif
        <a class="link" href="{{ route('relatorios.estatisticos.reports') }}">{{ route('relatorios.estatisticos.reports') }}</a>
        <p class="published">Emitido: {{ date('d/m/Y H:i:s') }}</p>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <h3 class="title">RELATÓRIO ESTATÍSTICO POR PESQUISA DE SATISFAÇÃO</h3>

        <div class="content">
            @if($tableQuestionsData && !empty($tableQuestionsData))

            <table class="table">
                <thead>
                    <tr>
                        <th>Pergunta</th>
                        @foreach($tableQuestionsData[0]['satisfaction_counts'] as $key => $total)
                        <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($tableQuestionsData as $index => $item)
                    <tr>

                        <td>{{ $item['question_text'] }}</td>
                        @foreach($item['satisfaction_counts'] as $total)
                        <td class="align-center">{{ $total }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>

            </table>

            @endif

            <img class="img-graphic" src="{{ $chart }}">

            @if($chartData && !empty($chartData))

            <table class="table">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Nota</th>
                    </tr>
                </thead>

                <tbody>
                    @for($i = 0; $i < count($chartData['labels']) ; $i++)
                    <tr>
                        <td>{{ $chartData['labels'][$i] }}</td>
                        <td>{{ $chartData['data'][$i] }}</td>
                    </tr>
                    @endfor
                </tbody>

            </table>

            @endif

        </div>

    </main>
</body>

</html>