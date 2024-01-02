<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Secretary;
use App\Models\Sic;
use App\Models\SicFaq;
use App\Models\SicSituation;
use App\Models\SicSolicitation;
use App\Models\TransparencyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $esicPage = Page::where('name', 'eSIC')->first();
        $sic = Sic::first();
        $groups = TransparencyGroup::all();

        return view('panel.sic.page.edit', compact('sic', 'esicPage', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $esicPage = Page::where('name', 'eSIC')->first();
        $sic = Sic::first();
        return view('pages.sic.index', compact('sic', 'esicPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $validatedSic = $request->validate(
            [
                'manager' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'cep' => 'nullable',
                'street' => 'nullable',
                'number' => 'nullable',
                'complement' => 'nullable',
                'neighborhood' => 'nullable',
                'opening_hours' => 'nullable',
            ],
            [
                'manager.required' => 'O campo Gestor é obrigatório',
                'phone.required' => 'O campo Telefone é obrigatório',
                'email.required' => 'O campo E-mail é obrigatório',
            ]
        );

        $validatedESicPage = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
            'description' => 'nullable',
            'visibility' => 'nullable',
        ], [
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'main_title.required' => 'O campo Título principal é obrigatório!',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo Título é obrigatório!'
        ]);

        $esicPage = Page::where('name', 'eSIC')->first();
        if (!$esicPage->update($validatedESicPage)) {
            return redirect()->route('esic.index')->with('error', 'Por favor tente novamente!');
        }
        
        $esicPage->groupContents()->delete();
        $esicPage->groupContents()->create(['transparency_group_id' => $validatedESicPage['transparency_group_id']]);

        $sic = Sic::first();
        if ($sic) {
            $sic->update($validatedSic);
        } else {
            $sic = Sic::create($validatedSic);
        }
        if ($sic) {
            return redirect()->route('esic.index')->with('success', 'Página atualizada com sucesso!');
        }

        return redirect()->route('esic.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sic $sic)
    {
        //
    }

    public function login()
    {
        return view('pages.sic.panel.login');
    }

    public function register()
    {
        return view('pages.sic.panel.register');
    }

    public function profile()
    {
        $user = Auth::guard('sic')->user();
        return view('pages.sic.panel.profile', compact('user'));
    }

    public function panel()
    {
        return view('pages.sic.panel.panel');
    }

    public function solicitations()
    {
        return view('pages.sic.panel.solicitations.index');
    }

    public function solicitationCreate()
    {
        $secretaries = Secretary::all();
        return view('pages.sic.panel.solicitations.create', compact('secretaries'));
    }

    public function solicitationEdit()
    {
        return view('pages.sic.panel.solicitations.edit');
    }

    public function reportsByYear()
    {
        // Alteração na consulta para agrupar por ano
        $chartSicSolicitationByYear = SicSituation::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get();

        $reportSicSolicitation = [];
        $yearData = [];

        $chartYears = [];
        $labels = [];
        $counts = [];

        // Cria o relatório para tabela
        $totalRecords = 0; // Inicializa o total de registros
        foreach ($chartSicSolicitationByYear as $item) {
            $totalRecords += $item->count;
            $yearData[] = [
                'year' => $item->year,
                'count' => $item->count,
                'percentage' => 0,
            ];

            $labels[] = $item->year;
            $counts[] = $item->count;
        }

        $chartYears['labels'] = $labels;
        $chartYears['data'] = $counts;

        // Calcula as porcentagens e atualiza o array $yearData
        foreach ($yearData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2); // Arredonda para duas casas decimais
        }

        $reportSicSolicitation['data'] = $yearData;
        $reportSicSolicitation['total'] = $totalRecords;

        $result['graphic'] = $chartYears;
        $result['table'] = $reportSicSolicitation;

        $sicYears = $result['graphic'];
        // dd($sicYears);
        return $result;
    }


    public function situationGraphic()
    {

        $chartSicSolicitationBySituation = SicSituation::select('situation', DB::raw('count(*) as count'))->groupBy('situation')->get();
        $reportSicSolicitation = [];
        $situationData = [];
    
        $chartSituation = [];
        $labels = [];
        $counts = [];
    
        // Cria o relatório para tabela
        $totalRecords = 0; // Inicializa o total de registros
        foreach ($chartSicSolicitationBySituation as $item) {
            $totalRecords += $item->count;
            $situationData[] = [
                'situation' => ucfirst($item->situation),
                'count' => $item->count,
                'percentage' => 0,
            ];
    
            $labels[] = ucfirst($item->situation);
            $counts[] = $item->count;
        }
    
        $chartSituation['labels'] = $labels;
        $chartSituation['data'] = $counts;
    
        // Calcula as porcentagens e atualiza o array $situationData
        foreach ($situationData as &$item) {
            $percentage = ($item['count'] / $totalRecords) * 100;
            $item['percentage'] = round($percentage, 2); // Arredonda para duas casas decimais
        }
    
        $reportSicSolicitation['data'] = $situationData;
        $reportSicSolicitation['total'] = $totalRecords;
    
        $result['graphic'] = $chartSituation;
        $result['table'] = $reportSicSolicitation;
    
        return $result;
        
    }
    
    public function reports(){
        $dataReport = $this->reportsByYear()['graphic'];
        $sicSituation = $this->situationGraphic()['graphic'];
        return view('pages.sic.panel.statistics', compact('sicSituation', 'dataReport'));

    }

    public function statisticalReports()
    {
        $reportData = $this->reportsByYear();
        $graphicReport = $reportData['graphic'];
        $tableReport = $reportData['table'];

        $sicSituation = $this->situationGraphic();
        $sicSituationGraphic = $sicSituation['graphic'];
        $sicSituationTable = $sicSituation['table'];

        return view('pages.sic.statisticsReports', compact('reportData', 'graphicReport', 'tableReport', 'sicSituation', 'sicSituationGraphic', 'sicSituationTable'));
    }

    public function faq()
    {
        $faqs = SicFaq::all();
        return view('pages.sic.faq', compact('faqs'));
    }

    public function search(Request $request)
    {
        $query = SicSolicitation::query();

        $search = $request->get('search');

        if($request->filled('protocol')){
            $query->where('protocol', 'LIKE', '%' . $request->input('protocol') . '%')
            ->orWhere('solicitation', 'LIKE', '%' . $request->input('protocol') . '%');
        }

        if($request->filled('solicitation')){
            $query->where('solicitation', 'LIKE', '%' . $request->input('solicitation') . '%');
        }

        $solicitations = $query->with('situations')->paginate(10);
        $searchData = $request->only(['protocol', 'exercicy']);

        return view('pages.sic.search', compact('solicitations', 'searchData'));
    }
}
