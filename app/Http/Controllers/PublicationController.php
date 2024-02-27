<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Page;
use App\Models\Publication;
use App\Models\PublicationPage;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class PublicationController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function page()
    {
        $page_publication = Page::where('name', 'Publicações')->first();
        $groups = TransparencyGroup::all();
        return view('panel.transparency.publications.page.edit', compact('page_publication', 'groups'));
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

        $page_publication = Page::where('name', 'Publicações')->first();

        if ($page_publication->update($validateData)) {
            $page_publication->groupContents()->delete();
            $page_publication->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('publications.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('publications.page')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publications = Publication::all();
        return view('panel.transparency.publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        $competencies = Category::where('slug', 'competencias')->with('children')->first();
        $groups = Category::where('slug', 'grupos')->with('children')->first();
        $types = Type::where('slug', 'publications')->first()->children;
        return view('panel.transparency.publications.create', compact('types', 'exercicies', 'competencies', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('passou aqui');
        $validateData = $request->validate(
            [
                // 'secretary_id' => 'required',
                'group_id' => 'required',
                'type_id' => 'required',
                'competency_id' => 'required',
                'exercicy_id' => 'required',
                'title' => 'required',
                'number' => 'required',
                'description' => 'nullable',
                'views' => 'nullable',
                'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}"
            ],
            [
                // 'secretary_id.required' => 'O campo Secretaria é obrigatótio',
                'group_id.required' => 'O campo Grupo é obrigatótio',
                'title.required' => 'O campo Título é obrigatótio',
                'type_id.required' => 'O campo Tipo é obrigatótio',
                'competency_id.required' => 'O campo Competencia é obrigatótio',
                'exercicy_id.required' => 'O campo Exercício é obrigatótio',
                'number.required' => 'O campo Número é obrigatótio',
                'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
            ]
        );

        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';
        $validateData['slug'] = Str::slug($validateData['title'] . '-' . $validateData['number']);

        $publication = Publication::create($validateData);
        if ($publication) {

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'transparencia/publications');
                $file = File::create(['url' => $url]);
                $publication->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('all-publications.index')->with('success', 'Publicação criada com sucesso!');
        }

        return redirect()->route('all-publications.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = Publication::query();
        $typesId = Type::where('slug', 'publications')->pluck('id');
        $groups = Category::where('parent_id', 14)->get();
        $exercicy = Category::where('parent_id', 10)->get();
        $categories = Category::all();

        $subTypes = Type::where('parent_id', $typesId)->get();
        
        $searchData = $request->only(['start_date', 'end_date', 'type_id', 'group_id', 'number', 'exercicy_id']);

        if($request->filled('number')){
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%')->orWhere('description', 'LIKE', '%' . $request->input('number') . '%');
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
        
            $query->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', '=', date("Y-m-d", strtotime($request->input('start_date'))));
        }        

        if($request->filled('group_id')){
            $query->where('group_id', 'LIKE', '%' . $request->input('group_id') . '%');
        }
        if($request->filled('type_id')){
            $query->where('type_id', 'LIKE', '%' . $request->input('type_id') . '%');
        }
        if($request->filled('exercicy_id')){
            $query->where('exercicy_id', 'LIKE', '%' . $request->input('exercicy_id') . '%');
        }

        $publications = $query->select()->orderBy('id', 'desc')->paginate(10);

        return view('pages.publications.index', compact('publications', 'subTypes', 'searchData', 'categories', 'groups', 'exercicy'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $all_publication)
    {
        $publication = $all_publication;
        
        // $secretaries = Secretary::all();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->first();
        $competencies = Category::where('slug', 'competencias')->with('children')->first();
        $groups = Category::where('slug', 'grupos')->with('children')->first();
        $types = Type::where('slug', 'publications')->first()->children;
        return view('panel.transparency.publications.edit', compact('publication', 'types', 'exercicies', 'competencies', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publication $all_publication)
    {
        $validateData = $request->validate(
            [
                // 'secretary_id' => 'required',
                'group_id' => 'required',
                'type_id' => 'required',
                'competency_id' => 'required',
                'exercicy_id' => 'required',
                'title' => 'required',
                'number' => 'required',
                'description' => 'nullable',
                'views' => 'nullable',
                'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}"
            ],
            [
                // 'secretary_id.required' => 'O campo Secretaria é obrigatótio',
                'group_id.required' => 'O campo Grupo é obrigatótio',
                'title.required' => 'O campo Título é obrigatótio',
                'type_id.required' => 'O campo Tipo é obrigatótio',
                'competency_id.required' => 'O campo Competencia é obrigatótio',
                'exercicy_id.required' => 'O campo Exercício é obrigatótio',
                'number.required' => 'O campo Número é obrigatótio',
                'file.max' => 'Este arquivo é muito grande. O tamanho máximo permitido é :max kilobytes.',
            ]
        );
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        if ($all_publication->update($validateData)) {
            
            if ($request->hasFile('file')) {
                if($all_publication->files->count() > 0){
                    $this->fileUploadService->deleteFile($all_publication->files[0]->file->id);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'transparencia/publications');
                $file = File::create(['url' => $url]);
                $all_publication->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('all-publications.index')->with('success', 'Publicação atualizada com sucesso!');
        }

        return redirect()->route('all-publications.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $all_publication)
    {
        if($all_publication->files->count() > 0){
            $this->fileUploadService->deleteFile($all_publication->files[0]->file->id);
        }
        $all_publication->delete();
        
        return redirect()->route('all-publications.index')->with('success', 'Publicação apagada com sucesso!');
    }
}
