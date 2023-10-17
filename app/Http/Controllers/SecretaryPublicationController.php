<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\OfficialJournal;
use App\Models\Secretary;
use App\Models\SecretaryPublication;
use App\Models\User;
use App\Services\GeneralCrudService;
use App\Services\PdfServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecretaryPublicationController extends Controller
{
    private $crud;
    private $officialDiaryPdf;

    public function __construct(GeneralCrudService $crud, PdfServices $officialDiaryPdf)
    {
        $this->crud = $crud;
        $this->officialDiaryPdf = $officialDiaryPdf;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(OfficialJournal $official_diary)
    {
        $publications = $official_diary->publications;
        return view('panel.official-diary.publications.index', compact('publications', 'official_diary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OfficialJournal $official_diary)
    {
        $summaries = Category::where('slug', 'sumario')->with('children')->first();
        return view('panel.official-diary.publications.create', compact('summaries', 'official_diary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'summary_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'column' => 'nullable',
        ]);
        $validatedData['secretary_id'] = Auth::user()->employee && Auth::user()->employee->responsible ? Auth::user()->employee->responsible->responsibleable->id : null;
        $validatedData['slug'] = Str::slug($request->title);
        if(SecretaryPublication::where('slug', $validatedData['slug'])->exists()){
            $nextId = SecretaryPublication::max('id') + 1;
            $validatedData['slug'] = $validatedData['slug'].'-'.$nextId;
        }

        $official_diary = OfficialJournal::whereDate('created_at', Carbon::today())->first();

        if (empty($official_diary)) {
            $official_diary = OfficialJournal::create(['status' => 'em andamento']);
        }
        $validatedData['diary_id'] = $official_diary->id;

        $publication = SecretaryPublication::create($validatedData);
        if ($publication) {
            $this->officialDiaryPdf->officialDiaryGenerate($official_diary);

            return redirect()->route('publications.index', $official_diary->id)->with('success', 'Diário Oficial finalizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por faovor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SecretaryPublication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficialJournal $official_diary, SecretaryPublication $publication)
    {
        $summaries = Category::where('slug', 'sumario')->with('children')->first();
        return view('panel.official-diary.publications.edit', compact('summaries', 'official_diary', 'publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficialJournal $official_diary, SecretaryPublication $publication)
    {
        $validatedData = $request->validate([
            'summary_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'column' => 'nullable',
        ]);
        $validatedData['secretary_id'] = Auth::user()->employee && Auth::user()->employee->responsible ? Auth::user()->employee->responsible->responsibleable->id : null;

        $official_diary = OfficialJournal::whereDate('created_at', Carbon::today())->first();

        if (empty($official_diary)) {
            $official_diary = OfficialJournal::create(['status' => 'em andamento']);
        }
        $validatedData['diary_id'] = $official_diary->id;

        if ($publication->update($validatedData)) {
            $this->officialDiaryPdf->officialDiaryGenerate($official_diary);

            return redirect()->route('publications.index', $official_diary->id)->with('success', 'Publicação atualizada com sucesso!');
        }
        return redirect()->back()->with('error', 'Por faovor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficialJournal $official_diary, SecretaryPublication $publication)
    {
        $publication->delete();
        $this->officialDiaryPdf->officialDiaryGenerate($official_diary);
        return redirect()->back()->with('success', 'Publicação Excluída com sucesso!');
    }
}
