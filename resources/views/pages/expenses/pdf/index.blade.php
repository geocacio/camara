<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câmara Municipal de Marco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 13px;
        }

        h2, h3 {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            font-size: 13px;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        address {
            font-style: normal;
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>{{ $setting->system_name }}</h1>
            <address>
                @if($setting->address || $setting->number || $setting->neighborhood || $setting->cep || $setting->city || $setting->state)
                    {{ $setting->address }}{{ $setting->number ? ', ' . $setting->number : '' }},
                    {{ $setting->neighborhood ? $setting->neighborhood . ', ' : '' }}
                    CEP: {{ $setting->cep }}, {{ $setting->city }}{{ $setting->state ? '/' . $setting->state : '' }}<br>
                @endif
                @if($setting->cnpj || $setting->plenary)
                    CNPJ: {{ $setting->cnpj }} @if($setting->plenary) | CGF: {{ $setting->plenary }} @endif<br>
                @endif
                <a href="https://cmcidelandia.ma.gov.br/">cmcidelandia.ma.gov.br/</a><br>
                @if($setting->email)
                    Email: <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a><br>
                @endif
                @if($setting->phone)
                    Tel: {{ $setting->phone }}
                @endif
            </address>
        </header>            

        <h2>INFORMAÇÕES DO EMPENHO</h2>
        <p>NÚMERO: {{ $voucher->voucher_number }} - DATA: {{ \Carbon\Carbon::parse($voucher->voucher_date)->format('d/m/Y') }} - VALOR: R$ {{ number_format($voucher->amount, 2, ',', '.') }}</p>

        <table>
            <tr>
                <td>UNIDADE GESTORA</td>
                <td>ÓRGÃO</td>
            </tr>
            <tr>
                <td>CÂMARA MUNICIPAL</td>
                <td>01 - CÂMARA MUNICIPAL</td>
            </tr>
            <tr>
                <td>UNIDADE ORÇAMENTÁRIA</td>
                <td>PROJETO ATIVIDADE</td>
            </tr>
            <tr>
                <td>01.01 - CÂMARA MUNICIPAL</td>
                <td>2.001 - GERENCIAMENTO ADMINISTRATIVO DO LEGISLATIVO MUNICIPAL</td>
            </tr>
        </table>

        <h3>NATUREZA</h3>
        <p>{{ $voucher->nature }}</p>
        <p>FORNECEDOR: {{ $voucher->supplier }} - {{ $voucher->document }}</p>
        <p>FONTE DE RECURSO: {{ $voucher->resource_source }}</p>

        <h3>INFORMAÇÕES DO HISTÓRICO</h3>
        <p>{{ $voucher->description }}</p>

        <h3>MOVIMENTAÇÕES DA LIQUIDAÇÃO</h3>
        <table>
            <tr>
                <td>DATA</td>
                <td>ETAPA</td>
                <td>NOTA FISCAL</td>
                <td>EXERCÍCIO</td>
                <td>(R$) VALOR</td>
            </tr>
            @foreach ($voucher->liquidations as $liquidation)
            <tr>
                <td>{{ \Carbon\Carbon::parse($liquidation->liquidation_date)->format('d/m/Y') }}</td>
                <td>LIQUIDAÇÃO</td>
                <td>{{ $liquidation->invoice_number }}</td>
                <td>{{ $liquidation->fiscal_year }}</td>
                <td>{{ number_format($liquidation->amount, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>

        <h3>MOVIMENTAÇÕES DO PAGAMENTO</h3>
        <table>
            <tr>
                <td>DATA</td>
                <td>NÚMERO PAGAMENTO</td>
                <td>EXERCÍCIO</td>
                <td>(R$) VALOR</td>
            </tr>
            @foreach ($voucher->payments as $expense)
            <tr>
                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                <td>{{ $expense->payment_number }}</td>
                <td>{{ $expense->exercise }}</td>
                <td>{{ $expense->valor }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
