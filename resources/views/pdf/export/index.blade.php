<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela Dinâmica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>JOÃO BATISTA</td>
                <td>PRESIDENTE</td>
                <td>PSD</td>
            </tr>
            <tr>
                <td>SOCORRO OSTERNO</td>
                <td>VICE-PRESIDENTE</td>
                <td>PDT</td>
            </tr>
            <tr>
                <td>GILDÁZIO SAMPAIO</td>
                <td>1º SECRETÁRIO</td>
                <td>PDT</td>
            </tr>
            <tr>
                <td>ROBÉRIO CAROLINO</td>
                <td>2º SECRETÁRIO</td>
                <td>PSD</td>
            </tr>
            <tr>
                <td>INÁ OSTERNO</td>
                <td>VEREADOR (A)</td>
                <td>PSD</td>
            </tr>
            <tr>
                <td>ALENCAR NETO</td>
                <td>VEREADOR (A)</td>
                <td>PSD</td>
            </tr>
            <tr>
                <td>EDILSON VASCONCELOS</td>
                <td>VEREADOR (A)</td>
                <td>PL</td>
            </tr>
            <tr>
                <td>EDMILSON LEOCÁDIO</td>
                <td>VEREADOR (A)</td>
                <td>PDT</td>
            </tr>
            <tr>
                <td>NICINHA PONTES</td>
                <td>VEREADOR (A)</td>
                <td>PL</td>
            </tr>
            <tr>
                <td>ERASMO SOARES</td>
                <td>VEREADOR (A)</td>
                <td>PL</td>
            </tr>
            <tr>
                <td>BERG GUIMARÃES</td>
                <td>VEREADOR (A)</td>
                <td>PL</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
