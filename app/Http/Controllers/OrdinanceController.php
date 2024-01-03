<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Office;
use App\Models\Ordinance;
use App\Models\Page;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrdinanceController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_ordinance = Page::where('name', 'Portarias')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.ordinance.page.edit', compact('page_ordinance', 'groups'));
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

        $page_ordinance = Page::where('name', 'Portarias')->first();

        if ($page_ordinance->update($validateData)) {
            $page_ordinance->groupContents()->delete();
            $page_ordinance->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('ordinances.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('ordinances.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordinances = Ordinance::with('types')->get();
        return view('panel.transparency.ordinance.index', compact('ordinances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::where('slug', 'ordinances')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $offices = Office::all();
        $secretaries = Secretary::all();
        return view('panel.transparency.ordinance.create', compact('types', 'exercicies', 'offices', 'secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office_id' => 'nullable',
            'type' => 'required',
            'number' => 'required',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'detail' => 'nullable',
            'date' => 'nullable',
            'agent' => 'nullable',
        ], [
            'type.required' => 'O campo tipo é obrigatório',
            'number.required' => 'O campo número é obrigatório',
            'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
        ]);
        $validatedData['slug'] = Str::slug('ordinance-' . $request->number);

        $ordinance = Ordinance::create($validatedData);
        if ($ordinance) {

            $transparency = Category::where('slug', 'transparencia')->first();
            if ($transparency) {
                $ordinance->categories()->create([
                    'category_id' => $transparency->id,
                ]);
            }

            $office = Category::where('id', $request->office)->first();
            if ($office) {
                $ordinance->categories()->create([
                    'category_id' => $office->id,
                ]);
            }

            $exercicy = Category::where('id', $request->exercicy)->first();
            if ($exercicy) {
                $ordinance->categories()->create([
                    'category_id' => $exercicy->id,
                ]);
            }

            $ordinance->types()->attach($request->type);
            if ($request->secretary) {
                $ordinance->secretaries()->attach($request->secretary);
            }

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $url = $this->fileUploadService->upload($file, 'transparencia/ordinance');
                    $newFile = File::create(['url' => $url]);
                    $ordinance->files()->create(['file_id' => $newFile->id]);
                }
            }

            return redirect()->route('ordinances.index')->with('success', 'Portaria cadastrada com sucesso!');
        }

        return redirect()->route('ordinances.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = Ordinance::query();
        $types = Type::where('parent_id', 55)->get();
        $typesOrdinance = TypeContent::where('type_id', $request->type)->pluck('typeable_id');
        $cargos = Office::all();
        
        $searchData = $request->only(['number', 'start_date', 'agent', 'details', 'cargo', 'office_id', 'end_date', 'type']);

        if($request->filled('number')){
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
        
            $query->whereBetween('date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('date', '=', date("Y-m-d", strtotime($request->input('start_date'))));
        }        
        if($request->filled('agent')){
            $query->where('agent', 'LIKE', '%' . $request->input('agent') . '%');
        }
        if($request->filled('details')){
            $query->where('detail', 'LIKE', '%' . $request->input('details') . '%');
        }
        if($request->filled('cargo')){
            $query->where('office_id', 'LIKE', '%' . $request->input('cargo') . '%');
        }
        if($request->filled('type')){
            $query->whereIn('id', $typesOrdinance);
        }

        $ordinances = $query->select()->orderBy('id', 'desc')->paginate(10);

        return view('pages.ordinance.index', compact('ordinances', 'types', 'cargos', 'searchData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordinance $ordinance)
    {
        $files = $ordinance->files;
        $ordinanceCategories = $ordinance->categories->pluck('category');

        $types = Type::where('slug', 'ordinances')->first()->children;
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $offices = Office::all();
        $secretaries = Secretary::all();
        return view('panel.transparency.ordinance.edit', compact('ordinance', 'files', 'ordinanceCategories', 'types', 'exercicies', 'offices', 'secretaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordinance $ordinance)
    {

        $validatedData = $request->validate([
            'office_id' => 'nullable',
            'type' => 'required',
            'number' => 'required',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
            'detail' => 'nullable',
            'date' => 'nullable',
            'agent' => 'nullable',
        ], [
            'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
        ]);

        $ordinance->categories()->delete();
        $office = Category::where('id', $request->office)->first();
        if ($office) {
            $ordinance->categories()->create([
                'category_id' => $office->id,
            ]);
        }

        $exercicy = Category::where('id', $request->exercicy)->first();
        if ($exercicy) {
            $ordinance->categories()->create([
                'category_id' => $exercicy->id,
            ]);
        }

        $ordinance->types()->detach();
        $ordinance->types()->attach($request->type);

        if ($request->secretary) {
            $ordinance->secretaries()->detach();
            $ordinance->secretaries()->attach($request->secretary);
        }

        if ($request->hasFile('files')) {
            // $getFiles = $ordinance->files;
            // if ($getFiles->count() > 0) {
            //     foreach ($getFiles as $file) {
            //         Storage::delete('public/' . $file->file->url);
            //         $this->fileUploadService->deleteFile($file->file->id);
            //     }
            // }

            foreach ($request->file('files') as $file) {
                $url = $this->fileUploadService->upload($file, 'transparencia/ordinance');
                $newFile = File::create(['url' => $url]);
                $ordinance->files()->create(['file_id' => $newFile->id]);
            }
        }

        if ($ordinance->update($validatedData)) {
            return redirect()->route('ordinances.index')->with('success', 'Portaria cadastrada com sucesso!');
        }

        return redirect()->route('ordinances.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordinance $ordinance)
    {
        if ($ordinance->files->count() > 0) {
            foreach ($ordinance->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }

        $ordinance->categories()->delete();
        $ordinance->types()->detach();
        $ordinance->secretaries()->detach();
        $ordinance->files()->delete();
        $ordinance->delete();

        return redirect()->route('ordinances.index')->with('success', 'Portaria excluída com sucesso!');
    }
}
