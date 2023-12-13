<?php

namespace App\Http\Controllers;

use App\Models\OmbudsmanFAQ;
use App\Models\OmbudsmanPage;
use App\Models\OmbudsmanFeedback;
use App\Models\Page;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use App\Models\OmbudsmanQuestion;
use App\Models\OmbudsmanResponse;
use Illuminate\Support\Facades\Storage;

class OmbudsmanPageController extends Controller
{
    protected $pdfNatureName = 'Relatório estatístico de Natureza';
    protected $pdfAdminstrateName = 'Relatório estatístico por unidade administrativa';
    protected $pdfMonthName = 'Relatório estatístico mensal';
    protected $pdfYearName = 'Relatório estatístico Anual';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ombudsman = Page::where('name', 'Ouvidoria')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.ombudsman.page.edit', compact('ombudsman', 'groups'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $ombudsman = Page::where('name', 'Ouvidoria')->first();
        $esicPage = Page::where('name', 'eSIC')->first();

        // code for feedback
        $chartOmbudsmanByTypes = OmbudsmanFeedback::select('nature', DB::raw('count(*) as count'))->groupBy('nature')->get();
        $chartData = [];
        $labels = [];
        $counts = [];

        foreach ($chartOmbudsmanByTypes as $item) {
            $labels[] = ucfirst($item->nature); // Ou use a formatação desejada para os rótulos
            $counts[] = $item->count;
        }

        $chartData['labels'] = $labels;
        $chartData['data'] = $counts;
        // end code for feedback

        $faqs = OmbudsmanFAQ::all();
        
        $dataReport = $this->reportByQuestion();
        $dataGraphic = $dataReport['dataLegend'] ? $this->prepareChartSurveyOrdered($dataReport['dataLegend']->toArray()) : [];

