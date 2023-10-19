<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Councilor;
use App\Models\Material;
use App\Models\Legislature;
use App\Models\Session;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\File;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        // dd($materials[0]->category);
        return view('panel.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getType = Type::where('slug', 'materials')->first();
        $types = $getType ? $getType->children : [];
        $category = Category::where('slug', 'status')->with('children')->get();
        $situations = $category[0]->children;
        $sessions = Session::all();

        $legislature = new Legislature;
        $currentLegislature = $legislature->getCurrentLegislature();

        if ($currentLegislature) {
            $councilors = Councilor::whereHas('legislatureRelations', function ($query) use ($currentLegislature) {
                $query->where('legislature_id', $currentLegislature->id)
                    ->where('bond_id', 19); // Verifique se a relação correta é usada
            })->get();
        } else {
            $councilors = [];
        }

        
        return view('panel.materials.create', compact('types', 'situations', 'sessions', 'councilors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "date" => "required",
            "type_id" => "required",
            "status_id" => "required",
            "councilor_id" => "required",
            "session_id" => "required",
            "description" => "nullable",
            'file' => "required|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        $validateData['slug'] = Material::uniqSlug('material-'.$validateData['date']);
        $material = Material::create($validateData);

        if($material){

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'materials');
                $file = File::create(['url' => $url]);
                $material->files()->create(['file_id' => $file->id]);
            }
            
            return redirect()->route('materials.index')->with('success', 'Material cadastrado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $getType = Type::where('slug', 'materials')->first();
        $types = $getType ? $getType->children : [];
        $category = Category::where('slug', 'status')->with('children')->get();
        $situations = $category[0]->children;
        $sessions = Session::all();

        $legislature = new Legislature;
        $currentLegislature = $legislature->getCurrentLegislature();
        if($currentLegislature){
            $councilors = Councilor::whereHas('legislatureRelations', function ($query) use ($currentLegislature) {
                $query->where('legislature_id', $currentLegislature->id);
            })->where('bond_id', 19)->get();
        }else{
            $councilors = [];
        }
        
        return view('panel.materials.edit', compact('material', 'types', 'situations', 'sessions', 'councilors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validateData = $request->validate([
            "date" => "required",
            "type_id" => "required",
            "status_id" => "required",
            "councilor_id" => "required",
            "session_id" => "required",
            "description" => "nullable",
            'file' => "required|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        if($material->update($validateData)){

            if ($request->hasFile('file')) {
                if (isset($material->files[0]) && Storage::disk('public')->exists($material->files[0]->file->url)){
                    Storage::disk('public')->delete($material->files[0]->file->url);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'materials');
                $file = File::create(['url' => $url]);
                $material->files()->create(['file_id' => $file->id]);
            }
            
            return redirect()->route('materials.index')->with('success', 'Material atualizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        // dd($material->files[0]->file->url);
        if (isset($material->files[0]) && Storage::disk('public')->exists($material->files[0]->file->url)){
            Storage::disk('public')->delete($material->files[0]->file->url);
        }
        
        if($material->delete()){
            return redirect()->route('materials.index')->with('success', 'Material removido com sucesso!');
        }
        return redirect()->back()->with('error', 'Error, por favor tente novamente!');
    }
}
