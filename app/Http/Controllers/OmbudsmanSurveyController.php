<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\OmbudsmanPage;
use App\Models\OmbudsmanQuestion;
use App\Models\OmbudsmanResponse;
use App\Models\OmbudsmanSurvey;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OmbudsmanSurveyController extends Controller
{
    protected $noteLegend = ['1' => 'Muito insatisfeito', '2' => 'Insatisfeito', '3' => 'Neutro', '4' => 'Satisfeito', '5' => 'Muito satisfeito'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $ombudsman_survey = OmbudsmanSurvey::all();
        return view('panel.transparency.ombudsman.survey.index', compact('ombudsman_survey', 'user'));
    }

    public function page()
    {
        $ombudsman_survey = Page::where('name', 'Pesquisa de Satisfação')->first();
        // dd($ombudsman_survey);
        return view('panel.transparency.ombudsman.survey.page.edit', compact('ombudsman_survey'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'main_title' => 'required',
            'title' => 'required',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'title.required' => 'O campo título é obrigatório'
        ]);

        $ombudsman_survey = Page::where('name', 'Pesquisa de Satisfação')->first();

        if ($ombudsman_survey->update($validateData)) {
            return redirect()->route('ombudsman.survey.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('ombudsman.survey.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cpf' => 'required'
        ], [
            'cpf.required' => 'O campo CPF é obrigatório'
        ]);

        $questions = collect($request->all())->filter(function ($value, $key) {
            return Str::startsWith($key, 'question-');
        });
        if ($questions->count() <= 0) {
            return redirect()->back()->withErrors('Pelo menos uma pergunta deve ser respondida')->withInput();
        }

        $ombudsman_survey = OmbudsmanSurvey::create($validatedData);

        if ($ombudsman_survey) {
            foreach ($questions as $key => $question) {
                $questionId = substr($key, strlen('question-'));
                $ombudsman_survey->responses()->create(['note' => $question, 'legend' => $this->noteLegend[$question], 'ombudsman_question_id' => $questionId]);
            }

            //Generate PDF
            //first get data to graphic
            $graphicData = $this->reportByQuestion();

            //Organize order
            $chartData = $this->prepareChartSurveyOrdered($graphicData);
            $chart = $this->getGraphic($chartData);
            
            // get data to table report
            $tableQuestionsData = $this->reportQuestionsBySurveySatisfaction();

            //Generate pdf
            $this->pdfGenerate($tableQuestionsData, $chart, $chartData);

            return redirect()->route('survey.show')->with('success', 'Pesquisa enviada com sucesso!');
        }
        return redirect()->route('survey.show')->with('error', 'Por favor tente novamente!');

        // Agora, $questions contém apenas os itens cujas chaves começam com "question-"
    }

    /**
     * Display the specified resource.
     */
    public function show(OmbudsmanSurvey $ombudsman_survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmbudsmanSurvey $ombudsman_survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OmbudsmanSurvey $ombudsman_survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OmbudsmanSurvey $ombudsman_survey)
    {
        $ombudsman_survey->responses()->delete();
        if ($ombudsman_survey->delete()) {
            return redirect()->route('ombudsman-survey.index')->with('success', 'Pesquisa apagada com sucesso!');
        }
        return redirect()->route('ombudsman-survey.index')->with('error', 'Por favor tente novamente!');
    }

    //Data to genetate report table
    public function reportQuestionsBySurveySatisfaction()
    {
        $dataByQuestion = OmbudsmanQuestion::with(['responses.survey', 'responses.question'])
            ->select(['id', 'question_text'])
            ->withCount('responses')
            ->get();

        $result = [];

        foreach ($dataByQuestion as $question) {
            // Inicializa o array para contar os níveis de satisfação
            $satisfactionCounts = [
                'Muito insatisfeito' => 0,
                'Insatisfeito' => 0,
                'Neutro' => 0,
                'Satisfeito' => 0,
                'Muito satisfeito' => 0,
            ];

            // Percorre as respostas associadas à pergunta
            foreach ($question->responses as $response) {
                $satisfactionLevel = $response->legend;
                $satisfactionCounts[$satisfactionLevel]++;
            }

            // Adiciona as informações desta pergunta ao resultado final
            $result[] = [
                'question_text' => $question->question_text,
                'satisfaction_counts' => $satisfactionCounts,
            ];
        }

        return $result;
    }

    //Data to generate graphic
    public function reportByQuestion()
    {
        $result = [];

        $dataByResponse = OmbudsmanResponse::with(['survey', 'question'])
            ->select(['legend', DB::raw('count(*) as count')])
            ->groupBy('legend')
            ->get();

        $result = !$dataByResponse->isEmpty() ? $dataByResponse : null;

        return $result;
    }

    //Ordering data graphic
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

    public function getGraphic($chartData)
    {
        $graphicData = [
            "type" => 'bar',
            "data" => [
                "labels" => $chartData['labels'],
                "datasets" => [
                    [
                        "label" => "Resultado da pesquisa",
                        "data" => $chartData['data'],
                        "backgroundColor" => [
                            '#ff2a2a',
                            '#000000',
                            '#ffcf00',
                            '#4cf928',
                            '#2ebb56',
                        ]
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

        return $chart;
    }

    public function pdfGenerate($tableQuestionsData, $chart, $chartData)
    {

        $ombudsmanPage = OmbudsmanPage::first();

        if (!empty($ombudsmanPage->files)) {
            foreach ($ombudsmanPage->files as $pdf) {
                if ($pdf->file->name == 'Relatório de Pesquisa de Satisfação') {
                    Storage::disk('public')->delete($pdf->file->url);
                    $pdf->delete();
                    $pdf->file->delete();
                }
            }
        }

        $html = view('pdf.ombudsman.ombudsmanSuveySatisfaction', compact('chart', 'tableQuestionsData', 'chartData'))->render();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadHTML($html);

        $fileName = 'pdf' . '_' . uniqid() . '.pdf';
        $filePath = 'pdfs/ombudsman/' . $fileName;

        // Salvar o PDF no armazenamento (storage)
        Storage::disk('public')->put($filePath, $pdf->output());
        $dataFile = ['name' => 'Relatório de Pesquisa de Satisfação', 'url' => $filePath];
        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create($dataFile);
        $ombudsmanPage->files()->create(['file_id' => $newFile->id]);

        // Gerar a URL completa para o PDF
        $pdfUrl = asset('storage/' . $filePath);


        return $pdfUrl;
    }
}
