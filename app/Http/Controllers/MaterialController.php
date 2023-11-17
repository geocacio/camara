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
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{

    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_material = Page::where('name', 'Materiais')->first();
        $groups = TransparencyGroup::all();
        return view('panel.materials.page.edit', compact('page_material', 'groups'));
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

        $page_material = Page::where('name', 'Materiais')->first();

        if ($page_material->update($validateData)) {
            $page_material->groupContents()->delete();
            $page_material->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('materials.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('materials.page')->with('error', 'Por favor tente novamente!');
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

    public function allMaterials(Request $request){
        
        $getType = Type::where('slug', 'materials')->first();
        $types = $getType ? $getType->children : [];
        $category = Category::where('slug', 'status')->with('children')->get();
        $situations = $category[0]->children;

        $page_material = Page::where('name', 'Materiais')->first();
        $query = Material::query();

        if($request->filled('type_id')){
            $query->where('type_id', $request->input('type_id'));
        }
        
        if($request->filled('status_id')){
            $query->where('status_id', $request->input('status_id'));
        }

        if($request->filled('description')){
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }
        
        $materials = $query->paginate(10);
        $searchData = $request->only(['type_id', 'status_id', 'description']);
        return view('pages.materials.index', compact('materials', 'page_material', 'searchData', 'types', 'situations'));
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
                $query->where('legislature_id', $currentLegislature->id);
                    // ->where('bond_id', 19); // Verifique se a relação correta é usada
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
            "proceeding_id" => "required",
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
        // dd($material->votes);
        $material->update(['views' => ($material->views + 1)]);
        return view('pages.materials.show', compact('material'));
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
            "proceeding_id" => "required",
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
