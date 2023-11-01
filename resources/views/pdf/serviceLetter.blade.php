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
        <a class="link" href="{{ route('serviceLetter.show', $serviceLetter->slug) }}">{{ route('serviceLetter.show', $serviceLetter->slug) }}</a>
        <p class="published">Emitido: {{ $serviceLetter->updated_at->format('d/m/Y H:i:s') }}</p>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <h3 class="title">{{ $serviceLetter->title }}</h3>
        <p class="description">{{ $serviceLetter->description }}</p>

        <div class="content">
            @if($serviceLetter->service_letters != '')
            @foreach(json_decode($serviceLetter->service_letters) as $services)
            <div class="content-item">
                <h3 class="title">{{ $services->input_value }}</h3>
                @if($services->checklist)
                    @php
                    $currentCheckList = explode("\n", $services->textarea_value);
                    @endphp
                    <div class="accordion-body">
                        <ul class="description-list">
                            @foreach($currentCheckList as $item)
                            <li class="item"><i class="fa-solid fa-square-check"></i>{{$item}}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="description">{!! nl2br($services->textarea_value) !!}</p>
                @endif
            </div>
            @endforeach
            @endif
        </div>

    </main>
</body>

</html>