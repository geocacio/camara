<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Organ;
use App\Models\Secretary;
use App\Services\GeneralCrudService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    private $crud;

    public function __construct(GeneralCrudService $crud)
    {
        $this->crud = $crud;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);
        
        $departments = Department::with('employee.employee', 'secretary', 'organ')
        ->when($search, function($query, $search){
            return $query->where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('employee.employee', function($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('organ', function($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })
        ->paginate($perPage)
        ->appends(['search' => $search, 'perPage' => $perPage]);

        return view('panel.secretaries.departments.index', compact('departments', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::with('organs')->get();
        $employees = Employee::all();
        
        return view('panel.secretaries.departments.create', compact('employees', 'secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'secretary_id' => 'required',
            'organ_id' => 'nullable',
            'phone1' => 'nullable',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'description' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        $redirect = ['route' => 'departments.index'];
        return $this->crud->initCrud('create', 'Department', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $secretaries = Secretary::with('organs')->get();
        $employees = Employee::all();
        return view('panel.secretaries.departments.edit', compact('department', 'employees', 'secretaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        // dd($request->organ_id);
        $validatedData = $request->validate([
            'name' => 'required',
            'secretary_id' => 'required',
            'organ_id' => 'nullable',
            'phone1' => 'nullable',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'description' => 'nullable',
        ]);

        $redirect = ['route' => 'departments.index'];
        return $this->crud->initCrud('update', 'Department', $validatedData, $request, $redirect, $department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        if ($department->employee) {
            $department->employee->delete();
        }

        foreach ($department->sectors as $sector) {
            if ($sector->employee) {
                $sector->employee->delete();
            }
        }
        $department->sectors()->delete();
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Departamento excluído com sucesso!');
    }
}
