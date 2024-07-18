<?php
    
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\File;
use App\Models\LRF;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LRFController extends Controller
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
        $lrfs = LRF::with('types')->get();
        return view('panel.transparency.lrf.index', compact('lrfs'));
    }

    public function allLrf(Request $request){
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);

        $competencies = Category::where('slug', 'competencias')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $query = LRF::query(); //select * from `lrfs`

        if($request->filled('description')){
            $query->where('details', 'LIKE', '%' . $request->input('description') . '%');
        }

        if($request->filled('date')){
            $query->where('date', 'LIKE', '%' . $request->input('date') . '%');
        }

        if($request->filled('competence_id') || $request->filled('exercice_id')){
            $getCategoryRelation = CategoryContent::whereIn('category_id', [$request->input('competence_id'), $request->input('exercice_id')])
            ->where('categoryable_type', 'lrf')
            ->get();

            $query->whereIn('id', $getCategoryRelation->pluck('categoryable_id'));
        }

        $lrfs = $query->get();

        $category = Category::where('slug', 'exercicios')->first();
        $subCategories = Category::where('parent_id', $category->id)->get();

        $resultArray = [];
        $processedItemIds = collect(); // Usando uma coleção como um "Set"

        foreach ($category->children as $subCategory) {
            foreach ($subCategory->categoryContents as $content) {
                $itemId = $content->categoryable_id;

                // Verifique se o $itemId já foi processado
                if (!$processedItemIds->contains($itemId)) {
                    // Percorra manualmente os itens e compare os ids
                    $matchingItem = null;
                    foreach ($lrfs as $item) {
                        if ($item->id == $itemId) {
                            $matchingItem = $item;
                            break;
                        }
                    }

                    // Verifique se o item correspondente foi encontrado antes de adicionar ao array
                    if ($matchingItem !== null) {
                        $resultArray[$subCategory->name][] = $matchingItem;
                    }

                    // Adicione o $itemId ao conjunto de itens processados
                    $processedItemIds->push($itemId);
                }
            }
        }

        $allTypes = Type::where('slug', 'lrfs')->first()->children;

        $searchData = $request->only(['details', 'number', 'date']);

        return view('pages.lrf.index', compact('lrfs', 'searchData', 'competencies', 'exercicies', 'resultArray', 'allTypes'));
    }

    public function page(){
        //
    }
    
    public function pageEdit()
    {
        $lrf = Page::where('name', 'Lrfs')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.lrf.page.edit', compact('lrf', 'groups'));
    }


    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'main_title' => 'required',
            'icon' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'transparency_group_id' => 'required',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório',
            'icon.required' => 'O campo icon é obrigatório',
        ]);

        $lrf = Page::where('name', 'Lrfs')->first();
        
        if ($lrf->update($validateData)) {
            $lrf->groupContents()->delete();
            $lrf->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('lrfs-page.update')->with('success', 'Informações atualizadas com sucesso!');
        }

        return redirect()->route('lrfs-page.update')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Type $type)
    {
        $types = Type::where('slug', 'lrfs')->first()->children;
        $competencies = Category::where('slug', 'competencias')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        return view('panel.transparency.lrf.create', compact('types', 'competencies', 'exercicies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'title' => 'required',
            'date' => 'nullable',
            'competence' => 'nullable',
            'exercicy' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'details' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug('lrf-' . $request->date);

        $lrf = LRF::create($validatedData);
        if ($lrf) {

            $transparency = Category::where('slug', 'transparencia')->first();
            if ($transparency) {
                $lrf->categories()->create([
                    'category_id' => $transparency->id,
                ]);
            }

            $competence = Category::where('id', $request->competence)->first();
            if ($competence) {
                $lrf->categories()->create([
                    'category_id' => $competence->id,
                ]);
            }

            $exercicy = Category::where('id', $request->exercicy)->first();
            if ($exercicy) {
                $lrf->categories()->create([
                    'category_id' => $exercicy->id,
                ]);
            }

            $lrf->types()->attach($request->type);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $url = $this->fileUploadService->upload($file, 'transparencia/lrf');
                    $newFile = File::create(['url' => $url]);
                    $lrf->files()->create(['file_id' => $newFile->id]);
                }
            }

            return redirect()->route('lrfs.index')->with('success', 'LRF cadastrado com sucesso!');
        }

        return redirect()->route('lrfs.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LRF $lrf)
    {
        return view('pages.lrf.single', compact('lrf'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LRF $lrf)
    {
        $lrfCategories = $lrf->categories->pluck('category');

        $files = $lrf->files;
        
        $types = Type::where('slug', 'lrfs')->first()->children;
        $competencies = Category::where('slug', 'competencias')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        return view('panel.transparency.lrf.edit', compact('lrf', 'files', 'types', 'competencies', 'exercicies', 'lrfCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LRF $lrf)
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'title' => 'required',
            'date' => 'nullable',
            'competence' => 'nullable',
            'exercicy' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'details' => 'nullable',
        ]);

        $lrf->categories()->delete();        

        $transparency = Category::where('slug', 'transparencia')->first();
        if ($transparency) {
            $lrf->categories()->create([
                'category_id' => $transparency->id,
            ]);
        }

        $competence = Category::where('id', $request->competence)->first();
        if ($competence) {
            $lrf->categories()->create([
                'category_id' => $competence->id,
            ]);
        }

        $exercicy = Category::where('id', $request->exercicy)->first();
        if ($exercicy) {
            $lrf->categories()->create([
                'category_id' => $exercicy->id,
            ]);
        }

        $lrf->types()->detach();
        $lrf->types()->attach($request->type);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $url = $this->fileUploadService->upload($file, 'transparencia/lrf');
                $newFile = File::create(['url' => $url]);
                $lrf->files()->create(['file_id' => $newFile->id]);
            }
        }

        if ($lrf->update($validatedData)) {
            return redirect()->route('lrfs.index')->with('success', 'LRF atualizado com sucesso!');
        }


        return redirect()->route('lrfs.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LRF $lrf)
    {
        if ($lrf->files->count() > 0) {
            foreach ($lrf->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }

        $lrf->categories()->delete();
        $lrf->types()->detach();
        $lrf->files()->delete();
        $lrf->delete();

        return redirect()->route('lrfs.index')->with('success', 'LRF excluído com sucesso!');
    }
}
