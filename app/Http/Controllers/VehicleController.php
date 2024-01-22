<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileContent;
use App\Models\NoInfo;
use App\Models\NoVehicles;
use App\Models\Page;
use App\Models\Secretary;
use App\Models\TransparencyGroup;
use App\Models\Vehicle;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class VehicleController extends Controller
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
        $vehicles = Vehicle::all();
        return view('panel.vehicles.index', compact('vehicles'));
    }

    public function page()
    {
        $page = Page::where('name', 'Veículos')->first();
        $groups = TransparencyGroup::all();
        return view('panel.vehicles.page.create', compact('page', 'groups'));
    }

    public function pageUpdate(Request $request){
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);

        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $pageSymbol = Page::where('name', 'Veículos')->first();

        if ($pageSymbol->update($validateData)) {
            $pageSymbol->groupContents()->delete();
            $pageSymbol->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('veiculos.page')->with('success', 'Página atualizada com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao atualizar página!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validateData = $request->validate([
            'situation' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'plate' => 'required',
            'year' => 'required',
            'donation' => 'required',
            'type' => 'required',
            'purpose_vehicle' => 'required',
            'description' => 'nullable',
            'period' => 'nullable',
            'file' => 'nullable',
        ],[
            'situation.required' => 'O campo Situação é obrigatório!',
            'model.required' => 'O campo Modelo é obrigatório!',
            'brand.required' => 'O campo Marca é obrigatório!',
            'plate.required' => 'O campo Placa é obrigatório!',
            'year.required' => 'O campo Ano é obrigatório!',
            'donation.required' => 'O campo Doação é obrigatório!',
            'type.required' => 'O campo Tipo é obrigatório!',
            'purpose_vehicle.required' => 'O campo Finalidade é obrigatório!',
        ]);

        $validateData['slug'] = Vehicle::uniqSlug($validateData['model'], $validateData['brand'], $validateData['year']);

        if($vehicle = Vehicle::create($validateData)){
            return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao cadastrar veículo!');
        }

    }

    public function noVehicle(){
        $pageID = Page::where('name', 'Veículos')->first();
        $info = NoInfo::where('page_id', $pageID->id)->first();

        $currentFile = null;

        if($info){
            $fileContent = FileContent::where('fileable_type', 'no-info')->where('fileable_id', $info->id)->first();
    
            $currentFile = File::where('id', $fileContent->file_id)->first();
        }

        return view('panel.vehicles.no-vehicle', compact('info', 'currentFile'));
    }

    public function noVehicleStore(Request $request){

        $pageID = Page::where('name', 'Veículos')->first();
    
        $validateData = $request->validate([
            'description' => 'required',
        ]);

        $validateData['page_id'] = $pageID->id;
        
        $existingVehicle = NoInfo::where('page_id', $pageID->id)->first();
    
        if ($existingVehicle) {
            $existingVehicle->update($validateData);
    
            if ($request->hasFile('file')) {
                $existingFile = $existingVehicle->files->first();
                if ($existingFile) {
                    $existingFile->delete();
                }
    
                // Faz o upload do novo arquivo
                $url = $this->fileUploadService->upload($request->file('file'), 'no-vehicles');
                $file = File::create(['url' => $url]);

                // Associa o novo arquivo ao modelo existente
                $existingVehicle->files()->create(['file_id' => $file->id]);
            }
    
            return redirect()->route('veiculos.index')->with('success', 'Arquivo atualizado com sucesso!');
        } else {
            if($vehicle = NoInfo::create($validateData)){
                if ($request->hasFile('file')) {
                    $url = $this->fileUploadService->upload($request->file('file'), 'no-vehicles');
                    $file = File::create(['url' => $url]);
                    $vehicle->files()->create(['file_id' => $file->id]);
                }
                return redirect()->route('veiculos.index')->with('success', 'Arquivo cadastrado com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Falha ao cadastrar arquivo!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $perPage = $request->query('perPage', 10);
        
        $query = Vehicle::query();

        $secretarys = Secretary::all();

        if($request->filled('secretary_id')){
            $query->where('secretary_id', 'LIKE', '%' . $request->input('secretary_id') . '%');
        }

        if($request->filled('situation')){
            $query->where('situation', 'LIKE', '%' . $request->input('situation') . '%');
        }

        if($request->filled('model')){
            $query->where('model', 'LIKE', '%' . $request->input('model') . '%');
        }

        if($request->filled('brand')){
            $query->where('brand', 'LIKE', '%' . $request->input('brand') . '%');
        }
        
        if($request->filled('plate')){
            $query->where('plate', 'LIKE', '%' . $request->input('plate') . '%');
        }

        if($request->filled('type')){
            $query->where('type', 'LIKE', '%' . $request->input('type') . '%');
        }

        if($request->filled('period')){
            $query->where('type', 'LIKE', '%' . $request->input('type') . '%');
        }
        
        $vehicles = $query->paginate(10);
        $searchData = $request->only(['secretary_id', 'situation', 'model', 'brand', 'plate', 'type']);

        $searchData['situation'] = $request->input('situation', '');
        $searchData['type'] = $request->input('type', '');

        $noVehicle = NoVehicles::first();

        $fileID = $noVehicle->files;
        $fileWhenNoVehicle = File::where('id', $fileID->pluck('file_id'))->first();

        return view('pages.vehicles.index', compact('vehicles', 'searchData', 'secretarys', 'noVehicle', 'fileWhenNoVehicle'));
    }

    public function single($vehicle)
    {
        $vehicle = Vehicle::where('slug', $vehicle)->first();
        return view('pages.vehicles.single', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($vehicle)
    {
        $vehicle = Vehicle::where( 'slug',$vehicle)->first();

        return view('panel.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validateData = $request->validate([
            'situation' => 'required',
            'model' => 'required',
            'brand' => 'required',
            'plate' => 'required',
            'year' => 'required',
            'donation' => 'required',
            'type' => 'required',
            'purpose_vehicle' => 'required',
            'description' => 'nullable',
            'period' => 'nullable',
            'file' => 'nullable',
        ],
        [
            'situation.required' => 'O campo Situação é obrigatório!',
            'model.required' => 'O campo Modelo é obrigatório!',
            'brand.required' => 'O campo Marca é obrigatório!',
            'plate.required' => 'O campo Placa é obrigatório!',
            'year.required' => 'O campo Ano é obrigatório!',
            'donation.required' => 'O campo Doação é obrigatório!',
            'type.required' => 'O campo Tipo é obrigatório!',
            'purpose_vehicle.required' => 'O campo Finalidade é obrigatório!'
        ]);

        if($vehicle->update($validateData)){
            return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao tentar atualizar veículo!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($vehicle)
    {
        $vehicle = Vehicle::where('slug', $vehicle)->first();

        if($vehicle->delete()){
            return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
        }else {
            return redirect()->back()->with('error', 'Falha ao tentar excluir veículo!');
        }
    }
}
