<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Office;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::all();
        return view('panel.employees.create', compact('offices'));
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
        return view('panel.employees.edit', compact('employee', 'offices'));
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
