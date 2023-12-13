<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DecreePage;
use App\Models\Decrees;
use App\Models\File;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class DecreesController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_decree = Page::where('name', 'Decretos')->first();
        $groups = TransparencyGroup::all();
        return view('panel.decree.page.edit', compact('page_decree', 'groups'));
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

        $page_decree = Page::where('name', 'Decretos')->first();

        if ($page_decree->update($validateData)) {
            $page_decree->groupContents()->delete();
            $page_decree->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('decrees.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('decrees.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $decrees = Decrees::all();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        return view('panel.decree.index', compact('decrees', 'exercicies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $decreesType = Type::where('slug', 'decrees')->first();
        $types = $decreesType ? $decreesType->children : [];
        $groups = Category::where('slug', 'grupos')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        return view('panel.decree.create', compact('groups', 'types', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required',
            'group_id' => 'required',
            'exercicy_id' => 'required',
            'date' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'description' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug($request->number);

        unset($validatedData['file']);

        $decrees = Decrees::create($validatedData);
        if ($decrees) {

            $decrees->types()->attach($request->type);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $url = $this->fileUploadService->upload($file, 'decrees');
                    $newFile = File::create(['url' => $url]);
                    $decrees->files()->create(['file_id' => $newFile->id]);
                }
            }

            return redirect()->route('decrees.index')->with('success', 'Decreto cadastrado com sucesso!');
        }

        return redirect()->route('decrees.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $page_decree = Page::where('name', 'Decretos')->first();
        $query = Decrees::query();

        if($request->filled('number')){
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }
        if($request->filled('date')){
            $query->whereDate('date', '=', date("Y-m-d", strtotime($request->input('date'))));
        }
        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        $decrees = $query->paginate(10);
        $searchData = $request->only(['number', 'date', 'description']);
        
        return view('pages.decrees.index', compact('decrees', 'searchData', 'page_decree'));
    }

    public function showDecree(Decrees $decree)
    {
        // Incrementar o contador de visualizações
        $decree->views = $decree->views + 1;
        $decree->save();
        return view('pages.decrees.single', compact('decree'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Decrees $decree)
    {
        $decreeCategories = $decree->categories->pluck('category');

        $files = $decree->files;

        $types = Type::where('slug', 'decrees')->first()->children;
        $groups = Category::where('slug', 'grupos')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        return view('panel.decree.edit', compact('decree', 'files', 'types', 'groups', 'exercicies', 'decreeCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Decrees $decree)
    {
        $validatedData = $request->validate([
            'number' => 'required',
            'group_id' => 'required',
            'exercicy_id' => 'required',
            'date' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'description' => 'nullable',
        ]);
        unset($validatedData['file']);

        $decree->types()->detach();
        $decree->types()->attach($request->type);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $url = $this->fileUploadService->upload($file, 'decrees');
                $newFile = File::create(['url' => $url]);
                $decree->files()->create(['file_id' => $newFile->id]);
            }
        }

        if ($decree->update($validatedData)) {
            return redirect()->route('decrees.index')->with('success', 'Decreto atualizado com sucesso!');
        }

        return redirect()->route('decrees.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Decrees $decree)
    {
        if ($decree->files->count() > 0) {
            foreach ($decree->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }

        $decree->categories()->delete();
        $decree->types()->detach();
        $decree->files()->delete();
        $decree->delete();

        return redirect()->route('decrees.index')->with('success', 'Decreto excluído com sucesso!');
    }
}
