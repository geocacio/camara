<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ConfigureOfficialDiary;
use App\Models\File;
use App\Models\FileContent;
use App\Models\Law;
use App\Models\officehour as OfficeHour;
use App\Models\OfficialJournal;
use App\Models\Page;
use App\Models\SecretaryPublication;
use App\Models\TransparencyGroup;
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
        $getJournalID = FileContent::where('fileable_type', 'official_journals')->get();

        if ($id == null) {
            $dayle = OfficialJournal::whereIn('id', $getJournalID->pluck('fileable_id'))->latest()->first();
        } else {
            $dayle = OfficialJournal::where('id', $id)->first();
        }
    
        $dayles = OfficialJournal::whereIn('id', $getJournalID->pluck('fileable_id'))->get();
    
        $position = $dayles->search(function ($item) use ($dayle) {
            return $item->id == $dayle->id;
        });
    
        $adjustedPosition = $position !== false ? $position + 1 : null;

        $page = Page::where('name', 'Díario Oficial')->first();
    
        return view('pages.official-diary.index', compact('dayle', 'adjustedPosition', 'page'));
    }
    
    public function journalPage(){
        $outsource = Page::where('name', 'Díario Oficial')->first();
        $groups = TransparencyGroup::all();
        return view('panel.official-diary.page.edit', compact('outsource', 'groups'));
    }

    public function journalPageUpdate (Request $request){
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'featured_description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);

        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_daily = Page::where('name', 'Díario Oficial')->first();

        if ($page_daily->update($validateData)) {
            $page_daily->groupContents()->delete();
            $page_daily->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('journal.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('journal.page')->with('error', 'Por favor tente novamente!');
    }

    public function normative()
    {
        $normative = ConfigureOfficialDiary::first();
        $filesReferences = FileContent::where('fileable_type', 'configure_official_diary')->pluck('file_id');
        $files = File::whereIn('id', $filesReferences)->where('url', 'LIKE', 'normativas%')->get();
        return view('pages.official-diary.normative', compact('normative', 'files'));
    }

    
    public function presentation()
    {
        $presentation = ConfigureOfficialDiary::first();

        $dayle = OfficialJournal::first();

        $getJournalID = FileContent::where('fileable_type', 'official_journals')->get();

        $dayle = OfficialJournal::whereIn('id', $getJournalID->pluck('fileable_id'))->latest()->first();
    
        $dayles = OfficialJournal::whereIn('id', $getJournalID->pluck('fileable_id'))->get();

        $position = $dayles->search(function ($item) use ($dayle) {
            return $item->id == $dayle->id;
        });
    
        $adjustedPosition = $position !== false ? $position + 1 : null;

        return view('pages.official-diary.presentation', compact('presentation', 'dayle', 'adjustedPosition'));
    }

    public function normativeIndex(){
        $filesReferences = FileContent::where('fileable_type', 'configure_official_diary')->pluck('file_id');
        $files = File::whereIn('id', $filesReferences)->where('url', 'LIKE', 'normativas%')->get();
        return view('panel.official-diary.page.normative-index', compact('files'));
    }

    public function normativeLaws($id = null)
    {
        $filesReferences = FileContent::where('fileable_type', 'Normativas')->get();
        if($id != null){
            $file = File::where('id', $id)->first();
            return view('panel.official-diary.page.normative', compact('file', 'id'));
        }
        return view('panel.official-diary.page.normative');
    }

    public function normativePresentationStore(Request $request){
        try {
            $configure = ConfigureOfficialDiary::first();
    
            if ($configure) {
                // Verifique se o ID está presente na requisição
                if (!is_null($request->id)) {
                    // Encontre o registro de arquivo existente
                    $existingFile = File::find($request->id);
    
                    // Atualize apenas a descrição se não houver arquivo enviado
                    if ($request->hasFile('file')) {
                        // Faça upload do novo arquivo
                        $url = $this->fileUploadService->upload($request->file('file'), 'normativas');
                        // Atualize a URL e a descrição do arquivo
                        $existingFile->update(['url' => $url, 'description' => $request->description]);
                    } else {
                        // Apenas atualize a descrição
                        $existingFile->update(['description' => $request->description]);
                    }
    
                    return redirect()->route('normative.index')->with('success', 'Arquivo atualizado com sucesso!');
                } else {
                    // Crie um novo arquivo
                    $url = $this->fileUploadService->upload($request->file('file'), 'normativas');
                    $newFile = File::create(['url' => $url, 'description' => $request->description]);
                    $configure->files()->create(['file_id' => $newFile->id]);
                    
                    return redirect()->route('normative.index')->with('success', 'Novo arquivo criado com sucesso!');
                }
            }
    
            return redirect()->route('normative.index')->with('error', 'Item não encontrado.');
        } catch (\Exception $e) {
            return redirect()->route('normative.index')->with('error', $e->getMessage());
        }
    }
    

    public function allEditions()
    {
        $getJournalID = FileContent::where('fileable_type', 'official_journals')->get();
        $dayles = OfficialJournal::whereIn('id', $getJournalID->pluck('fileable_id'))->get();

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

    public function search(Request $request)
    {
        $getJournalID = FileContent::where('fileable_type', 'official_journals')->get();
        $query = OfficialJournal::query()->whereIn('id', $getJournalID->pluck('fileable_id'));
        $category = Category::where('slug', 'sumario')->first();
        $sumarys = Category::where('parent_id', $category->id)->get();
        $publication = SecretaryPublication::get();
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
        
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('created_at', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('created_at', '<=', $end_date);
        } else if ($request->filled('sumary_id')) {
            // Se apenas a data final estiver definida
            $pub = $publication->where('summary_id', $request->sumary_id)->pluck('diary_id');
            $pubArray = $pub->toArray();
            $query->whereIn('id', $pubArray);

        }       

        $dayles = $query->paginate(10);
        $searchData = $request->only(['start_date', 'end_date', 'description', 'sumary_id']);

        return view('pages.official-diary.search', compact('dayles', 'searchData', 'sumarys'));
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

    public function expedient()
    {       
        $officeHour = OfficeHour::first();
    
        if (!$officeHour) {
            return view('panel.official-diary.page.officehours.create');
        }else {
            return view('panel.official-diary.page.officehours.edit', compact('officeHour'));
        }
    }

    public function expedientShow(){
        $officeHour = OfficeHour::first();
        $dayle = OfficialJournal::latest()->first();
        return view('pages.official-diary.expedient', compact('officeHour', 'dayle'));
    }

    public function expedienteStore()
    {
        $validatedData = request()->validate([
            'information' => 'required',
            'frequency' => 'required',
            'responsible_name' => 'required',
            'responsible_position' => 'required',
            'entity_name' => 'required',
            'entity_address' => 'required',
            'entity_zip_code' => 'required',
            'entity_cnpj' => 'required',
            'entity_email' => 'required',
            'entity_phone' => 'required',

            'site' => 'required',
            'url_diario' => 'required',
            'expedient' => 'required',
        ], [
            'information.required' => 'O campo Informações é obrigatório!',
            'frequency.required' => 'O campo Frequência é obrigatório!',
            'responsible_name.required' => 'O campo Nome do responsável é obrigatório!',
            'responsible_position.required' => 'O campo Cargo do responsável é obrigatório!',
            'entity_name.required' => 'O campo Nome da entidade é obrigatório!',
            'entity_address.required' => 'O campo Endereço da entidade é obrigatório!',
            'entity_zip_code.required' => 'O campo CEP da entidade é obrigatório!',
            'entity_cnpj.required' => 'O campo CNPJ da entidade é obrigatório!',
            'entity_email.required' => 'O campo E-mail da entidade é obrigatório!',
            'entity_phone.required' => 'O campo Telefone da entidade é obrigatório!',

            'site.required' => 'O campo SITE é obrigatório!',
            'url_diario.required' => 'O campo URL do diário é obrigatório!',
            'expedient.required' => 'O campo Expediente é obrigatório!',
        ]);
    
        $officeHour = OfficeHour::first();
    
        if (!$officeHour) {
            $officeHour = new OfficeHour;
            $message = "Expediente cadastrado com sucesso!";
        }

        $message = "Expediente atualizado com sucesso!";
    
        $officeHour->fill($validatedData);
    
        if ($officeHour->save()) {
            return redirect()->back()->with('success', $message);
        }
    
        return redirect()->back()->with('error', 'Por favor, tente novamente!');
    }

    public function normativePresentationDelete(Request $request){
        try {
            $configure = ConfigureOfficialDiary::first();
    
            if ($configure) {
                // Verifique se o ID está presente na requisição
                if (!empty($request->id)) {
                    // Exclua os registros filhos na tabela file_contents
                    FileContent::where('file_id', $request->id)->delete();
                    
                    // Em seguida, exclua o registro na tabela files
                    $existingFile = File::find($request->id);
                    if ($existingFile) {
                        Storage::delete($existingFile->url); // Deleta o arquivo do armazenamento
                        $existingFile->delete(); // Deleta o registro do arquivo do banco de dados
                    }
    
                    return redirect()->route('normative.index')->with('success', 'Excluido com sucesso!');
                }
    
            }
    
        } catch (\Exception $e) {
            return redirect()->route('normative.index')->with('error', 'Houve um erro!');
        }
    }
    
    
}
