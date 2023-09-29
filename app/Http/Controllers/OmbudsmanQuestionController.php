<?php

namespace App\Http\Controllers;

use App\Models\OmbudsmanPage;
use App\Models\OmbudsmanQuestion;
use App\Models\OmbudsmanResponse;
use App\Models\OmbudsmanSurvey;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OmbudsmanQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $ombudsman_survey_question = OmbudsmanQuestion::all();
        return view('panel.transparency.ombudsman.survey.questions.index', compact('ombudsman_survey_question', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.transparency.ombudsman.survey.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_text' => 'required'
        ]);

        $ombudsman_survey_question = OmbudsmanQuestion::create($validatedData);
        if ($ombudsman_survey_question) {
            return redirect()->route('ombudsman-survey-questions.index')->with('success', 'Pergunta Cadastrada com sucesso!');
        }
        return redirect()->route('ombudsman-survey-questions.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $dataReport = $this->reportByQuestion();
        $dataGraphic = $dataReport['dataLegend'] ? $this->prepareChartSurveyOrdered($dataReport['dataLegend']->toArray()) : [];

        $ombudsman_survey_question = OmbudsmanQuestion::all();
        $page = Page::where('name', 'Pesquisa de Satisfação')->first();
        
        //Get PDF Report
        $ombudsmanPage = OmbudsmanPage::first();
        $pdfUrl = null;

        if (!empty($ombudsmanPage->files)) {
            foreach ($ombudsmanPage->files as $pdf) {
                if ($pdf->file->name == 'Relatório de Pesquisa de Satisfação') {
                    $pdfUrl = $pdf->file->url;
                    break;
                }
            }
        }

        return view('pages.ombudsman.survey', compact('ombudsman_survey_question', 'page', 'dataGraphic', 'pdfUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OmbudsmanQuestion $ombudsman_survey_question)
    {
        return view('panel.transparency.ombudsman.survey.questions.edit', compact('ombudsman_survey_question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OmbudsmanQuestion $ombudsman_survey_question)
    {
        $validatedData = $request->validate([
            'question_text' => 'required'
        ]);

        if ($ombudsman_survey_question->update($validatedData)) {
            return redirect()->route('ombudsman-survey-questions.index')->with('success', 'Pergunta Atualizada com sucesso!');
        }
        return redirect()->route('ombudsman-survey-questions.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OmbudsmanQuestion $ombudsman_survey_question)
    {
        if ($ombudsman_survey_question->delete()) {
            return redirect()->route('ombudsman-survey-questions.index')->with('success', 'Pergunta Apagada com sucesso!');
        }
        return redirect()->route('ombudsman-survey-questions.index')->with('error', 'Por favor tente novamente!');
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


    public function prepareChartData($data)
    {
        $labels = [];
        $counts = [];

        foreach ($data as $item) {
            $labels[] = $item['legend'];
            $counts[] = $item['count'];
        }
        $result['labels'] = $labels;
        $result['data'] = $counts;

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
