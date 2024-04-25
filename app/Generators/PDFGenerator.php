<?php
// app/PDFGenerator.php

namespace App\Generators;

use App\Models\File;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;
use TCPDF;



class PDFGenerator extends TCPDF
{
    protected $headerData;
    protected $footerData;
    protected $currentDate;
    protected $showHeaderOnLastPage = true;


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

        if ($this->getPage() == $this->getNumPages() && !$this->showHeaderOnLastPage) {
            return; // Não renderizar o cabeçalho na última página
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
        // Array associativo para mapear os dias da semana para seus equivalentes em português
        $diasSemana = array(
            'Sunday' => 'DOMINGO',
            'Monday' => 'SEGUNDA',
            'Tuesday' => 'TERÇA',
            'Wednesday' => 'QUARTA',
            'Thursday' => 'QUINTA',
            'Friday' => 'SEXTA',
            'Saturday' => 'SÁBADO'
        );

        // Array associativo para mapear os números dos meses para seus equivalentes em português
        $meses = array(
            1 => 'JANEIRO',
            2 => 'FEVEREIRO',
            3 => 'MARÇO',
            4 => 'ABRIL',
            5 => 'MAIO',
            6 => 'JUNHO',
            7 => 'JULHO',
            8 => 'AGOSTO',
            9 => 'SETEMBRO',
            10 => 'OUTUBRO',
            11 => 'NOVEMBRO',
            12 => 'DEZEMBRO'
        );

        // Crie um objeto DateTime representando a data atual
        $dataAtual = new DateTime();

        // Obtenha o dia da semana, o dia, o mês e o ano
        $diaSemana = $diasSemana[$dataAtual->format('l')]; // Obtém o dia da semana traduzido
        $dia = $dataAtual->format('d');
        $numeroMes = (int) $dataAtual->format('n');
        $mes = $meses[$numeroMes]; // Obtém o nome do mês traduzido
        $ano = $dataAtual->format('Y');

        // Crie a string com a data formatada
        $dataFormatada = $diaSemana . ', ' . $dia . ' de ' . $mes . ' de ' . $ano;

        // Largura da célula para cada coluna
        $col1Width = $this->GetStringWidth($dataFormatada);
        $col2Width = $this->GetStringWidth('Ano VII | Edição nº 285 ISSN: XXXX-XXXX');
        $col3Width = $this->GetStringWidth('Página ' . $pageNumber . ' de ' . $totalPages);

        // Ajusta a posição das três colunas para cima
        // $this->SetY($this->GetY() - 5); // Ajuste o valor conforme necessário
        $this->Ln(-7);
        // Coluna 1 (à esquerda)
        $this->Cell($col1Width, $cellHeight, $dataFormatada, 0, false, 'L', 0, '', 0, false, 'M', 'M');

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

    protected $secondColumnX;
    protected $summaryPosition;
    protected $summaryColumnWidth;
    protected $rectHeight;

    protected function createSummary($summary, $officeHour)
    {
        // Defina a largura e altura da página
        $pageWidth = $this->GetPageWidth() - 20;
        $pageHeight = $this->GetPageHeight() - 10;

        // Defina a largura da coluna do sumário (metade da largura da página)
        $summaryColumnWidth = ($pageWidth - 20) / 2; // Subtraímos 20 para criar um espaço entre as colunas

        // Variável para armazenar a posição inicial do sumário
        $summaryPosition = $this->GetY();

        // Primeira coluna: Sumário
        $this->SetFont('times', 'B', 9);
        $this->SetFillColor(210, 221, 233); // Defina a cor de fundo para o sumário

        // Calcule a altura do retângulo que ficará por baixo do sumário
        $footerPosition = $pageHeight - $this->getFooterMargin();
        $rectHeight = $footerPosition - $summaryPosition;

        // Desenhe o retângulo por baixo do sumário
        $this->Rect(10, $summaryPosition, $summaryColumnWidth, $rectHeight, 'F');

        // Escrever o título do Sumário (usando a largura da coluna do sumário)
        $this->Cell($summaryColumnWidth - 10, 10, 'Sumário', 0, 1, 'C', true, '');
        $this->Ln(2); // Espaço adicional

        $columnHeight = 0; // Altura da coluna atual
        foreach ($summary as $item) {
            // Definir a altura das células
            $cellHeight = 6; // Altere este valor para ajustar o espaço entre os itens

            $this->SetFont('times', 'B', 9); // Definir a fonte do título
            // Calcular os pontos necessários para preencher o espaço no sumário para o título
            $dotsTitle = str_repeat('.', $summaryColumnWidth - $this->GetStringWidth($item['title']) - 10);
            // Escrever o título do Sumário no sumário
            $this->Cell($summaryColumnWidth - 20, $cellHeight, '          ' . $item['title'] . ' ' . $dotsTitle . ' ' . $item['page'], 0, 1, 'L', true, $item['url']);

            $columnHeight += $cellHeight; // Adicionar a altura do título
            foreach ($item['items'] as $subItem) {
                // Definir a fonte do subtítulo igual à fonte do título
                $this->SetFont('times', 'B', 9); // Remover o negrito para o subtítulo
                // Calcular os pontos necessários para preencher o espaço no sumário para o subtítulo
                $dotsSubTitle = str_repeat('.', $summaryColumnWidth - $this->GetStringWidth($subItem['title']) - 10);
                // Escrever o subtítulo no sumário
                $this->Cell($summaryColumnWidth - 20, $cellHeight, '          ' . $subItem['title'] . ' ' . $dotsSubTitle . ' ' . $subItem['page'], 0, 1, 'L', true, $subItem['url']);
                $columnHeight += $cellHeight; // Adicionar a altura do subtítulo
            }

        }
    
        // Ajusta a posição Y para centralizar verticalmente
        $this->SetY($summaryPosition + ($rectHeight - $columnHeight) / 2); 

        // Calcula a posição X inicial da segunda coluna
        $secondColumnX = $summaryColumnWidth + 30; // Margem esquerda + largura da primeira coluna + espaço entre as colunas

        // Chama o método para gerar a segunda coluna
        $this->secondColumnX = $summaryColumnWidth + 30; // Margem esquerda + largura da primeira coluna + espaço entre as colunas
        $this->summaryPosition = $summaryPosition;
        $this->summaryColumnWidth = $summaryColumnWidth;
        $this->rectHeight = $rectHeight;
    }

    protected function generateSecondColumn($officeHour, $councilors, $sistem)
    {
        // Defina a cor de fundo para a segunda coluna
        $this->SetFillColor(210, 221, 233);
        // Desenhe o retângulo por baixo da segunda coluna
        $this->Rect($this->secondColumnX, $this->summaryPosition, $this->summaryColumnWidth, $this->rectHeight, 'F');
        
        // Defina a posição Y inicial da segunda coluna
        $secondColumnY = $this->summaryPosition + 5; // Adicione um pequeno recuo
    
        // Verifique se $officeHour está definido e não é nulo
        if (isset($officeHour)) {
            $this->SetFont('times', 'B', 12);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->Cell($this->summaryColumnWidth - 10, 5, 'EXPEDIENTE', 0, 1, 'C');
            $secondColumnY += $this->getFontSize() + 2; // Adicione 2 de espaço após o título
        
            // Adicione o texto do office hour
            $expedient = $officeHour->expedient."\n"; // Usando aspas duplas para interpretar \n como quebra de linha
            $this->SetFont('times', '', 9);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->MultiCell($this->summaryColumnWidth - 10, 5, $expedient, 0, 'J', false);
            $secondColumnY += $this->getStringHeight($this->summaryColumnWidth - 10, $expedient) + 10; // Adicione 10 de espaço após o texto

            
            $this->SetFont('times', 'B', 12);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->Cell($this->summaryColumnWidth - 10, 5, 'ACERVO', 0, 1, 'C');
            $secondColumnY += $this->getFontSize() + 2; // Adicione 2 de espaço após o título
        
            // Adicione o texto do office hour
            $information = $officeHour->information."\n";
            $this->SetFont('times', '', 9);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->MultiCell($this->summaryColumnWidth - 10, 5, $information, 0, 'J', false);
            $secondColumnY += $this->getStringHeight($this->summaryColumnWidth - 10, $information) + 10; // Adicione 10 de espaço após o texto
            
            // Pule uma linha antes de adicionar o próximo bloco de texto
            $secondColumnY += 5;
            
            // Adicione o título ENTIDADE
            $this->SetFont('times', 'B', 12);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->Cell($this->summaryColumnWidth - 10, 5, 'ENTIDADE', 0, 1, 'C');
            $secondColumnY += $this->getFontSize() + 2; // Adicione 2 de espaço após o título
            
            // Adicione os dados da entidade na segunda coluna
            $entityData = array(
                $officeHour->entity_name,
                $officeHour->entity_address,
                'CNPJ: ' . $officeHour->entity_cnpj,
                $sistem['address'] . ', ' . $sistem['number'] . ', ' . $sistem['neighborhood'],
                'Telefone: ' . $officeHour->entity_phone,
                'Site: ' . $officeHour->site,
                'Diário: ' . $officeHour->url_diario
            );
            foreach ($entityData as $data) {
                $this->SetFont('times', '', 9);
                $this->SetX($this->secondColumnX + 5);
                $this->MultiCell($this->summaryColumnWidth - 10, 5, $data, 0, 'L', false);
                $secondColumnY += $this->getStringHeight($this->summaryColumnWidth - 10, $data) + 2; // Adicione 2 de espaço após cada linha
            }
        }
    
        // Verifique se $councilors está definido e não é nulo
        // dd($councilors);
        if (isset($councilors) && $councilors) {
            // Adicione o título MESA Diretora
            $this->SetFont('times', 'B', 12);
            $this->SetXY($this->secondColumnX + 5, $secondColumnY);
            $this->Cell($this->summaryColumnWidth - 10, 5, 'MESA DIRETORA', 0, 1, 'C');
            $secondColumnY += $this->getFontSize() + 2; // Adicione 2 de espaço após o título
        
            // Adicione os dados dos conselheiros
            foreach ($councilors as $councilor) {
                $councilorData = array();
                $legislatureRelation = isset($councilor->legislatureRelations[0]) ? $councilor->legislatureRelations[0] : null;
                if ($legislatureRelation) {
                    $officeName = isset($legislatureRelation->office->office) ? $legislatureRelation->office->office : '';
                    $partyName = isset($councilor->partyAffiliation->name) ? $councilor->partyAffiliation->name : '';
                    $councilorData[] = $officeName . ' ' . $councilor['name'] . ' ' . $councilor['surname'] . ' - ' . $partyName;
                }
                
                foreach ($councilorData as $data) {
                    $this->SetFont('times', '', 10);
                    $this->SetX($this->secondColumnX + 5);
                    $this->MultiCell($this->summaryColumnWidth - 10, 5, $data, 0, 'L', false);
                    $secondColumnY += $this->getStringHeight($this->summaryColumnWidth - 10, $data) + 2; // Adicione 2 de espaço após cada linha
                }
                // Adicione espaço extra após cada conselheiro
                $secondColumnY += 5; // Ajuste conforme necessário
            }
            
            
        }
    }
    
    protected function addLastPage($sistem)
    {
        $this->AddPage('P', 'A4');
        
        if (empty($this->headerData)) {
            return;
        }

        $pageNumber = $this->getAliasNumPage();
        $totalPages = $this->getAliasNbPages();
        // Define a cor de preenchimento do retângulo como azul
        $this->SetFillColor(210, 221, 233);

        // Define as coordenadas e dimensões do retângulo
        $boxWidth = $this->GetPageWidth();
        $boxHeight = 10;
        $boxX = 0;
        $boxY = 10;

        // Desenha o retângulo azul
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight, 'F');

        // Array associativo para mapear os dias da semana para seus equivalentes em português
        $diasSemana = array(
            'Sunday' => 'DOMINGO',
            'Monday' => 'SEGUNDA',
            'Tuesday' => 'TERÇA',
            'Wednesday' => 'QUARTA',
            'Thursday' => 'QUINTA',
            'Friday' => 'SEXTA',
            'Saturday' => 'SÁBADO'
        );

        // Array associativo para mapear os números dos meses para seus equivalentes em português
        $meses = array(
            1 => 'JANEIRO',
            2 => 'FEVEREIRO',
            3 => 'MARÇO',
            4 => 'ABRIL',
            5 => 'MAIO',
            6 => 'JUNHO',
            7 => 'JULHO',
            8 => 'AGOSTO',
            9 => 'SETEMBRO',
            10 => 'OUTUBRO',
            11 => 'NOVEMBRO',
            12 => 'DEZEMBRO'
        );

        // Crie um objeto DateTime representando a data atual
        $dataAtual = new DateTime();

        // Obtenha o dia da semana, o dia, o mês e o ano
        $diaSemana = $diasSemana[$dataAtual->format('l')]; // Obtém o dia da semana traduzido
        $dia = $dataAtual->format('d');
        $numeroMes = (int) $dataAtual->format('n');
        $mes = $meses[$numeroMes]; // Obtém o nome do mês traduzido
        $ano = $dataAtual->format('Y');

        // Crie a string com a data formatada
        $dataFormatada = $diaSemana . ', ' . $dia . ' de ' . $mes . ' de ' . $ano. ' | '.'ANO VII | Nº 1';
        $col1Text = 'CIDELÂNDIA';
        $col2Text = $dataFormatada;

        $col3Text = 'Página ' . $pageNumber . ' de ' . $totalPages;

        // Define as larguras de cada texto
        $col1Width = $this->GetStringWidth($col1Text);
        $col2Width = $this->GetStringWidth($col2Text);
        $col3Width = $this->GetStringWidth($col3Text);

        // Calcula a posição X para centralizar o texto horizontalmente
        $textX = $boxX + ($boxWidth - ($col1Width + $col2Width + $col3Width + 40)) / 2;

        // Define a posição Y para centralizar o texto verticalmente
        $textY = $boxY + ($boxHeight - 5) / 2;

        // Adiciona os textos centralizados dentro do retângulo
        $this->SetFont('times', '', 12);
        $this->SetTextColor(0, 0, 0); // Cor do texto (preto)
        $this->SetXY($textX, $textY);
        $this->Cell($col1Width + $col2Width + $col3Width + 40, 5, $col1Text . ', ' . $col2Text . ' | ' . $col3Text, 0, 0, 'C');

        // Carrega a imagem do logo
        $logoImage = $this->headerData['logoPath'];
        $logoWidth = 50;
        $logoHeight = 50;
        
        // Exibe o logo do cabeçalho
        $logoX = ($this->GetPageWidth() - $logoWidth) / 2;
        $logoY = 10;
        $this->Image($logoImage, $logoX, $logoY, $logoWidth, $logoHeight, 'PNG', '', 'T');
        
        // Adicione o título DIÁRIO OFICIAL
        $this->SetFont('times', 'B', 35);
        $title = 'DIÁRIO OFICIAL';
        $titleWidth = $this->GetStringWidth($title);
        $titleX = ($this->GetPageWidth() - $titleWidth) / 2; // Centraliza o texto horizontalmente
        $titleY = $logoY + $logoHeight + 10;
        $this->Text($titleX, $titleY, $title);
        
        // Adicione o texto "MUNICIPIO DE CIDELÂNDIA" e suas informações
        $this->SetFont('times', '', 12);
        $municipioText = "MUNICIPIO DE CIDELÂNDIA";
        $municipioWidth = $this->GetStringWidth($municipioText);
        $municipioX = ($this->GetPageWidth() - $municipioWidth) / 2; // Centraliza o texto horizontalmente
        $municipioY = $titleY + 30;
        $this->Text($municipioX, $municipioY, $municipioText);
        
        // Adicione o texto "Conforme Lei nº 005, de 25 de AGOSTO de 2023" centralizado
        $leiText = "Conforme Lei nº 005, de 25 de AGOSTO de 2023";
        $leiWidth = $this->GetStringWidth($leiText);
        $leiX = ($this->GetPageWidth() - $leiWidth) / 2; // Centraliza o texto horizontalmente
        $leiY = $municipioY + 15;
        $this->Text($leiX, $leiY, $leiText);
        
        // Adicione as informações do sistema
        $infoX = 10;
        $infoY = $leiY + 15; // Espaçamento entre o texto da lei e as informações do sistema
        
        // Adicione as informações do sistema centralizadas
        if($sistem){
            $this->SetXY($infoX, $infoY);
            $this->MultiCell(0, 5, $sistem['system_name'], 0, 'C');
            $this->SetX($infoX);
            $this->MultiCell(0, 5, 'CNPJ: ' . $sistem['cnpj'], 0, 'C');
            $this->SetX($infoX);
            $this->MultiCell(0, 5, 'Endereço: ' . $sistem['address'] . ', ' . $sistem['number'] . ', ' . $sistem['neighborhood'], 0, 'C');
            $this->SetX($infoX);
            $this->MultiCell(0, 5, 'Telefone: ' . $sistem['phone'], 0, 'C');
        }
    }
    
    public function generate($official_diary, $headerData, $footerData, $summaryGroup, $officeHour, $councilors, $sistem)
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
        $this->showHeaderOnLastPage = false;

        $this->addLastPage($sistem);

        $this->setPage(1); // Volte para a primeira página

        $this->resetColumns();
        $this->setEqualColumns(1, $this->getPageWidth() - 15);

        $this->SetY($sumarioY); // Defina a posição Y para onde o sumário será adicionado
        $this->createSummary($summary, $officeHour);
        $this->generateSecondColumn($officeHour, $councilors, $sistem);

        // Salvar o PDF no armazenamento (storage)
        $fileName = 'diary' . '_' . uniqid() . '.pdf';
        $filePath = 'official-diary/' . $fileName;
        Storage::disk('public')->put($filePath, $this->Output('', 'S'));

        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create(['name' => $fileName, 'url' => $filePath]);
        return $newFile;
    }
}
