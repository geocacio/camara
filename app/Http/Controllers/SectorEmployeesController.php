<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeContent;
use App\Models\File;
use App\Models\Office;
use App\Models\Sector;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectorEmployeesController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Sector $sector)
    {
        $employees = $sector->employees;
        return view('panel.secretaries.sectors.employees.index', compact('employees', 'sector'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sector $sector)
    {
        $offices = Office::all();
        return view('panel.secretaries.sectors.employees.create', compact('sector', 'offices'));
    }

    public function create2(Sector $sector)
    {
        $sectorEmployees = $sector->employees()->pluck('employee_id');
        $exceptionsEmployees = EmployeeContent::whereNotIn('employee_id', $sectorEmployees)->pluck('employee_id')->unique();
        $exceptionsResponsibles = $sector->responsible()->pluck('employee_id')->unique();
        $exceptions = array_merge($exceptionsEmployees->toArray(), $exceptionsResponsibles->toArray());

        $employees = Employee::whereNotIn('id', $exceptions)->get();

        return view('panel.secretaries.sectors.employees.create2', compact('employees', 'sector'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Sector $sector)
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
        
        $employee = Employee::create($validatedData);

        if($employee){
            if ($request->hasFile('file')) {
                $url = $this->fileUploadService->upload($request->file('file'), 'employee');
                $file = File::create(['url' => $url]);                
                $employee->files()->create(['file_id' => $file->id]);
            }

            $sector->employees()->create(['employee_id' => $employee->id]);

            return redirect()->route('sectors.employees.index', $sector->slug)->with('success', 'Funcionário cadastrado com sucesso!');
        }

        return redirect()->route('sectors.employees.index', $sector->slug)->with('error', 'Erro, por favor tente novamente!');
    }

    public function store2(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|array',
        ]);

        $sector = Sector::find($request->sector_id);
        $sector->employees()->delete();
        foreach ($request->employee_id as $employeeId) {
            $sector->employees()->updateOrCreate(['employee_id' => $employeeId]);
        }

        $employees = $sector->employees;

        return redirect()->route('sectors.employees.index', compact('employees', 'sector'))->with('success', 'Lista de funcionários atualizado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector, $id )
    {
        $employee = EmployeeContent::find($id)->employee;
        $offices = Office::all();
        return view('panel.secretaries.sectors.employees.edit', compact('sector', 'offices', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector, string $id)
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
        
        $employee = Employee::find($id);
        
        if($employee->update($validatedData)){
            if ($request->hasFile('file')) {     
                if($employee->files->count() > 0){
                    $this->fileUploadService->deleteFile($employee->files[0]->file->id);
                }

                $url = $this->fileUploadService->upload($request->file('file'), 'employee');
                $file = File::create(['url' => $url]);                
                $employee->files()->create(['file_id' => $file->id]);
            }

            return redirect()->route('sectors.employees.index', $sector->slug)->with('success', 'Funcionário cadastrado com sucesso!');
        }

        return redirect()->route('sectors.employees.index', $sector->slug)->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector, $id)
    {
        $sector->employees()->where('employee_id', $id)->delete();
        $employees = $sector->employees;

        return redirect()->route('sectors.employees.index', compact('employees', 'sector'))->with('success', 'Funcionáro removido com sucesso!');
    }

    public function changeStatus(Request $request, Sector $sector, $id)
    {
        $employee = Employee::find($id);
        $employees = Employee::all();
        $result = $employee->update(['status' => $request->status]);
        if ($result) {
            return redirect()->route('sectors.employees.index', compact('employees', 'sector'))->with('success', 'Status atualizado com sucesso!');
        } else {
            return redirect()->route('sectors.employees.index', compact('employees', 'sector'))->with('error', 'Por favor tente novamente!');
        }
    }
}
