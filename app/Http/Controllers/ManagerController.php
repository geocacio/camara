<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Manager;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $query = Manager::query();
        
        if($search){
            $query->where('name', 'lIKE', '%' . $search . '%');
        }

        $managers = $query->paginate($perPage)->appends(['search' => $search, 'perPage' => $perPage]);
        return view('panel.managers.index', compact('managers', 'perPage', 'search'));
    }

    public function indexPage(){
        $page_manager = Page::where('name', 'Prefeito e vice')->first();
        $groups = TransparencyGroup::all();
        return view('panel.managers.page.edit', compact('page_manager', 'groups'));
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

        $page_manager = Page::where('name', 'Prefeito e vice')->first();

        if ($page_manager->update($validateData)) {
            $page_manager->groupContents()->delete();
            $page_manager->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('managers.indexPage')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('managers.indexPage')->with('error', 'Por favor tente novamente!');
    }

    public function page()
    {
        $getCurrentManagers = Manager::orderBy('end_date', 'desc')->get();
        $managers = Manager::select('start_date as Data inicio', 'end_date as Data fim', 'name as Nome', 'office as Cargo')->orderBy('end_date', 'desc')->get()->toArray();
        $mayor      = false;
        $viceMayor  = false;
        $today = date('Y-m-d');

        foreach ($getCurrentManagers as $manager) {
            if ($manager->end_date >= $today) {
                $mayor = !$mayor ? ($manager->office == 'Prefeito' ? $manager : false) : $mayor;
                $viceMayor = !$viceMayor ? ($manager->office == 'Vice-prefeito' ? $manager : false) : $viceMayor;
            }

            if ($mayor && $viceMayor) {
                break;
            }
        }
        // dd($managers);
        return view('pages.managers.index', compact('managers', 'mayor', 'viceMayor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.managers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'office' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'biography' => 'required',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        unset($validatedData['file']);

        $manager = Manager::create($validatedData);
        if ($manager) {

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'managers');
                $file = File::create(['name' => $request->name, 'description' => $request->description, 'url' => $url]);
                $manager->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('managers.index')->with('success', 'Gestor cadastrado com sucesso!');
        }

        return redirect()->route('managers.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        return view('panel.managers.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manager $manager)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'office' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'biography' => 'required',
            'instagram' => 'nullable',
            'facebook' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        unset($validatedData['file']);

        $manager->update($validatedData);
        if ($manager) {

            if ($request->hasFile('file')) {
                if ($manager->files->count() > 0) {
                    $this->fileUploadService->deleteFile($manager->files[0]->file->id);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'managers');
                $file = File::create(['url' => $url]);
                $manager->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('managers.index')->with('success', 'Gestor atualizado com sucesso!');
        }

        return redirect()->route('managers.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        if ($manager->files && $manager->files->count() > 0) {
            $this->fileUploadService->deleteFile($manager->files[0]->file->id);
        }

        $manager->delete();

        return redirect()->route('managers.index')->with('success', 'Gestor excluido com sucesso!');
    }
}
