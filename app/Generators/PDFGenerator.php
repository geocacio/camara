<?php
// app/PDFGenerator.php

namespace App\Generators;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use TCPDF;



class PDFGenerator extends TCPDF
{
    protected $headerData;
    protected $footerData;
    protected $currentDate;

    // Construtor para a classe
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);
    }

    // Método para definir os dados do cabeçalho
    protected function CustomSetHeaderData($headerData)
    {
        $this->headerData = $headerData;
        $this->currentDate = Carbon::now()->locale('pt_BR');
    }
    protected function CustomSetFooterData($footerData)
    {
        $this->footerData = $footerData;
    }

    // Método Header() para gerar o cabeçalho personalizado
    public function Header()
    {
        // Verifica se os dados do cabeçalho foram definidos
        if (empty($this->headerData)) {
            return;
        }

        // Define a margem superior para o cabeçalho
        $this->SetMargins(PDF_MARGIN_LEFT, 60, PDF_MARGIN_RIGHT);

        // Carrega a imagem do logo
        $logoImage = $this->headerData['logoPath'];
        $logoWidth = 27;
        $logoHeight = 27;

        // Exibe o logo do cabeçalho
        $this->Image($logoImage, 10, 2, $logoWidth, $logoHeight, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Título
        $this->Ln(10);
        $this->SetFont('times', 'B', 35);
        // Exibe o título do cabeçalho centralizado
        $this->Cell(0, 10, $this->headerData['title'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Subtítulo
        $this->Ln(10); // Quebra de linha
        $this->SetFont('times', 'B', 20);
        $this->Cell(0, 10, $this->headerData['subtitle'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        //Informação da direita
        $this->Ln(7); // Quebra de linha
        $this->SetFont('times', '', 9);
        $this->Cell(0, 10, $this->headerData['infoRight'], 0, false, 'R', 0, '', 0, false, 'M', 'M');

        //Fundo cor azul
        $this->SetFillColor(210, 221, 233);
        // Define a largura da caixa vazia igual à largura da página
        $boxWidth = $this->GetPageWidth();
        // Define a altura da caixa vazia (por exemplo, 10 mm)
        $boxHeight = 10;
        // Define as coordenadas X e Y para a posição da caixa (por exemplo, X = 0, Y = 30)
        $boxX = 0;
        $boxY = 32;
        // Desenha o retângulo com o background na posição especificada
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight, 'F');
        // Define a fonte e o tamanho do texto
        $this->SetFont('times', '', 10);
        // Obtém a altura do texto para centralizá-lo verticalmente
        $textHeight = $this->FontSize; // Altura da fonte definida no SetFont
        // Calcula a posição Y para centralizar o texto verticalmente na caixa
        $textY = $boxY + ($boxHeight - $textHeight) / 2;
        // Define o alinhamento do texto como centralizado
        $this->SetXY($boxX, $textY);
        // $this->MultiCell($boxWidth, $textHeight, '', 0, 'C', 0, 1, $boxX, $textY);
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight, 'F');

        // Texto centralizado
        $this->Ln(2); // Quebra de linha
        $this->SetFont('times', '', 9);
        $this->Cell(0, 10, $this->headerData['infoCenter'], 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $pageWidth = $this->GetPageWidth();

        // Define a largura e altura das células
        $cellHeight = 10;
        $padding = 20;

        // Obtém o número da página atual
        $pageNumber = $this->getAliasNumPage();

        // Obtém o número total de páginas
        $totalPages = $this->getAliasNbPages();
        $this->SetY($this->GetY() + 15);
        // Largura da célula para cada coluna
        $col1Width = $this->GetStringWidth($this->currentDate->formatLocalized('%A, %d de %Y'));
        $col2Width = $this->GetStringWidth('Ano VII | Edição nº 285 ISSN: XXXX-XXXX');
        $col3Width = $this->GetStringWidth('Página ' . $pageNumber . ' de ' . $totalPages);

        // Ajusta a posição das três colunas para cima
        // $this->SetY($this->GetY() - 5); // Ajuste o valor conforme necessário
        $this->Ln(-7);
        // Coluna 1 (à esquerda)
        $this->Cell($col1Width, $cellHeight, $this->currentDate->formatLocalized('%A, %d de %Y'), 0, false, 'L', 0, '', 0, false, 'M', 'M');

        // Coluna 2 (no centro)
        $col2X = ($pageWidth - $col2Width) / 2;
        $this->SetX($col2X);
        $this->Cell($col2Width, $cellHeight, 'Ano VII | Edição nº 285 ISSN: XXXX-XXXX', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // Coluna 3 (à direita)
        $col3X = $pageWidth - $col3Width - $padding;
        $this->SetX($col3X);
        $this->Cell($col3Width, $cellHeight, 'Página ' . $pageNumber . ' de ' . $totalPages, 0, false, 'R', 0, '', 0, false, 'M', 'M');

        //Fundo cor azul
        $this->SetFillColor(210, 221, 233);
        // Define a largura da caixa vazia igual à largura da página
        $boxWidth = $this->GetPageWidth();
        // Define a altura da caixa vazia (por exemplo, 10 mm)
        $boxHeight = 2.5;
        // Define as coordenadas X e Y para a posição da caixa (por exemplo, X = 0, Y = 30)
        $boxX = 0;
        $boxY = 49;
        // Desenha o retângulo com o background na posição especificada
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight, 'F');
        // Define a fonte e o tamanho do texto
        $this->SetFont('times', '', 10);
        // Obtém a altura do texto para centralizá-lo verticalmente
        $textHeight = $this->FontSize; // Altura da fonte definida no SetFont
        // Calcula a posição Y para centralizar o texto verticalmente na caixa
        $textY = $boxY + ($boxHeight - $textHeight) / 2;
        // Define o alinhamento do texto como centralizado
        $this->SetXY($boxX, $textY);
        // $this->MultiCell($boxWidth, $textHeight, '', 0, 'C', 0, 1, $boxX, $textY);
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight, 'F');
    }

    public function Footer()
    {
        // // Configurações do rodapé
        $this->SetY(-15); // Posição a partir do fim da página (15 mm acima do fim)
        $this->SetFillColor(210, 221, 233); // Cor de fundo para o retângulo
        $this->Rect(0, $this->getPageHeight() - 15, $this->GetPageWidth(), 2.5, 'F'); // Desenha o retângulo do rodapé

        // Título
        $this->SetFont('times', '', 9);
        $this->SetTextColor(0); // Cor do texto (preto)
        $this->Cell(0, 10, $this->footerData['title'], 0, 0, 'C');

        // Descrição
        $this->Ln(4); // Quebra de linha
        $this->Cell(0, 10, $this->footerData['description'], 0, 0, 'C');
    }

    protected function createSummary($summary)
    {
        // Defina a largura e altura da página
        $pageWidth = $this->GetPageWidth() - 20;
        $pageHeight = $this->GetPageHeight() - 10;

        // Primeira coluna: Sumário
        $this->SetFont('times', 'B', 9);
        $this->SetFillColor(210, 221, 233); // Defina a cor de fundo para o sumário

        // Variável para armazenar a posição do rodapé
        $footerPosition = $pageHeight - $this->getFooterMargin();

        // Variável para armazenar a posição do sumário
        $summaryPosition = $this->GetY();

        // Calcule a altura do retângulo que ficará por baixo do sumário
        $rectHeight = $footerPosition - $summaryPosition;

        // Desenhe o retângulo por baixo do sumário
        $this->Rect(10, $summaryPosition, $pageWidth, $rectHeight, 'F');

        // Escrever o título do Sumário (usando a largura da página como largura para ocupar toda a largura)
        $this->Cell($pageWidth - 10, 10, 'Sumário', 0, 1, 'C', true, '');
        foreach ($summary as $item) {
            $this->SetFont('times', 'B', 9);
            // Calcule a quantidade de pontos necessários para preencher o espaço no sumário
            $dots = str_repeat('.', $pageWidth - $this->GetStringWidth($item['title']) - 10);
            // Escrever o título do Sumário com os pontinhos no sumário
            $this->Cell($pageWidth - 20, 10, '          ' . $item['title'] . ' ' . $dots . ' ' . $item['page'], 0, 1, 'L', true, $item['url']);

            foreach ($item['items'] as $subItem) {
                $this->SetFont('times', '', 9);
                $dots = str_repeat('.', $pageWidth - $this->GetStringWidth($item['title']) - 20);
                $this->Cell($pageWidth - 30, 10, '                    ' . $subItem['title'] . ' ' . $dots . ' ' . $subItem['page'], 0, 1, 'L', true, $subItem['url']);
            }
        }
    }

    public function generate($official_diary, $headerData, $footerData, $summaryGroup)
    {
        // Defina o título do cabeçalho para exibição
        $this->CustomSetHeaderData($headerData);
        $this->CustomSetFooterData($footerData);

        // // Definir o tamanho da página
        // $this->SetPageSize(170, 250); // 17 cm x 25 cm

        // Definir a fonte e o tamanho
        $this->SetFont('times', '', 9);

        // Definir o espaçamento entre linhas (simples)
        // $this->setCellHeightRatio(0.6);

        // // Definir alinhamento justificado
        // $this->SetAlign('justify');

        // Definir as margens
        // $this->SetMargins(30, 30, 20);

        $this->SetCreator(PDF_CREATOR);
        $this->SetPrintHeader(true);
        $this->SetPrintFooter(true); // Habilitar a exibição do rodapé

        // $this->generateFooter($footerData);

        // Definir o rodapé com o número da página atual e o número total de páginas
        $this->setFooterData(array(0, 0, 0), array(0, 0, 0));
        $this->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // $this->generateFooter($footerData);

        // Definir o cabeçalho com a imagem do logo
        // $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // Adicionar nova página
        $this->AddPage();
        $sumarioY = $this->getY();

        //Preparar o conteúdo do pdf
        $summary = [];
        $currentColumnWidth = '';
        $resetColumns = false;
        foreach ($official_diary->publications as $index => $content) {

            if ($content->column == 2) {
                $currentColumnWidth = ($this->getPageWidth() / 2) - 15;
                if ($index == 0) {
                    $this->AddPage();
                    $this->resetColumns();
                    $this->setEqualColumns(2, $currentColumnWidth);
                }
                if ($resetColumns) {
                    $resetColumns = false;
                    $this->resetColumns();
                    $this->setEqualColumns(2, $currentColumnWidth);
                }
            } else {
                //Verificar a posição do conteúdo (se estiver na esquerda adiciona uma nova página), ou se for o primeiro conteúdo da página
                if ($index == 0 || $this->GetX() > ($this->getPageWidth() / 2) - 15) {
                    $this->AddPage();
                }

                $currentColumnWidth = $this->getPageWidth() - 15;
                $this->resetColumns();
                $this->setEqualColumns(1, $currentColumnWidth);
                $resetColumns = true;
            }

            // Defina a cor de fundo para toda a coluna atual
            $this->SetFillColor(210, 221, 233);

            // Adicionar o título da publicação no conteúdo
            $this->SetFont('times', 'B', 9);
            $this->AddLink();
            $this->selectColumn();
            $this->Cell($currentColumnWidth, 7, $content->summary->name, 0, 0, 'C', true);
            $this->writeHTML('<p id="title-' . $content->summary->name . '"></p>', true, false, true, false);
            $this->Ln(5);

            // Remova a cor de fundo antes de desenhar o subtítulo
            $this->SetFillColor(255, 255, 255);

            // Adicionar o subtítulo da publicação no conteúdo
            $this->SetFont('times', 'B', 9);
            $this->AddLink();
            $this->selectColumn();
            $this->Cell($currentColumnWidth, 7, $content->title, 0, 0, 'L', true);
            // $this->writeHTML('<p id="subtitle-' . $content->title . '"></p>', true, false, true, false);
            $this->Ln(7);

            // dd($content->summary->name);
            foreach ($summaryGroup as $group) {
                if ($content->summary->id == $group['id']) {
                    $summary[] = [
                        'title' => $group['name'],
                        'url' => '#title-' . $group['id'],
                        'page' => $this->getPage(),
                        'items' => [
                            [
                                'title' => $content->title,
                                'url' => '#subtitle-' . $content->id,
                                'page' => $this->getPage(),
                            ]
                        ]
                    ];
                }
            }

            // Restaure a fonte padrão antes de adicionar o conteúdo
            $this->SetFont('times', '', 9);

            // Adicionar conteúdo à coluna atual
            $this->selectColumn();
            $this->writeHTML($content->content, true, false, true, false);
            $this->Ln(10);
        }

        $this->setPage(1); // Volte para a primeira página

        $this->resetColumns();
        $this->setEqualColumns(1, $this->getPageWidth() - 15);

        $this->SetY($sumarioY); // Defina a posição Y para onde o sumário será adicionado
        $this->createSummary($summary);

        // Salvar o PDF no armazenamento (storage)
        $fileName = 'diary' . '_' . uniqid() . '.pdf';
        $filePath = 'official-diary/' . $fileName;
        Storage::disk('public')->put($filePath, $this->Output('', 'S'));

        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create(['name' => $fileName, 'url' => $filePath]);
        return $newFile;
    }
}
