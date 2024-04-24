<?php

namespace App\Http\Controllers;

use App\Models\ConfigureOfficialDiary;
use App\Models\File;
use App\Models\OfficialJournal;
use App\Services\FileUploadService;
use App\Services\PdfServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConfigureOfficialDiaryController extends Controller
{
    private $fileUploadService;
    private $officialDiaryPdf;

    public function __construct(FileUploadService $fileUploadService, PdfServices $officialDiaryPdf)
    {
        $this->fileUploadService = $fileUploadService;
        $this->officialDiaryPdf = $officialDiaryPdf;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configureOfficialDiary = ConfigureOfficialDiary::first();
        if ($configureOfficialDiary) {
            return view('panel.official-diary.configurations.edit', ['configure' => $configureOfficialDiary]);
        }
        return view('panel.official-diary.configurations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'text_one' => 'nullable',
            'text_two' => 'nullable',
            'text_three' => 'nullable',
            'footer_title' => 'nullable',
            'footer_text' => 'nullable',
            'normatives' => 'nullable',
            'presentation' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        unset($validatedData['file']);

        $configureOfficialDiary = ConfigureOfficialDiary::create($validatedData);
        if ($configureOfficialDiary) {
            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'official-diary');
                $file = File::create(['url' => $url]);
                $configureOfficialDiary->files()->create(['file_id' => $file->id]);
            }
            return redirect()->route('configure-official-diary.index')->with('success', 'Configurações cadastradas com sucesso!');
        }
        return redirect()->route('configure-official-diary.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConfigureOfficialDiary $configureOfficialDiary)
    {
        //
    }

    public function presentationIndex(){
        $presentation = ConfigureOfficialDiary::first();
        return view('panel.official-diary.page.presentation', compact('presentation'));
    }

    public function presentationStore(Request $request, ){
        $configureOfficialDiary = ConfigureOfficialDiary::first();
        // dd($configureOfficialDiary);
        $validatedData = $request->validate([
            'presentation' => 'required',
        ]);
    
        // Verificar se existe um registro de ConfigureOfficialDiary
        if ($configureOfficialDiary->exists()) {
            // Se existir, atualizar
            if ($configureOfficialDiary->update($validatedData)) {
                return redirect()->route('presentation.index')->with('success', 'Configurações atualizadas com sucesso!');
            }
            // Se a atualização falhar, redirecionar com erro
            return redirect()->route('presentation.index')->with('error', 'Por favor, tente novamente!');
        } else {
            // Se não existir, criar um novo registro
            $configureOfficialDiary->create($validatedData);
            return redirect()->route('presentation.index')->with('success', 'Configurações criadas com sucesso!');
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfigureOfficialDiary $configureOfficialDiary)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'subtitle' => 'nullable',
            'text_one' => 'nullable',
            'text_two' => 'nullable',
            'text_three' => 'nullable',
            'footer_title' => 'nullable',
            'footer_text' => 'nullable',
            'normatives' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        unset($validatedData['file']);

        if ($configureOfficialDiary->update($validatedData)) {
            if ($request->hasFile('file')) {
                if($configureOfficialDiary->files->count() > 0){
                    $this->fileUploadService->deleteFile($configureOfficialDiary->files[0]->file->id);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'official-diary');
                $file = File::create(['url' => $url]);
                $configureOfficialDiary->files()->create(['file_id' => $file->id]);
            }
            
            //atualiza o pdf em construção
            $official_diary = OfficialJournal::whereDate('created_at', Carbon::today())->first();
            if($official_diary && $official_diary->publications->count() > 0){
                $this->officialDiaryPdf->officialDiaryGenerate($official_diary);
            }

            return redirect()->route('configure-official-diary.index')->with('success', 'Configurações atualizadas com sucesso!');
        }
        return redirect()->route('configure-official-diary.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfigureOfficialDiary $configureOfficialDiary)
    {
        //
    }
}
