<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Category;
use App\Models\Employee;
use App\Models\File;
use App\Models\Organ;
use App\Models\Role;
use App\Models\Secretary;
use App\Models\Type;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BiddingController extends Controller
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
        $biddings = Bidding::all();
        return view('panel.biddings.index', compact('biddings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::with('organs')->get();
        $types = Type::where('slug', 'biddings')->first()->children;
        $modalities = Category::where('slug', 'modalidades')->with('children')->get();
        $competings = Category::where('slug', 'concorrencia')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $responsibilities = Category::where('slug', 'responsabilidades')->with('children')->get();
        $employees = Employee::all();

        return view('panel.biddings.create', compact('modalities', 'exercicies', 'types', 'competings', 'secretaries', 'responsibilities', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            // 'secretary_id' => 'required',
            // 'organ_id' => 'nullable',
            'number' => 'required',
            'opening_date' => 'nullable',
            'status' => 'nullable',
            'estimated_value' => 'nullable',
            'description' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
        ]);

        if ($request->company_name != '') {
            $request->validate([
                'company_name' => 'required',
                'company_cnpj' => 'required',
                'company_address' => 'required',
                'company_city' => 'required',
                'company_state' => 'required',
                'company_country' => 'required',
            ]);
        }

        $validatedData['slug'] = Str::slug($request->number);

        if ($validatedData['estimated_value']) {
            $validatedData['estimated_value'] = str_replace(['R$', '.', ','], ['', '', '.'], $validatedData['estimated_value']);
        }

        $bidding = Bidding::create($validatedData);
        if ($bidding) {

            if ($request->company_name != '') {
                $bidding->company()->create([
                    'name' => $request->company_name,
                    'cnpj' => $request->company_cnpj,
                    'address' => $request->company_address,
                    'city' => $request->company_city,
                    'state' => $request->company_state,
                    'country' => $request->company_country,
                    'slug' => Str::slug($request->company_name),
                ]);
            }

            if ($request->type) {
                $bidding->types()->attach($request->type);
            }

            $transparency = Category::where('slug', 'transparencia')->first();
            if ($transparency) {
                $bidding->categories()->create([
                    'category_id' => $transparency->id,
                ]);
            }

            $modality = Category::where('id', $request->modality)->first();
            if ($modality) {
                $bidding->categories()->create([
                    'category_id' => $modality->id,
                ]);
            }

            $compety = Category::where('id', $request->compety)->first();
            if ($compety) {
                $bidding->categories()->create([
                    'category_id' => $compety->id,
                ]);
            }

            $exercicy = Category::where('id', $request->exercicy)->first();
            if ($exercicy) {
                $bidding->categories()->create([
                    'category_id' => $exercicy->id,
                ]);
            }

            $responsibilities = json_decode($request->responsibilities);
            if ($responsibilities) {
                foreach ($responsibilities as $responsibility) {
                    $bidding->responsibilities()->attach($responsibility->responsibility_id, ['employee_id' => $responsibility->employee_id]);
                }
            }

            $publications = json_decode($request->publications);
            if ($publications) {
                foreach ($publications as $publication) {
                    $bidding->publicationForms()->create([
                        'date' => $publication->date,
                        'type' => $publication->type,
                        'description' => $publication->description,
                        'slug' => Str::slug($publication->date)
                    ]);
                }
            }

            $availableFiles = $request->allFiles();
            if ($availableFiles && !empty($availableFiles)) {
                foreach ($availableFiles as $fileId => $file) {
                    $url = $this->fileUploadService->upload($file, 'biddings');
                    $name = ucwords(str_replace('-', ' ', $fileId));
                    $newFile = File::create(['name' => $name, 'url' => $url]);
                    $bidding->files()->create(['file_id' => $newFile->id]);
                }
            }

            // return redirect()->route('biddings.index')->with('success', 'Licitação cadastrada com sucesso!');
            session()->flash('success', 'Licitação cadastrada com Sucesso!');
            return response()->json(['success' => true, 'bidding' => $bidding]);
        }

        return redirect()->route('biddings.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidding $bidding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidding $bidding)
    {
        $biddingCategories = $bidding->categories->pluck('category');
        $secretaries = Secretary::with('organs')->get();
        $types = Type::where('slug', 'biddings')->first()->children;
        $modalities = Category::where('slug', 'modalidades')->with('children')->get();
        $competings = Category::where('slug', 'concorrencia')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $responsibilities = Category::where('slug', 'responsabilidades')->with('children')->get();
        $employees = Employee::all();

        $availableFiles = [];
        if ($bidding->files->count() > 0) {
            foreach ($bidding->files as $fileContent) {
                $availableFiles[$fileContent->file->name] = $fileContent->file;
            }
        }

        return view('panel.biddings.edit', compact('bidding', 'biddingCategories', 'modalities', 'exercicies', 'types', 'competings', 'secretaries', 'responsibilities', 'employees', 'availableFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidding $bidding)
    {
        // dd($request);
        $validatedData = $request->validate([
            'number' => 'required',
            'object' => 'nullable',
            'opening_date' => 'nullable',
            'status' => 'nullable',
            'estimated_value' => 'nullable',
            'description' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
        ]);

        if ($request->company_name != '') {
            $request->validate([
                'company_name' => 'required',
                'company_cnpj' => 'required',
                'company_address' => 'required',
                'company_city' => 'required',
                'company_state' => 'required',
                'company_country' => 'required',
            ]);
        }

        if ($validatedData['estimated_value']) {
            $validatedData['estimated_value'] = str_replace(['R$', '.', ','], ['', '', '.'], $validatedData['estimated_value']);
        }

        if ($bidding->update($validatedData)) {

            if ($request->company_name != '') {

                $bidding->company()->update([
                    'name' => $request->company_name,
                    'cnpj' => $request->company_cnpj,
                    'address' => $request->company_address,
                    'city' => $request->company_city,
                    'state' => $request->company_state,
                    'country' => $request->company_country,
                ]);
            }

            $bidding->categories()->delete();
            $transparency = Category::where('slug', 'transparencia')->first();
            if ($transparency) {
                $bidding->categories()->create([
                    'category_id' => $transparency->id,
                ]);
            }

            $modality = Category::where('id', $request->modality)->first();
            if ($modality) {
                $bidding->categories()->create([
                    'category_id' => $modality->id,
                ]);
            }

            $compety = Category::where('id', $request->compety)->first();
            if ($compety) {
                $bidding->categories()->create([
                    'category_id' => $compety->id,
                ]);
            }

            $exercicy = Category::where('id', $request->exercicy)->first();
            if ($exercicy) {
                $bidding->categories()->create([
                    'category_id' => $exercicy->id,
                ]);
            }

            $responsibilities = json_decode($request->responsibilities);
            if ($responsibilities) {
                $bidding->responsibilities()->detach();
                foreach ($responsibilities as $responsibility) {
                    $bidding->responsibilities()->attach($responsibility->responsibility_id, ['employee_id' => $responsibility->employee_id]);
                }
            }

            $publications = json_decode($request->publications);
            if ($publications) {
                $bidding->publicationForms()->delete();
                foreach ($publications as $publication) {
                    $bidding->publicationForms()->create([
                        'date' => $publication->date,
                        'type' => $publication->type,
                        'description' => $publication->description,
                        'slug' => Str::slug($publication->date)
                    ]);
                }
            }

            $availableFiles = $request->allFiles();
            if ($availableFiles && !empty($availableFiles)) {
                foreach ($availableFiles as $fileId => $file) {
                    $url = $this->fileUploadService->upload($file, 'biddings');
                    $name = ucwords(str_replace('-', ' ', $fileId));
                    $newFile = File::create(['name' => $name, 'url' => $url]);
                    $bidding->files()->create(['file_id' => $newFile->id]);
                }
            }

            $filesToRemove = json_decode($request->filesToRemove);
            if (!empty($filesToRemove)) {
                foreach ($filesToRemove as $id) {
                    $this->fileUploadService->deleteFile($id);
                }
            }

            // return redirect()->route('biddings.index')->with('success', 'Licitação atualizada com sucesso!');
            session()->flash('success', 'Licitação atualizada com Sucesso!');
            return response()->json(['success' => true, 'bidding' => $bidding]);
        }

        return redirect()->route('biddings.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidding $bidding)
    {
        if ($bidding->files->count() > 0) {
            foreach ($bidding->files as $currentFile) {
                $this->fileUploadService->deleteFile($currentFile->file->id);
            }
        }
        $bidding->files()->delete();

        $company = $bidding->company;
        if ($company) {
            foreach ($company->contracts as $contract) {
                $contract->delete();
            }
            $company->delete();
        }

        $bidding->categories()->delete();
        $bidding->progress()->delete();
        $bidding->publicationForms()->delete();
        $bidding->types()->detach();
        $bidding->responsibilities()->detach();
        $bidding->delete();
        return redirect()->route('biddings.index')->with('success', 'Licitação Excluída com sucesso!');
    }
}
