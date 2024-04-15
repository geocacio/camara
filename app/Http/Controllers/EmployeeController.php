<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Office;
use App\Models\Page;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Services\FileUploadService;
use App\Services\GeneralCrudService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
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
    public function index()
    {
        $employees = Employee::all();
        return view('panel.employees.index', compact('employees'));
    }

    public function Trainee(Request $request){

        $query = Employee::where('employment_type', 'Intern');
    
        $cargos = Office::all();
        $secretarias = Secretary::all();
        $page = Page::where('name', 'Estágiarios')->first();

        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->where(function ($q) use ($request) {
                if ($request->filled('start_date')) {
                    $q->where('admission_date', '>=', $request->input('start_date'));
                }
                if ($request->filled('end_date')) {
                    $q->where('admission_date', '<=', $request->input('end_date'));
                }
            });
        } 
        
        if($request->filled('name')){
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
        
        //Não existe secretaria em Câmara!
        // if($request->filled('secretary')){
        //     $query->where('secretary_id', 'LIKE', '%' . $request->input('secretary') . '%');
        // }
        $employees = $query->paginate(10);
    
        $searchData = $request->only(['name' ,'secretary', 'credor', 'contact_number', 'start_date', 'end_date']);
    
        return view('pages.employees.trainee.index', compact('employees', 'cargos', 'secretarias', 'searchData', 'page'));
    }

    public function Outsourced(Request $request){
    
        $query = Employee::where('employment_type', 'Contractor');
    
        $cargos = Office::all();
        $secretarias = Secretary::all();
        $page = Page::where('name', 'Terceirizados')->first();

        
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->where(function ($q) use ($request) {
                if ($request->filled('start_date')) {
                    $q->where('admission_date', '>=', $request->input('start_date'));
                }
                if ($request->filled('end_date')) {
                    $q->where('admission_date', '<=', $request->input('end_date'));
                }
            });
        } 
        
        
        if($request->filled('name')){
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
        
        //Não existe secretaria em Câmara!
        // if($request->filled('secretary')){
        //     $query->where('secretary_id', 'LIKE', '%' . $request->input('secretary') . '%');
        // }
    
        if($request->filled('credor')){
            $query->where('credor', 'LIKE', '%' . $request->input('credor') . '%');
        }
    
        if($request->filled('contact_number')){
            $query->where('contact_number', 'LIKE', '%' . $request->input('contact_number') . '%');
        }
    
        $employees = $query->paginate(10);
    
        $searchData = $request->only(['name' ,'secretary', 'credor', 'contact_number', 'start_date', 'end_date']);
    
        return view('pages.employees.outsourced.index', compact('employees', 'cargos', 'secretarias', 'searchData','page'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::all();
        $secretaries = Secretary::all();
        return view('panel.employees.create', compact('offices', 'secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'office_id' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
            'cpf' => 'nullable',
            'dependents' => 'nullable',
            'admission_date' => 'nullable',
            'employment_type' => 'nullable',
            'status' => 'nullable',
            // 'secretary_id' => 'nullable',
            'contact_number' => 'nullable',
            'credor' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        $validatedData['slug'] = Str::slug($request->name);
        unset($validatedData['file']);

        $redirect = ['route' => 'employees.index'];
        return $this->crud->initCrud('create', 'Employee', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $offices = Office::all();
        $secretaries = Secretary::all();
        return view('panel.employees.edit', compact('employee', 'offices', 'secretaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'office_id' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
            'cpf' => 'nullable',
            'dependents' => 'nullable',
            'admission_date' => 'nullable',
            'employment_type' => 'nullable',
            // 'secretary_id' => 'nullable',
            'contact_number' => 'nullable',
            'credor' => 'nullable',
            'status' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        unset($validatedData['file']);

        $redirect = ['route' => 'employees.index'];
        return $this->crud->initCrud('update', 'Employee', $validatedData, $request, $redirect, $employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Funcionário excluído com sucesso!');
    }

    public function outsourcedPage(){
        $outsource = Page::where('name', 'Terceirizados')->first();
        $groups = TransparencyGroup::all();
        return view('panel.employees.outsource.index', compact('outsource', 'groups'));
    }

    public function outsourcedPageUpdate (Request $request){

        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_daily = Page::where('name', 'Terceirizados')->first();

        if ($page_daily->update($validateData)) {
            $page_daily->groupContents()->delete();
            $page_daily->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('terceirizados.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('terceirizados.page')->with('error', 'Por favor tente novamente!');
    }


    
    public function traineePage(){
        $trainee = Page::where('name', 'Estágiarios')->first();
        $groups = TransparencyGroup::all();
        return view('panel.employees.trainee.index', compact('trainee', 'groups'));
    }

    public function traineePageUpdate (Request $request){
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $page_daily = Page::where('name', 'Estágiarios')->first();

        if ($page_daily->update($validateData)) {
            $page_daily->groupContents()->delete();
            $page_daily->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('treinee.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('treinee.page')->with('error', 'Por favor tente novamente!');
    }
}
