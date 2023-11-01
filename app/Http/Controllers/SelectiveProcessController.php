<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Page;
use App\Models\SelectiveProcess;
use App\Models\SelectiveProcessPage;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SelectiveProcessController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_selective_process = Page::where('name', 'Processo Seletivo')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.selective-process.page.edit', compact('page_selective_process', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_selective_process = Page::where('name', 'Processo Seletivo')->first();

        if ($page_selective_process->update($validateData)) {
            $page_selective_process->groupContents()->delete();
            $page_selective_process->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('proccess.selective.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('proccess.selective.page')->with('error', 'Por favor tente novamente!');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selective_processes = SelectiveProcess::all();
        
        return view('panel.transparency.selective-process.index', compact('selective_processes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.transparency.selective-process.create', compact('exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'exercicy_id' => 'required',
            'description' => 'required',
            'views' => 'nullable',
            'files.*' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'exercicy_id.required' => 'O campo exercício é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'files.*.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
        ]);
        
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $SelectiveProcess = SelectiveProcess::max('id');
        $nextId = $SelectiveProcess ? $SelectiveProcess + 1 : 1;
        $validatedData['slug'] = Str::slug('selective-process-' . $nextId);

        $selective_process = SelectiveProcess::create($validatedData);
        if ($selective_process) {

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $url = $this->fileUploadService->upload($file, 'transparencia/selective-process');

                    //get fileName
                    $fileName = isset($request->custom_names[$key]) ? $request->custom_names[$key] : '';
                    $newFile = File::create(['name' => $fileName !== '' ? $fileName : $file->getClientOriginalName(), 'url' => $url]);
                    $selective_process->files()->create(['file_id' => $newFile->id]);
                }
            }

            return redirect()->route('selective-process.index')->with('success', 'Processo seletivo cadastrada com sucesso!');
        }

        return redirect()->route('selective-process.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $selective_process_page = page::where('name', 'Processo Seletivo')->first();
        $query = SelectiveProcess::query();

        if($request->filled('number')){
            $query->where('id', $request->input('number'));
        }
        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        $selective_proccess = $query->select(['id', 'exercicy_id', 'description as Descrição'])->paginate(10);
        $searchData = $request->only(['number', 'description']);

        return view('pages.selective-proccess.index', compact('selective_proccess', 'selective_process_page', 'searchData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SelectiveProcess $selective_process)
    {
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.transparency.selective-process.edit', compact('exercicies', 'selective_process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SelectiveProcess $selective_process)
    {
        // dd($request->files);
        $validatedData = $request->validate([
            'exercicy_id' => 'required',
            'description' => 'required',
            'views' => 'nullable',
            'files.*' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ], [
            'exercicy_id.required' => 'O campo exercício é obrigatório',
            'description.required' => 'O campo descrição é obrigatório',
            'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
        ]);

        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        if($selective_process->update($validatedData)){

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $url = $this->fileUploadService->upload($file, 'transparencia/selective-process');
                     //get fileName
                     $fileName = isset($request->custom_names[$key]) ? $request->custom_names[$key] : '';
                     $newFile = File::create(['name' => $fileName !== '' ? $fileName : $file->getClientOriginalName(), 'url' => $url]);
                    $selective_process->files()->create(['file_id' => $newFile->id]);
                }
            }

            return redirect()->route('selective-process.index')->with('success', 'Processo seletivo cadastrada com sucesso!');
        }

        return redirect()->route('selective-process.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SelectiveProcess $selective_process)
    {
        if ($selective_process->files->count() > 0) {
            foreach ($selective_process->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }
        
        $selective_process->delete();

        return redirect()->route('selective-process.index')->with('success', 'Processo seletivo excluído com sucesso!');
    }
}