        return view('pages.ombudsman.index', compact('ombudsman', 'chartData', 'faqs', 'dataGraphic', 'esicPage'));
    }

    public function faq()
    {

        $faqs = OmbudsmanFAQ::all();

        return view('pages.ombudsman.faq', compact('faqs'));
    }

    public function reports()
    {
        $chartNature = $this->getDataNatureReport()['graphic'];
        $chartSecretaries = $this->getDataSecretariesReport()['graphic'];
        $chartMonths = $this->getDataMonth()['graphic'];
        $chartYear = $this->getDataYear()['graphic'];

        return view('pages.ombudsman.statistics', compact('chartNature', 'chartSecretaries', 'chartYear', 'chartMonths'));
    }

    public function statisticalReports()
    {
        $reportMonthData = $this->getDataMonth();
        $reportMonth = $reportMonthData['table'];
        $chartMonths = $reportMonthData['graphic'];

        $reportYearData = $this->getDataYear();
        $reportYear = $reportYearData['table'];
        $chartYear = $reportYearData['graphic'];

        $reportNatureData = $this->getDataNatureReport();
        $reportNature = $reportNatureData['table'];
        $chartNature = $reportNatureData['graphic'];

        $reportSecretaryData = $this->getDataSecretariesReport();
        $reportSecretary = $reportSecretaryData['table'];
        $chartSecretary = $reportSecretaryData['graphic'];

        return view('pages.ombudsman.statisticsReports', compact('reportNature', 'chartNature', 'chartSecretary', 'reportSecretary', 'reportMonth', 'chartMonths', 'reportYear', 'chartYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',

        ], [
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'main_title.required' => 'O campo Título principal é obrigatório!',
            'title.required' => 'O campo Título é obrigatório!'
        ]);
        $validatedData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $ombudsman = Page::where('name', 'Ouvidoria')->first();
        if ($ombudsman->update($validatedData)) {
            $ombudsman->groupContents()->delete();
            $ombudsman->groupContents()->create(['transparency_group_id' => $validatedData['transparency_group_id']]);

            return redirect()->route('ombudsman.index')->with('success', 'Página atualizada com sucesso!');
        }

        return redirect()->route('ombudsman.index')->with('error', 'Por favor tente novamente!');
    }

    public function getDataNatureReport()
    {
        $chartOmbudsmanByNature = OmbudsmanFeedback::select('nature', DB::raw('count(*) as count'))->groupBy('nature')->get();
        $reportNature = [];
        $natureData = [];

        $chartNature = [];
        $labels = [];
        $counts = [];

        //Cria o relatório para tabela
        $totalRecords = 0; // Inicializa o total de registros
        foreach ($chartOmbudsmanByNature as $item) {
            $totalRecords += $item->count;
            $natureData[] = [
                'nature' => ucfirst($item->nature),
                'count' => $item->count,
                'percentage' => 0,
            ];

            $labels[] = ucfirst($item->nature);
            $counts[] = $item->count;
        }

        $chartNature['labels'] = $labels;
        $chartNature['data'] = $counts;

        // Calcula as porcentagens e atualiza o array $natureData
        foreach ($natureData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2); // Arredonda para duas casas decimais
        }

        $reportNature['data'] = $natureData;
        $reportNature['total'] = $totalRecords;

        $result['graphic'] = $chartNature;
        $result['table'] = $reportNature;

        return $result;
    }

    public function getDataSecretariesReport()
    {
        $chartOmbudsmanBySecretaries = OmbudsmanFeedback::select('secretary_id', DB::raw('count(*) as count'))
            ->with('secretary') // Carrega a relação secretary
            ->groupBy('secretary_id')
            ->get();

        $reportSecretaries = [];
        $secretaryData = [];

        $chartSecretaries = [];
        $labels = [];
        $counts = [];

        $totalRecords = 0;
        foreach ($chartOmbudsmanBySecretaries as $item) {
            $totalRecords += $item->count;
            $secretaryData[] = [
                'secretary' => ucfirst($item->secretary->name),
                'count' => $item->count,
                'percentage' => 0,
            ];
            $labels[] = $item->secretary->name;
            $counts[] = $item->count;
        }

        $chartSecretaries['labels'] = $labels;
        $chartSecretaries['data'] = $counts;

        // dd($secretaryData);
        foreach ($secretaryData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2); // Arredonda para duas casas decimais
        }

        $reportSecretaries['data'] = $secretaryData;
        $reportSecretaries['total'] = $totalRecords;

        $result['graphic'] = $chartSecretaries;
        $result['table'] = $reportSecretaries;
        return $result;
    }

    public function getDataMonth()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $chartOmbudsmanByMonth = OmbudsmanFeedback::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('count(*) as count')
        )
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $reportMonth = [];
        $monthData = [];

        $chartMonths = [];
        $labels = [];
        $counts = [];

        $totalRecords = 0;
        foreach ($chartOmbudsmanByMonth as $item) {
            $totalRecords += $item->count;

            // Obtém o nome do mês com base no valor numérico do mês
            $monthName = date("F", mktime(0, 0, 0, $item->month, 1));

            $monthData[] = [
                'month' => $monthName,
                'count' => $item->count,
                'percentage' => 0,
            ];

            $labels[] = $monthName;
            $counts[] = $item->count;
        }

        $chartMonths['labels'] = $labels;
        $chartMonths['data'] = $counts;


        foreach ($monthData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2);
        }

        $reportMonth['data'] = $monthData;
        $reportMonth['total'] = $totalRecords;

        $result['graphic'] = $chartMonths;
        $result['table'] = $reportMonth;

        return $result;
    }

    public function getDataYear()
    {
        $chartOmbudsmanByYear = OmbudsmanFeedback::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get();

        $reportYear = [];
        $chartData = [];

        $chartYear = [];
        $labels = [];
        $counts = [];

        $totalRecords = 0;
        foreach ($chartOmbudsmanByYear as $item) {
            $totalRecords += $item->count;

            $chartData[] = [
                'year' => $item->year,
                'count' => $item->count,
                'percentage' => 0,
            ];

            $labels[] = $item->year;
            $counts[] = $item->count;
        }

        $chartYear['labels'] = $labels;
        $chartYear['data'] = $counts;

        foreach ($chartData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2);
        }

        $reportYear['data'] = $chartData;
        $reportYear['total'] = $totalRecords;

        $result['graphic'] = $chartYear;
        $result['table'] = $reportYear;

        return $result;
    }

    public function getGraphicNature($chartData)
    {
        $graphicData = [
            "type" => 'bar',
            "data" => [
                "labels" => $chartData['labels'],
                "datasets" => [
                    [
                        "label" => "Gráfico estatistico de Natureza",
                        "data" => $chartData['data'],
                        "backgroundColor" => ['#27ae60', '#f1c40f', '#e74c3c']
                    ],
                ],
            ],
            "options" => [
                "maintainAspectRatio" => false,
                "plugins" => [
                    "legend" => [
                        "display" => false,
                    ],
                ],
                "scales" => [
                    "y" => [
                        "beginAtZero" => true,
                        "grid" => [
                            "display" => false,
                        ],
                    ],
                    "x" => [
                        "barPercentage" => 0.5,
                    ]
                ],
            ],
        ];

        $graphicData = json_encode($graphicData);
        $chartURL = "https://quickchart.io/chart?height=300&c=" . urlencode($graphicData);

        $graphicData = file_get_contents($chartURL);
        $chart = 'data:image/png;base64, ' . base64_encode($graphicData);

        $title = 'RELATÓRIO ESTATÍSTICO DE NATUREZA';
        $dataFile = [
            'name' => $this->pdfNatureName,
            'description' => 'RELATÓRIO ESTATÍSTICO DE NATUREZA'
        ];

        $result = [
            'title' => $title,
            'chart' => $chart,
            'dataFile' => $dataFile,
        ];

        return $result;
    }

    public function getGraphicSecretary($chartData)
    {
        $graphicData = [
            "type" => 'bar',
            "data" => [
                "labels" => $chartData['labels'],
                "datasets" => [
                    [
                        "label" => "Gráfico estatístico por Secretaria",
                        "data" => $chartData['data'],
                        "backgroundColor" => ['#27ae60', '#f1c40f', '#e74c3c']
                    ],
                ],
            ],
            "options" => [
                "maintainAspectRatio" => false,
                "plugins" => [
                    "legend" => [
                        "display" => false,
                    ],
                ],
                "scales" => [
                    "y" => [
                        "beginAtZero" => true,
                        "grid" => [
                            "display" => false,
                        ],
                    ],
                    "x" => [
                        "barPercentage" => 0.5,
                    ]
                ],
            ],
        ];

        $graphicData = json_encode($graphicData);
        $chartURL = "https://quickchart.io/chart?height=300&c=" . urlencode($graphicData);

        $graphicData = file_get_contents($chartURL);
        $chart = 'data:image/png;base64, ' . base64_encode($graphicData);

        $title = 'RELATÓRIO ESTATÍSTICO DE NATUREZA';
        $dataFile = [
            'name' => $this->pdfAdminstrateName,
            'description' => 'RELATÓRIO ESTATÍSTICO DE NATUREZA'
        ];

        $result = [
            'title' => $title,
            'chart' => $chart,
            'dataFile' => $dataFile,
        ];

        return $result;
    }

    public function getGraphicMonth($chartData)
    {
        $graphicData = [
            "type" => 'line',
            "data" => [
                "labels" => $chartData['labels'],
                "datasets" => [
                    [
                        "label" => "Quantidade de manifestação",
                        "data" => $chartData['data'],
                        "backgroundColor" => ['#27ae60', '#f1c40f', '#e74c3c']
                    ],
                ],
            ],
        ];

        $graphicData = json_encode($graphicData);
        $chartURL = "https://quickchart.io/chart?height=300&c=" . urlencode($graphicData);

        $graphicData = file_get_contents($chartURL);
        $chart = 'data:image/png;base64, ' . base64_encode($graphicData);

        $title = 'Gráfico estatístico mensal';
        $dataFile = [
            'name' => $this->pdfMonthName,
            'description' => 'Gráfico estatístico mensal'
        ];

        $result = [
            'title' => $title,
            'chart' => $chart,
            'dataFile' => $dataFile,
        ];

        return $result;
    }

    public function getGraphicYear($chartData)
    {
        $graphicData = [
            "type" => 'line',
            "data" => [
                "labels" => $chartData['labels'],
                "datasets" => [
                    [
                        "label" => "Quantidade de manifestação",
                        "data" => $chartData['data'],
                        "backgroundColor" => ['#27ae60', '#f1c40f', '#e74c3c']
                    ],
                ],
            ],
        ];

        $graphicData = json_encode($graphicData);
        $chartURL = "https://quickchart.io/chart?height=300&c=" . urlencode($graphicData);

        $graphicData = file_get_contents($chartURL);
        $chart = 'data:image/png;base64, ' . base64_encode($graphicData);

        $title = 'Gráfico estatístico anual';
        $dataFile = [
            'name' => $this->pdfYearName,
            'description' => 'Gráfico estatístico anual'
        ];

        $result = [
            'title' => $title,
            'chart' => $chart,
            'dataFile' => $dataFile,
        ];

        return $result;
    }

    public function showPDF($name)
    {

        if ($name == 'nature') {
            $reportNatureData = $this->getDataNatureReport();
            $reportNature = $reportNatureData['table'];
            $chartNature = $reportNatureData['graphic'];

            $pdf = $this->pdfGenerate('nature', $reportNature, $chartNature, $this->pdfNatureName);
        }

        if ($name == 'secretary') {

            $reportSecretaryData = $this->getDataSecretariesReport();
            $reportSecretary = $reportSecretaryData['table'];
            $chartSecretary = $reportSecretaryData['graphic'];

            $pdf = $this->pdfGenerate('secretary', $reportSecretary, $chartSecretary, $this->pdfAdminstrateName);
        }

        if ($name == 'month') {

            $reportMonthData = $this->getDataMonth();
            $reportMonth = $reportMonthData['table'];
            $chartMonth = $reportMonthData['graphic'];

            $pdf = $this->pdfGenerate('month', $reportMonth, $chartMonth, $this->pdfMonthName);
        }

        if ($name == 'year') {

            $reportYearData = $this->getDataYear();
            $reportYear = $reportYearData['table'];
            $chartYear = $reportYearData['graphic'];

            $pdf = $this->pdfGenerate('year', $reportYear, $chartYear, $this->pdfYearName);
        }

        return $pdf;
    }

    public function pdfGenerate($type, $tableData, $chartData, $currentFileName)
    {
        $ombudsmanPage = OmbudsmanPage::first();
        
        if ($ombudsmanPage) {
            $oldFile = $ombudsmanPage->files()
                ->whereHas('file', function ($query) use ($currentFileName) {
                    $query->where('name', $currentFileName);
                })
                ->first();

            if ($oldFile) {
                Storage::disk('public')->delete($oldFile->file->url);
                $oldFile->delete();
                $oldFile->file->delete();
            }
        }

        if ($type == 'nature') {

            $graphicData = $this->getGraphicNature($chartData);
            $chart = $graphicData['chart'];
            $title = $graphicData['title'];
            $dataFile = $graphicData['dataFile'];
        }

        if ($type == 'secretary') {

            $graphicData = $this->getGraphicSecretary($chartData);
            $chart = $graphicData['chart'];
            $title = $graphicData['title'];
            $dataFile = $graphicData['dataFile'];
        }

        if ($type == 'month') {

            $graphicData = $this->getGraphicMonth($chartData);
            $chart = $graphicData['chart'];
            $title = $graphicData['title'];
            $dataFile = $graphicData['dataFile'];
        }

        if ($type == 'year') {

            $graphicData = $this->getGraphicYear($chartData);
            $chart = $graphicData['chart'];
            $title = $graphicData['title'];
            $dataFile = $graphicData['dataFile'];
        }
        // dd('pare antes de gerar');

        $html = view('pdf.ombudsman.typologyStatisticalReport', compact('type', 'title', 'chart', 'tableData'))->render();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadHTML($html);

        $fileName = 'pdf' . '_' . uniqid() . '.pdf';
        $filePath = 'pdfs/ombudsman/' . $fileName;

        // Salvar o PDF no armazenamento (storage)
        Storage::disk('public')->put($filePath, $pdf->output());
        $dataFile['url'] = $filePath;
        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create($dataFile);
        $ombudsmanPage->files()->create(['file_id' => $newFile->id]);

        // Gerar a URL completa para o PDF
        $pdfUrl = asset('storage/' . $filePath);


        return $pdfUrl;
    }
    
    public function reportByQuestion()
    {
        $result = [];

        $dataByResponse = OmbudsmanResponse::with(['survey', 'question'])
            ->select(['legend', DB::raw('count(*) as count')])
            ->groupBy('legend')
            ->get();

        $dataByQuestion = OmbudsmanQuestion::with(['responses.survey', 'responses.question'])
            ->select(['id', 'question_text']) // Seleciona o ID da pergunta e o texto da pergunta
            ->withCount('responses') // Adiciona a contagem de respostas como um atributo "responses_count"
            ->get();

        $result['dataLegend'] = !$dataByResponse->isEmpty() ? $dataByResponse : null;
        $result['dataQuestions'] = !$dataByQuestion->isEmpty() ? $dataByQuestion : null;

        return $result;
    }
    
    public function prepareChartSurveyOrdered($data)
    {
        $order = [
            'Muito insatisfeito',
            'Insatisfeito',
            'Neutro',
            'Satisfeito',
            'Muito satisfeito',
        ];

        // Crie um array para mapear a posição das legendas na ordem especificada
        $labelPositions = array_flip($order);

        $labels = [];
        $counts = [];

        // Criar arrays temporários para ordenação
        $tempLabels = [];
        $tempCounts = [];

        foreach ($data as $item) {
            $tempLabels[] = $item['legend'];
            $tempCounts[] = $item['count'];
        }

        // Ordenar os labels e os counts de acordo com a ordem especificada
        array_multisort(array_map(function ($label) use ($labelPositions) {
            return $labelPositions[$label];
        }, $tempLabels), SORT_ASC, $tempLabels, $tempCounts);

        $result['labels'] = $tempLabels;
        $result['data'] = $tempCounts;

        return $result;
    }

}
