<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Organ;
use App\Models\Secretary;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GeneralCrudSErvice;

class OrganController extends Controller
{
    private $crud;
    private $fileUploadService;

    public function __construct(GeneralCrudSErvice $crud, FileUploadService $fileUploadService)
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

        $organs = Organ::with('employee.employee', 'secretary')
        ->when($search, function($query, $search){
            return $query->where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                ->orWhereHas('employee.employee', function($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->orWhereHas('secretary', function($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })
        ->paginate($perPage)
        ->appends(['search' => $search, 'perPage' => $perPage]);

        return view('panel.secretaries.organs.index', compact('organs', 'search', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::all();
        $employees = Employee::all();
        return view('panel.secretaries.organs.create', compact('secretaries', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'secretary_id' => 'required',
            'name' => 'required',
            'cnpj' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'description' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);

        $validatedData['status'] = 'enabled';
        $validatedData['slug'] = Str::slug($request->name);
        unset($validatedData['file']);
        $secretary = Secretary::find($request->secretary_id);

        $redirect = ['route' => 'organs.index'];
        return $this->crud->initCrud('create', 'Organ', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Organ $organ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organ $organ)
    {
        $employees = Employee::all();
        $secretaries = Secretary::all();
        return view('panel.secretaries.organs.edit', compact('organ', 'employees', 'secretaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organ $organ)
    {
        $validatedData = $request->validate([
            'secretary_id' => 'required',
            'name' => 'required',
            'cnpj' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'email' => 'nullable',
            'business_hours' => 'nullable',
            'address' => 'nullable',
            'zip_code' => 'nullable',
            'description' => 'nullable',
            'file' => "nullable|file|max:{$this->fileUploadService->getMaxSize()}",
        ]);
        unset($validatedData['file']);
        $validatedData['status'] = $request->status ? $request->status : 'disabled';

        $redirect = ['route' => 'organs.index'];
        return $this->crud->initCrud('update', 'Organ', $validatedData, $request, $redirect, $organ);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organ $organ)
    {
        if ($organ->files && $organ->files->count() > 0) {
            $this->fileUploadService->deleteFile($organ->files[0]->file->id);
        }
        foreach ($organ->departments as $department) {
            foreach ($department->sectors as $sector) {
                if ($sector->employee) {
                    $sector->employee->delete();
                }
            }
            $department->employee->delete();
            $department->sectors()->delete();
        }

        foreach ($organ->biddings as $bidding) {
            if ($bidding->progress) {
                $bidding->progress()->delete();
            }

            if ($bidding->categories) {
                $bidding->categories()->delete();
            }

            if ($bidding->types) {
                $bidding->types()->delete();
            }

            if ($bidding->files) {
                $bidding->files()->delete();
            }
            $organ->biddings()->delete();
        }

        $organ->employee()->delete();
        $organ->departments()->delete();
        $organ->delete();

        return redirect()->route('organs.index')->with('success', 'Orgão excluído com sucesso!');
    }
}
