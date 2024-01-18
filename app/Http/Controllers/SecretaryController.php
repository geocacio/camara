<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Employee;
use App\Models\File;
use App\Models\Office;
use App\Models\Role;
use App\Models\Secretary;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\GeneralCrudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SecretaryController extends Controller
{
    private $crud;
    private $fileUploadService;

    public function __construct(GeneralCrudService $crud, FileUploadService $fileUploadService)
    {
        $this->crud = $crud;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        $secretaries = Secretary::with('responsible.employee')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhereHas('responsible.employee', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->paginate($perPage)
            ->appends(['search' => $search, 'perPage' => $perPage]);

        return view('panel.secretaries.index', compact('secretaries', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::all();
        $employees = Employee::all();
        return view('panel.secretaries.create', compact('offices', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'employee_id' => 'required',
            'name' => 'required',
            'plenary' => 'nullable',
            'cnpj' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'status' => 'nullable',
            'description' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        $validatedData['slug'] = Str::slug($request->name);
        unset($validatedData['file']);

        $redirect = ['route' => 'secretaries.index'];
        return $this->crud->initCrud('create', 'Secretary', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = Secretary::query();

        if($request->filled('name')){
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }

        $secretaries = $query->paginate(10);
        $searchData = $request->only(['name']);
        
        return view('pages.secretary.index', compact('secretaries', 'searchData'));
    }

    public function single(Secretary $secretary)
    {
        return view('pages.secretary.single', compact('secretary'));
    }
    
    public function departmentBySecretary(Secretary $secretary, Department $department)
    {
        return view('pages.secretary.departments.single', compact('secretary', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secretary $secretary)
    {
        $employees = Employee::all();
        $offices = Office::all();
        return view('panel.secretaries.edit', compact('secretary', 'offices', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secretary $secretary)
    {
        // dd('passou aqui', $secretary);
        $validatedData = $request->validate([
            // 'employee_id' => 'required',
            'name' => 'required',
            'plenary' => 'nullable',
            'cnpj' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'status' => 'nullable',
            'description' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        
        // dd('passou aqui');
        if($secretary->update($validatedData)){
            if ($request->hasFile('file')) {
                if (isset($secretary->files[0]) && Storage::disk('public')->exists($secretary->files[0]->file->url)){
                    Storage::disk('public')->delete($secretary->files[0]->file->url);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'chamber');
                $file = File::create(['url' => $url]);
                $secretary->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('secretaries.index')->with('success', 'Câmara atualizada com suceso!');
        }
        return redirect()->back()->with('error', 'Erro ao tentar atualizar Câmra, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretary $secretary)
    {
        // Excluir arquivos da secretaria, se existirem
        if ($secretary->files->count() > 0) {
            $this->fileUploadService->deleteFile($secretary->files[0]->file->id);
        }
    
        // Excluir órgãos, departamentos, licitações e funcionários associados à secretaria
        if ($secretary->organs && is_iterable($secretary->organs)) {
            foreach ($secretary->organs as $organ) {
                // Excluir departamentos associados ao órgão
                if ($organ->departments && is_iterable($organ->departments)) {
                    foreach ($organ->departments as $department) {
                        // Excluir setores associados ao departamento
                        if ($department->sectors && is_iterable($department->sectors)) {
                            foreach ($department->sectors as $sector) {
                                if ($sector->employee) {
                                    $sector->employee->delete();
                                }
                                $sector->delete();
                            }
                        }
    
                        // Excluir funcionário associado ao departamento
                        if ($department->employee) {
                            $department->employee->delete();
                        }
    
                        // Excluir o próprio departamento
                        $department->sectors()->delete();
                        $department->delete();
                    }
                }
    
                // Excluir funcionário associado ao órgão
                if ($organ->employee) {
                    $organ->employee->delete();
                }
    
                // Excluir o próprio órgão
                $organ->departments()->delete();
                $organ->delete();
            }
        }
    
        // Excluir departamentos diretamente associados à secretaria
        if ($secretary->departments && is_iterable($secretary->departments)) {
            foreach ($secretary->departments as $department) {
                // Excluir setores associados ao departamento
                if ($department->sectors && is_iterable($department->sectors)) {
                    foreach ($department->sectors as $sector) {
                        if ($sector->employee) {
                            $sector->employee->delete();
                        }
                        $sector->delete();
                    }
                }
    
                // Excluir funcionário associado ao departamento
                if ($department->employee) {
                    $department->employee->delete();
                }
    
                // Excluir o próprio departamento
                $department->delete();
            }
        }
    
        // Excluir funcionários e a própria secretaria
        $secretary->employee()->delete();
        $secretary->delete();
    
        return redirect()->route('secretaries.index')->with('success', 'Secretaria excluída com sucesso!');
    }
    

    public function createResponsible(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'office_id' => 'nullable',
            'email' => 'nullable',
            'phone' => 'nullable',
            'cpf' => 'nullable',
            'dependents' => 'nullable',
            'admission_date' => 'nullable',
            'employment_type' => 'nullable',
            'status' => 'nullable',
            'password' => 'required|confirmed',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        $employee = Employee::create($validatedData);

        if ($employee) {
            
            $user = User::Create([
                'name' => $employee->name,
                'employee_id' => $employee->id,
                'email' => $employee->email,
                'password' => $validatedData['password'],
                'status' => 'disabled',
            ]);
            
            $role = Role::where('name', 'secretario')->first();
            if ($user) {
                $user->roles()->attach($role->id);
            }

            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'employee');
                $file = File::create(['url' => $url]);                
                $employee->files()->create(['file_id' => $file->id]);
            }
            session()->flash('success', 'Responsável criado com sucesso!');
            return response()->json(['success' => true, 'employee' => $employee]);
        }
        session()->flash('error', 'Por favor tente novamente!');
        return response()->json(['error' => true, 'employee' => $employee]);
    }
}
