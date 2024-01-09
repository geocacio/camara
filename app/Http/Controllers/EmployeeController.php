<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Office;
use App\Models\Secretary;
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

    public function estagiOrTerceiro(Request $request, $type){

        if($type == 'estagiarios'){
            $getType = 'Intern';
        } else if ($type == 'terceirizados'){
            $getType = 'Contractor';
        }
    
        $query = Employee::where('employment_type', $getType);
    
        $cargos = Office::all();
        $secretarias = Secretary::all();
        
        if($request->filled('name')){
            $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
    
        if($request->filled('secretary')){
            $query->where('secretary', 'LIKE', '%' . $request->input('secretary') . '%');
        }
    
        if($request->filled('credor')){
            $query->where('credor', 'LIKE', '%' . $request->input('credor') . '%');
        }
    
        if($request->filled('contact_number')){
            $query->where('contact_number', 'LIKE', '%' . $request->input('contact_number') . '%');
        }
    
        $employees = $query->get();
    
        $searchData = $request->only(['name' ,'secretary', 'credor', 'contact_number']);
    
        return view('pages.employees.estagi.index', compact('employees', 'type', 'cargos', 'secretarias', 'searchData'));
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
            'secretary_id' => 'nullable',
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
            'secretary_id' => 'nullable',
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
}
