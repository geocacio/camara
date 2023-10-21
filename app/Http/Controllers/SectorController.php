<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Secretary;
use App\Models\Sector;
use App\Services\GeneralCrudService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectorController extends Controller
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
        $sectors = Sector::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%'.$search.'%');
        })
        ->paginate($perPage)
        ->appends(['search' => $search, 'perPage' => $perPage]);
        
        return view('panel.secretaries.sectors.index', compact('sectors', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $employees = Employee::all();
        return view('panel.secretaries.sectors.create', compact('departments', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
            'description' => 'nullable',
        ],[
            'name.required' => 'O campo nome é obrigatório',
        ]);
        $chamber = Secretary::first();

        $validatedData['secretary_id'] = $chamber->id;
        $validatedData['slug'] = Str::slug($request->name);

        $redirect = ['route' => 'sectors.index'];
        return $this->crud->initCrud('create', 'Sector', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        $departments = Department::all();
        $employees = Employee::all();
        return view('panel.secretaries.sectors.edit', compact('sector', 'employees', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {        
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'phone' => 'nullable',
            'description' => 'nullable',
        ],[
            'name.required' => 'O campo nome é obrigatório',
        ]);

        $redirect = ['route' => 'sectors.index'];
        return $this->crud->initCrud('update', 'Sector', $validatedData, $request, $redirect, $sector);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        if ($sector->employee) {
            $sector->employee->delete();
        }

        $sector->delete();
        return redirect()->route('sectors.index')->with('success', 'Setor excluído com sucesso!');
    }
}
