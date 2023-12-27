<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\OfficialJournal;
use App\Models\SecretaryPublication;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficialJournalController extends Controller
{
    private $fileUploadService;
    private $timeLimit = '23:00';

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officialJournal = OfficialJournal::whereDate('created_at', Carbon::today())->first();
        if (empty($officialJournal)) {
            $officialJournal = OfficialJournal::create(['status' => 'em andamento']);
        }

        $currentDateTime = Carbon::now();
        $currentTime = $currentDateTime->format('H:i');
        $currentDate = $currentDateTime->toDateString();
        $timeLimit = $this->timeLimit;

        $diaries = OfficialJournal::orderBy('id', 'desc')->get();
        return view('panel.official-diary.index', compact('diaries', 'officialJournal', 'timeLimit', 'currentTime', 'currentDate'));
    }

    public function page($id = null)
    {
        if ($id == null) {
            $dayle = OfficialJournal::latest()->first();
        } else {
            $dayle = OfficialJournal::where('id', $id)->first();
        }

        return view('pages.official-diary.index', compact('dayle'));
    }

    public function allEditions()
    {
        $dayles = OfficialJournal::all();
        return view('pages.official-diary.show', compact('dayles'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficialJournal $officialJournal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficialJournal $official_diary)
    {
        $currentDateTime = Carbon::now();
        $currentTime = $currentDateTime->format('H:i');
        if ($currentTime >= $this->timeLimit) {
            session()->flash('error', 'Desculpe, o prazo para edição do diário oficial expirou.');
            return $this->index();
        }
        $requestSecretaries = SecretaryPublication::all();
        // dd($official_diary->officialJournalContents);
        return view('panel.official-diary.edit', compact('requestSecretaries', 'official_diary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficialJournal $official_diary)
    {
        $currentDateTime = Carbon::now();
        $currentTime = $currentDateTime->format('H:i');
        if ($currentTime >= $this->timeLimit) {
            session()->flash('error', 'Desculpe, o prazo para edição do diário oficial expirou.');
            return $this->index();
        }

        $validateData = $request->validate([
            'content' => 'required',
            'status' => 'required'
        ]);
        $validateData['user_id'] = Auth::user()->id;

        $publications = json_decode($request->publication_ids);
        if (isset($publications) && !empty($publications)) {
            $official_diary->officialJournalContents()->delete();
            foreach ($publications as $id) {
                $officialJournalContent = $official_diary->officialJournalContents()->create(['official_journal_id' => $official_diary->id, 'publication_id' => $id]);
            }
        }

        //Criar sumário para o diário oficial
        $summary = [];
        $count = 1;
        foreach ($official_diary->officialJournalContents as $content) {
            $count++;
            $summary[] = [
                'id' => $content->publication->id,
                'title' => $content->publication->title,
                'url' => '#content-' . $content->publication->id,
                'page_number' => $count,
            ];
            $validateData['content'] = str_replace(
                'class="summary">' . html_entity_decode($content->publication->title),
                'class="summary" id="content-' . $content->publication->id . '">' . html_entity_decode($content->publication->title),
                html_entity_decode($validateData['content'])
            );
        }

        $validateData['summary'] = json_encode($summary);

        if ($official_diary->update($validateData)) {
            // Verificar se o arquivo já existe
            if (!empty($official_diary->files)) {
                foreach ($official_diary->files as $pdf) {
                    Storage::disk('public')->delete($pdf->file->url);
                    $pdf->delete();
                    $pdf->file->delete();
                }
            }

            //gerar pdf            
            $html = view('pdf.officialDiary', compact('official_diary'))->render();
            $pdf = app()->make('dompdf.wrapper');
            $pdf->loadHTML($html);

            $fileName = 'diary' . '_' . uniqid() . '.pdf';
            $filePath = 'official-diary/' . $fileName;

            // Salvar o PDF no armazenamento (storage)
            Storage::disk('public')->put($filePath, $pdf->output());

            // Armazenar o endereço do PDF no banco de dados
            $newFile = File::create(['name' => $fileName, 'url' => $filePath]);
            $official_diary->files()->create(['file_id' => $newFile->id]);

            session()->flash('success', 'Diário Oficial finalizado com sucesso!');
            return response()->json(['success' => true, 'official_diary' => $official_diary]);
        }

        session()->flash('error', 'Erro, por favor tente novamente!');
        return response()->json(['error' => true, 'Erro, por favor tente novamente!']);
    }

    public function createOfficialDiary(OfficialJournal $official_diary)
    {
        $publications = SecretaryPublication::where('diary_id', $official_diary->id)->get();
        foreach ($publications as $publication) {
            if ($publication->column > 1) {
                $words = explode(' ', $publication->content);

                $column_1 = '';
                $column_2 = '';
                $half = ceil(count($words) / 2);

                foreach ($words as $key => $word) {
                    if ($key < $half) {
                        $column_1 .= $word . ' ';
                    } else {
                        $column_2 .= $word . ' ';
                    }
                }

                $publication->content_1 = $column_1;
                $publication->content_2 = $column_2;
            }
        }
        // dd($publications);
        if (!empty($official_diary->files)) {
            foreach ($official_diary->files as $pdf) {
                Storage::disk('public')->delete($pdf->file->url);
                $pdf->delete();
                $pdf->file->delete();
            }
        }
        
        //gerar pdf            
        $html = view('pdf.officialDiary', compact('publications'))->render();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadHTML($html);

        $fileName = 'diary' . '_' . uniqid() . '.pdf';
        $filePath = 'official-diary/' . $fileName;

        // Salvar o PDF no armazenamento (storage)
        Storage::disk('public')->put($filePath, $pdf->output());

        // Armazenar o endereço do PDF no banco de dados
        $newFile = File::create(['name' => $fileName, 'url' => $filePath]);
        $official_diary->files()->create(['file_id' => $newFile->id]);

        // session()->flash('success', 'Diário Oficial finalizado com sucesso!');
        // return response()->json(['success' => true, 'official_diary' => $official_diary]);
        return redirect()->route('official-diary.index')->with('success', 'Diário Oficial finalizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $officialJournal = OfficialJournal::find($id);
        if ($officialJournal->files->count() > 0) {
            $this->fileUploadService->deleteFile($officialJournal->files[0]->file->id);
        }

        $officialJournal->delete();
        return redirect()->route('official-diary.index')->with('success', 'Diário oficial excluído com sucesso!');
    }
}
