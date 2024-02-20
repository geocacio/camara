<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Category;
use App\Models\DisplayOrder;
use App\Models\File;
use App\Models\FileContent;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AvailableFilesController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Bidding $bidding)
    {
        $orderedFiles = DisplayOrder::where('page', $bidding->slug)->orderBy('display_order')->get();
    
        if ($orderedFiles->isEmpty()) {
            $availableFiles = $bidding->files;
        } else {
            $fileIds = $orderedFiles->pluck('item_id')->toArray();
            $availableFiles = $bidding->files->whereIn('id', $fileIds)->sortBy(function($item) use ($fileIds) {
                return array_search($item->id, $fileIds);
            });
        }
    
        return view('panel.biddings.files.index', compact('bidding', 'availableFiles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Bidding $bidding)
    {
        $category = Category::where('slug', 'arquivos-disponiveis')->with('children')->first();
        return view('panel.biddings.files.create', compact('bidding', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Bidding $bidding, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => "required|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        
        $url = $this->fileUploadService->upload($request->file('file'), 'biddings');
        $file = File::create(['name' => $request->name, 'description' => $request->description, 'url' => $url]);
        $bidding->files()->create(['file_id' => $file->id]);
        return redirect()->route('biddings.available.files.index', $bidding->slug)->with('success', 'Arquivo cadastrado com sucesso!');
    }

    public function createCategory(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|unique:categories',
                'parent_id' => 'nullable|exists:categories,id',
            ],
            [
                'name.unique' => 'O nome já está sendo usado por outra categoria.',
            ]
        );
        $validatedData['slug'] = Str::slug($request->name);

        $category = Category::create($validatedData);
        if ($category) {
            session()->flash('success', 'Nome de arquivo criado com sucesso!');
            return response()->json(['success' => true, 'category' => $category]);
        }
        session()->flash('error', 'Por favor tente novamente!');
        return response()->json(['error' => true, 'category' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidding $bidding, string $id)
    {
        $file = File::find($id);
        $category = Category::where('slug', 'arquivos-disponiveis')->with('children')->first();
        return view('panel.biddings.files.edit', compact('bidding', 'file', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Bidding $bidding, Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        $file = File::find($id);
        
        if ($request->hasFile('file')) {
            if($file){
                $this->fileUploadService->deleteFile($file->id);
            }
            
            $url = $this->fileUploadService->upload($request->file('file'), 'employee');
            $newFile = File::create(['name' => $request->name, 'description' => $request->description, 'url' => $url]);                
            $bidding->files()->create(['file_id' => $newFile->id]);

            $url = $this->fileUploadService->upload($request->file('file'), 'biddings');
        }else{
            $file->update(['name' => $request->name, 'description' => $request->description]);
        }
        
        return redirect()->route('biddings.available.files.index', $bidding->slug)->with('success', 'Arquivo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidding $bidding, string $id)
    {
        $fileContent = FileContent::find($id);
        
        if(!empty($fileContent->file)){
            $this->fileUploadService->deleteFile($fileContent->file->id);
        }

        $fileContent->file()->delete();
        $fileContent->delete();
        
        return redirect()->route('biddings.available.files.index', $bidding->slug)->with('success', 'Arquivo removido com sucesso!');
    }
}
