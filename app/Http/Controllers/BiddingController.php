<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Category;
use App\Models\CategoryContent;
use App\Models\Company;
use App\Models\Contract;
use App\Models\DisplayOrder;
use App\Models\Employee;
use App\Models\File;
use App\Models\Organ;
use App\Models\Page;
use App\Models\Role;
use App\Models\Secretary;
use App\Models\ShortcutTransparency;
use App\Models\TransparencyGroup;
use App\Models\Type;
use App\Models\TypeContent;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BiddingController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    
    public function formatSize($bytes)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = intval(floor(log($bytes, 1024)));
        return round($bytes / (1024 ** $i), 2) . ' ' . $sizes[$i];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biddings = Bidding::get();
        return view('panel.biddings.index', compact('biddings'));
    }

    public function indexDispensa()
    {
        $biddings = Bidding::where('bidding_type', 'dispensa')->get();
        return view('panel.biddings.dispensas.index', compact('biddings'));
    }

    public function ShoppingPortal()
    {
        $biddings = Bidding::take(10)->get();

        $biddingNoticeID = ShortcutTransparency::where('type', 'biddings-notice')->pluck('page_id');

        $biddingNotices = Bidding::whereIn('id', $biddingNoticeID)
        ->with(['categories.category.children' => function ($query) {
            $query->where('id', 57);
        }])->get();

        return view('pages.biddings.index', compact('biddings', 'biddingNotices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::with('organs')->get();
        $types = Type::where('slug', 'biddings')->first()->children;
        $modalities = Category::where('slug', 'modalidades')
        ->with(['children' => function ($query) {
            $query->whereNotIn('slug', ['dispensa', 'inexigibilidade']);
        }])
        ->get();
    
        $competings = Category::where('slug', 'concorrencia')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $responsibilities = Category::where('slug', 'responsabilidades')->with('children')->get();
        $employees = Employee::all();

        return view('panel.biddings.create', compact('modalities', 'exercicies', 'types', 'competings', 'secretaries', 'responsibilities', 'employees'));
    }

    public function dispensaCreate(){
        $secretaries = Secretary::with('organs')->get();
        $types = Type::where('slug', 'biddings')->first()->children;
        $modalities = Category::where('slug', 'modalidades')->with(['children' => function ($query) {
            $query->whereIn('slug', ['dispensa', 'inexigibilidade']);
        }])->get();
        $competings = Category::where('slug', 'concorrencia')->with('children')->get();
        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();
        $responsibilities = Category::where('slug', 'responsabilidades')->with('children')->get();
        $employees = Employee::all();

        return view('panel.biddings.dispensas.create', compact('modalities', 'exercicies', 'types', 'competings', 'secretaries', 'responsibilities', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

        // if ($request->company_name != '') {
        //     $request->validate([
        //         'company_name' => 'required',
        //         'company_cnpj' => 'required',
        //         'company_address' => 'required',
        //         'company_city' => 'required',
        //         'company_state' => 'required',
        //         'company_country' => 'required',
        //     ]);
        // }

        if($request['type_bidding']){
            $validatedData['bidding_type'] = $request['type_bidding'];
        }

        $validatedData['slug'] = Str::slug($request->number);

        if ($validatedData['estimated_value']) {
            $validatedData['estimated_value'] = str_replace(['R$', '.', ','], ['', '', '.'], $validatedData['estimated_value']);
        }

        $bidding = Bidding::create($validatedData);
        if ($bidding) {
            $companiesDataString = $request->company_data;
            $companiesData = json_decode($companiesDataString, true);

             foreach ($companiesData as $companyData) {
                $companyValidation = Validator::make($companyData, [
                    'company_name' => 'required',
                    'company_cnpj' => 'required',
                    'company_address' => 'required',
                    'company_city' => 'required',
                    'company_state' => 'required',
                    'company_country' => 'required',
                ]);

                if ($companyValidation->fails()) {
                    return response()->json(['error' => $companyValidation->errors()], 400);
                }

                $company = $bidding->companies()->create([
                    'name' => $companyData['company_name'],
                    'cnpj' => $companyData['company_cnpj'],
                    'address' => $companyData['company_address'],
                    'city' => $companyData['company_city'],
                    'state' => $companyData['company_state'],
                    'country' => $companyData['company_country'],
                    'slug' => Str::slug($companyData['company_name']),
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

            foreach ($availableFiles as $fileId => $file) {
                $url = $this->fileUploadService->upload($file, 'biddings');
                $name = ucwords(str_replace('-', ' ', $fileId));
                $size = $this->formatSize($file->getSize());
                $format = $file->getClientOriginalExtension();
                $newFile = File::create(['name' => $name, 'url' => $url, 'size' => $size, 'format' => $format]);
                $bidding->files()->create(['file_id' => $newFile->id]);
            }

            session()->flash('success', 'Licitação cadastrada com Sucesso!');
            return response()->json(['success' => true, 'bidding' => $bidding]);
        }

        return redirect()->route('biddings.index')->with('error', 'Erro, por favor tente novamente!');
    }

    public function BiddingPage(Request $request)
    {
        $categories = Category::where('slug', 'modalidades')->first();
        $modalidades = Category::where('parent_id', $categories->id)->with('children')->get();
        $categorieType = CategoryContent::whereIn('category_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('categoryable_id')->toArray();

        $query = Bidding::query()->where('bidding_type', null);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('modalidade')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('modalidade'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', 'LIKE', '%' . $request->input('status') . '%');
        }

        if ($request->filled('exercice')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('exercice'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('register_price')) {
            $query->where('estimated_value', 'LIKE', '%' . $request->input('register_price') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');

        }

        if ($request->filled('object')) {
            $query->where('description', 'LIKE', '%' . $request->input('object') . '%');
        }

        if ($request->filled('process')) {
            $query->where('process', 'LIKE', '%' . $request->input('process') . '%');
        }

        $bidding = $query->get();

        $searchData = $request->only(['start_date', 'end_date', 'status', 'exercice', 'modalidade', 'register_price', 'number', 'object', 'process']);

        return view('pages.biddings.adhesion.search', compact('bidding', 'modalidades', 'searchData', 'exercicies'));
    }

    public function pageEdit()
    {
        $page = Page::where('name', 'Licitações')->first();
        $groups = TransparencyGroup::all();
        return view('panel.biddings.page.edit', compact('page', 'groups'));
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

        $lrf = Page::where('name', 'Licitações')->first();
        
        if ($lrf->update($validateData)) {
            $lrf->groupContents()->delete();
            $lrf->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('bidding.page.create')->with('success', 'Informações atualizadas com sucesso!');
        }

        return redirect()->route('bidding.page.create')->with('error', 'Por favor tente novamente!');
    }


    /**
     * Display the specified resource.
     */
    public function show($biddingSlug)
    {
        // Obtenha a licitação com base no slug
        $bidding = Bidding::where('slug', $biddingSlug)->first();
        $categoryFather = Category::where('slug', 'modalidades')->first();

        $categorieModalidade = $bidding->categories->pluck('category')->where('parent_id', $categoryFather->id)->first();

        $typeBidding = Type::where('id', $bidding->bidding_type)->first();

        $categorieContent = CategoryContent::where('categoryable_type', 'bidding')->where('categoryable_id', $bidding->id)->pluck('category_id');
        $exercice = Category::whereIn('id', $categorieContent)->where('parent_id', 10)->first();
        
        $exercice = Category::whereIn('id', $categorieContent)->where('parent_id', 10)->first();

        // Verifique se há uma ordem personalizada para os arquivos desta licitação
        $orderedFiles = DisplayOrder::where('page', $biddingSlug)->orderBy('display_order')->get();

        if ($orderedFiles->isEmpty()) {
            // Se não houver ordem personalizada, obtenha os arquivos na ordem padrão
            $filesBidding = $bidding->files;
        } else {
            // Se houver uma ordem personalizada, ordene os arquivos com base nela
            $fileIds = $orderedFiles->pluck('item_id')->toArray();
            $filesBidding = File::whereIn('id', $fileIds)->get()->sortBy(function ($item) use ($fileIds) {
                return array_search($item->id, $fileIds);
            });
        }

        return view('pages.biddings.show', compact('bidding', 'filesBidding', 'typeBidding', 'exercice', 'categorieModalidade'));
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

        $otherFiles = File::whereIn('id', $bidding->files->pluck('file_id'))->where('name', '!=', 'File Authorization')->where('name', '!=', 'File Market Research')->get();

        return view('panel.biddings.edit', compact('bidding', 'biddingCategories', 'modalities', 'exercicies', 'types', 'competings', 'secretaries', 'responsibilities', 'employees', 'availableFiles', 'otherFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidding $bidding)
    {
        // dd($request->company_data);
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
            $companiesDataString = $request->company_data;
            $companiesData = json_decode($companiesDataString, true);

            $companyValidation = Validator::make($companiesData, [
                '*.company_name' => 'required',
                '*.company_cnpj' => 'required',
                '*.company_address' => 'required',
                '*.company_city' => 'required',
                '*.company_state' => 'required',
                '*.company_country' => 'required',
            ]);
            
            if ($companyValidation->fails()) {
                return response()->json(['error' => $companyValidation->errors()], 400);
            }
            
            // Excluir todas as empresas relacionadas à licitação (bidding)
            $bidding->companies()->delete();
            
            foreach ($companiesData as $companyData) {
                $bidding->companies()->create([
                    'name' => $companyData['company_name'],
                    'cnpj' => $companyData['company_cnpj'],
                    'address' => $companyData['company_address'],
                    'city' => $companyData['company_city'],
                    'state' => $companyData['company_state'],
                    'country' => $companyData['company_country'],
                    'slug' => Str::slug($companyData['company_name']),
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

            foreach ($availableFiles as $fileId => $file) {
                $url = $this->fileUploadService->upload($file, 'biddings');
                $name = ucwords(str_replace('-', ' ', $fileId));
                $size = $this->formatSize($file->getSize());
                $format = $file->getClientOriginalExtension();
                $newFile = File::create(['name' => $name, 'url' => $url, 'size' => $size, 'format' => $format]);
                $bidding->files()->create(['file_id' => $newFile->id]);
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

    public function DispensaInexigibilidade(Request $request)
    {
        $categories = Category::where('slug', 'dispensa')->orWhere('slug', 'inexigibilidade')->get();
        $categorieType = CategoryContent::whereIn('category_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('categoryable_id')->toArray();

        $query = Bidding::query()->where('bidding_type', 'dispensa');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('modalidade')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('modalidade'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', 'LIKE', '%' . $request->input('status') . '%');
        }

        if ($request->filled('exercice')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('exercice'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('register_price')) {
            $query->where('estimated_value', 'LIKE', '%' . $request->input('register_price') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');

        }

        if ($request->filled('object')) {
            $query->where('description', 'LIKE', '%' . $request->input('object') . '%');
        }

        if ($request->filled('process')) {
            $query->where('process', 'LIKE', '%' . $request->input('process') . '%');
        }

        $bidding = $query->paginate(10);

        $searchData = $request->only(['start_date', 'end_date', 'status', 'exercice', 'modalidade', 'register_price', 'number', 'object', 'process']);

        return view('pages.biddings.dispensa-inexigibilidade', compact('bidding', 'categories', 'searchData', 'exercicies'));
    }

    public function publicCall(Request $request)
    {
        $getBy = [
            'CONCORRÊNCIA',
            'TOMADA DE PREÇOS',
            'CONVITE',
            'CONCURSO',
            'LEILÃO',
            'PREGÃO',
            'CHAMADA PÚBLICA',
        ];

        $categories = Category::whereIn('name', $getBy)->get();
        $categorieType = CategoryContent::whereIn('category_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('categoryable_id')->toArray();

        $query = Bidding::query()->whereIn('id', $biddingIds);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('modalidade')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('modalidade'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', 'LIKE', '%' . $request->input('status') . '%');
        }

        if ($request->filled('exercice')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('exercice'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('register_price')) {
            $query->where('estimated_value', 'LIKE', '%' . $request->input('register_price') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }

        if ($request->filled('object')) {
            $query->where('description', 'LIKE', '%' . $request->input('object') . '%');
        }

        if ($request->filled('process')) {
            $query->where('process', 'LIKE', '%' . $request->input('process') . '%');
        }

        $bidding = $query->paginate(10);

        $searchData = $request->only(['start_date', 'end_date', 'status', 'exercice', 'modalidade', 'register_price', 'number', 'object', 'process']);

        return view('pages.biddings.inspectors.public-call.index', compact('bidding', 'categories', 'searchData', 'exercicies'));
    }

    public function suspended(Request $request)
    {
        $getBy = [
            'INIDONEIDADE',
            'SUSPENSÃO',
        ];

        $categories = Type::whereIn('name', $getBy)->get();
        $categorieType = TypeContent::whereIn('type_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('typeable_id')->toArray();

        $query = Bidding::query()->whereIn('id', $biddingIds);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('type')) {
            $searchExercice = TypeContent::where('typeable_type', 'bidding')->where('type_id', $request->input('type'))->get();
            $query->whereIn('id', $searchExercice->pluck('typeable_id'));
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        $bidding = $query->paginate(10);

        $searchData = $request->only(['start_date', 'end_date', 'status', 'exercice', 'modalidade', 'register_price', 'number', 'object', 'process']);

        return view('pages.biddings.suspended.index', compact('bidding', 'categories', 'searchData', 'exercicies'));
    }

    public function PriceRegistration(Request $request)
    {
        $getBy = [
            'ADESÃO A ATA DE REGISTRO DE PREÇOS'
        ];

        $categories = Category::whereIn('name', $getBy)->get();
        $categorieType = CategoryContent::whereIn('category_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('categoryable_id')->toArray();

        $query = Bidding::query()->whereIn('id', $biddingIds);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('type')) {
            $searchExercice = TypeContent::where('typeable_type', 'bidding')->where('type_id', $request->input('type'))->get();
            $query->whereIn('id', $searchExercice->pluck('typeable_id'));
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }

        $bidding = $query->paginate(10);

        $searchData = $request->only(['description', 'number']);

        return view('pages.biddings.price-registration.index', compact('bidding', 'categories', 'searchData', 'exercicies'));
    }

    
    public function AtoAdesao(Request $request)
    {
        $getBy = [
            'PREGÃO',
        ];

        $categories = Category::whereIn('name', $getBy)->get();
        $categorieType = CategoryContent::whereIn('category_id', $categories->pluck('id'))->get();

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $biddingIds = $categorieType->pluck('categoryable_id')->toArray();

        $query = Bidding::query()->whereIn('id', $biddingIds);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('modalidade')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('modalidade'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', 'LIKE', '%' . $request->input('status') . '%');
        }

        if ($request->filled('exercice')) {
            $searchExercice = CategoryContent::where('categoryable_type', 'bidding')->where('category_id', $request->input('exercice'))->get();
            $query->whereIn('id', $searchExercice->pluck('categoryable_id'));
        }

        if ($request->filled('register_price')) {
            $query->where('estimated_value', 'LIKE', '%' . $request->input('register_price') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }

        if ($request->filled('object')) {
            $query->where('description', 'LIKE', '%' . $request->input('object') . '%');
        }

        if ($request->filled('process')) {
            $query->where('process', 'LIKE', '%' . $request->input('process') . '%');
        }

        $bidding = $query->paginate(10);

        $searchData = $request->only(['start_date', 'end_date', 'status', 'exercice', 'modalidade', 'register_price', 'number', 'object', 'process']);

        return view('pages.biddings.adhesion.index', compact('bidding', 'categories', 'searchData', 'exercicies'));
    }

    public function contracts(Request $request){
        $categories = Type::where('slug', 'contracts')->first()->children;

        $exercicies = Category::where('slug', 'exercicios')->with('children')->get();

        $query = Contract::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));

            $query->whereBetween('opening_date', [$start_date, $end_date]);
        } elseif ($request->filled('start_date')) {
            // Se apenas a data inicial estiver definida
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $query->where('opening_date', '>=', $start_date);
        } else if ($request->filled('end_date')) {
            // Se apenas a data final estiver definida
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
            $query->where('opening_date', '<=', $end_date);
        }  

        if ($request->filled('type')) {
            $searchExercice = TypeContent::where('typeable_type', 'bidding')->where('type_id', $request->input('type'))->get();
            $query->whereIn('id', $searchExercice->pluck('typeable_id'));
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        if ($request->filled('number')) {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }

        $contracts = $query->paginate(10);

        $searchData = $request->only(['description', 'number']);
        return view('pages.biddings.contracts.index', compact('contracts', 'categories', 'searchData'));
    }

    public function addNotices(Request $request){

        $validatedData = $request->validate([
            'dataItem' => 'required',
        ]);

        // Verifica se já existe um registro com o dataItem
        $existinNotice = ShortcutTransparency::where('page_id', $validatedData['dataItem'])->where('type', 'biddings-notice')->first();
        
        if ($existinNotice) {
            try {
                $existinNotice->delete();
                return response()->json(['message' => 'Licitação removida da sessão aviso.']);
            } catch(\Exception $e){
                return response()->json(['message' => 'Falha na operação.']);
            }
        } else {
            try {
                ShortcutTransparency::create([
                    'page_id' => $validatedData['dataItem'], 
                    'type' => 'biddings-notice',
                ]);

                return response()->json(['message' => 'Licitação adicionada a sessão aviso.']);
            }
            catch(\Exception $e){
                return response()->json(['message' => 'Falha na operação.']);
            }
        }

    }
}
