<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Law;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LawController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_law = Page::where('name', 'Leis')->first();
        $groups = TransparencyGroup::all();
        return view('panel.law.page.edit', compact('page_law', 'groups'));
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

        $page_law = Page::where('name', 'Leis')->first();

        if ($page_law->update($validateData)) {
            $page_law->groupContents()->delete();
            $page_law->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('laws.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('laws.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = Law::query(); //select * from `laws`
        if($search){
            $query->with('exercicy');
            $query->where('number', $search); //"select * from `laws` where `number` LIKE ?"
            $query->orWhere('description', 'LIKE', '%' . $search . '%');//"select * from `laws` where `number` LIKE ? or `description` LIKE ?" 
            $query->orWhereHas('exercicy', function ($query) use ($search) {
                $query->where('name', $search);
            });//"select * from `laws` where `number` LIKE ? or `description` LIKE ? or exists (select * from `categories` where `laws`.`exercicy_id` = `categories`.`id` and `name` = ?)
        }

        $laws = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.law.index', compact('laws', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('slug', 'laws')->first()->children;
        $competencies = Category::where('slug', 'competencias')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        return view('panel.law.create', compact('competencies', 'types', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'competency_id' => 'required',
            'title' => 'required',
            'type_id' => 'required',
            'date' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'description' => 'nullable',
        ],
        [
            'competency_id.required' => 'O campo competência é obrigatório!',
            'title.required' => 'O campo título é obrigatório!',
            'type_id.required' => 'O campo tipo é obrigatório!',
            'date.required' => 'O campo data é obrigatório!',
            'file.required' => 'O campo arquivo é obrigatório!',
            'file.max' => 'O arquivo não pode ser maior que 1GB!',
            'file.file' => 'O arquivo deve ser um arquivo!',
            'description.required' => 'O campo descrição é obrigatório!',
        ]);
        $validatedData['slug'] = Str::slug($request->date);
        
        unset($validatedData['file']);

        $law = Law::create($validatedData);
        if ($law) {

            $law->types()->attach($request->type);

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'laws');
                $newFile = File::create(['url' => $url]);
                $law->files()->create(['file_id' => $newFile->id]);
            }

            return redirect()->route('laws.index')->with('success', 'Lei cadastrada com sucesso!');
        }

        return redirect()->route('laws.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {        
        $page_law = Page::where('name', 'Leis')->first();
        $query = Law::query();
        $competencies = Category::where('parent_id', 8)->get();
        $types = Type::where('parent_id', 9)->get();
        // if($request->filled('number')){
        //     $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        // }
        if($request->filled('date')){
            $query->whereDate('date', '=', date("Y-m-d", strtotime($request->input('date'))));
        }
        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }
        if($request->filled('competencie')){
            $query->where('competency_id', $request->input('competencie'));
        }
        if($request->filled('type')){
            $query->where('type_id', $request->input('type'));
        }

        $laws = $query->paginate(10);
        $searchData = $request->only(['number', 'date', 'description', 'competencie', 'type']);

        return view('pages.laws.index', compact('page_law', 'laws', 'searchData', 'competencies', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Law $law)
    {
        
        $lawCategories = $law->categories->pluck('category');

        $files = $law->files;
        
        $types = Type::where('slug', 'laws')->first()->children;
        $competencies = Category::where('slug', 'competencias')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        return view('panel.law.edit', compact('law', 'files', 'types', 'competencies', 'exercicies', 'lawCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Law $law)
    {
        $validatedData = $request->validate([
            'competency_id' => 'required',
            'title' => 'required',
            'type_id' => 'required',
            'date' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'description' => 'nullable',
        ],
        [
            'competency_id.required' => 'O campo competência é obrigatório!',
            'title.required' => 'O campo título é obrigatório!',
            'type_id.required' => 'O campo tipo é obrigatório!',
            'date.required' => 'O campo data é obrigatório!',
            'file.required' => 'O campo arquivo é obrigatório!',
            'file.max' => 'O arquivo não pode ser maior que 1GB!',
            'file.file' => 'O arquivo deve ser um arquivo!',
            'description.required' => 'O campo descrição é obrigatório!',
        ]);
        unset($validatedData['file']);

        $law->types()->detach();
        $law->types()->attach($request->type);

        if ($request->hasFile('file')) {
            $url = $this->fileUploadService->upload($request->file('file'), 'laws');
            $newFile = File::create(['url' => $url]);
            $law->files()->create(['file_id' => $newFile->id]);
        }

        if ($law->update($validatedData)) {
            return redirect()->route('laws.index')->with('success', 'Lei atualizada com sucesso!');
        }

        return redirect()->route('laws.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Law $law)
    {
        if ($law->files->count() > 0) {
            foreach ($law->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }

        $law->categories()->delete();
        $law->types()->detach();
        $law->files()->delete();
        $law->delete();

        return redirect()->route('laws.index')->with('success', 'Lei excluída com sucesso!');
    }
}
