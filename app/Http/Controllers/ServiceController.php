<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $serviceList;

    public function __construct()
    {
        $this->serviceList = [
            (object) ['page' => 'Cartas de Serviços', 'route' => 'serviceLetter.page'],
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('panel.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $serviceList = $this->serviceList;
        return view('panel.services.create', compact('serviceList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'text' => 'nullable',
            'icon' => 'required',
            'type' => 'required',
            'url' => 'nullable',
        ],
        [
            'title.required' => 'O campo título é obrigatório',
            'icon.required' => 'O campo Ícone é obrigatório',
            'type.required' => 'O campo Tipo é obrigatório',
        ]);
        $validateData['slug'] = Str::slug($request->title);
        
        $service = Service::create($validateData);
        if ($service) {
            return redirect()->route('services.index')->with('success', 'Serviço cadastrado com Sucesso!');
        }
        return redirect()->route('services.index')->with('error', 'Por faovor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $serviceList = $this->serviceList;
        return view('panel.services.edit', compact('serviceList', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'text' => 'nullable',
            'icon' => 'required',
            'type' => 'required',
            'url' => 'nullable',
        ],
    [
        'title.required' => 'O campo título é obrigatório',
        'icon.required' => 'O campo Ícone é obrigatório',
        'type.required' => 'O campo Tipo é obrigatório',
    ]);
        
        if($service->update($validateData)){
            return redirect()->route('services.index')->with('success', 'Serviço atualizado com Sucesso!');
        }
        return redirect()->route('services.index')->with('error', 'Por faovor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if(!$service->delete()){
            return redirect()->route('services.index')->with('error', 'Por favor tente novamente!');
        }
        
        return redirect()->route('services.index')->with('success', 'Serviço apagado com Sucesso!');
    }
}
