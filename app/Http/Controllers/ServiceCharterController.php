<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceCharter;
use Illuminate\Http\Request;

class ServiceCharterController extends Controller
{

    public function index()
    {
        $serviceCharters = ServiceCharter::all();
        return view('panel.service_charters.index', compact('serviceCharters'));
    }

    public function page()
    {
        $serviceCharters = ServiceCharter::all();
        return view('panel.service_charters.index', compact('serviceCharters'));
    }

    public function create()
    {
        $categoriesMain = Category::where('slug', 'carta-de-servicos-ao-cidadao')->first();
        $categories = Category::where('parent_id', $categoriesMain->id)->get();
    
        return view('panel.service_charters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'category_id' => 'required_without:new_category',
            'new_category' => 'string|nullable',
            'service_hours' => 'required|string',
            'service_completion_time' => 'required|string',
            'user_cost' => 'required|numeric',
            'service_provision_methods' => 'required|string',
            'service_steps' => 'required|string',
            'requirements_documents' => 'required|string',
            'links' => 'nullable|string',
            'views' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        if ($request->filled('new_category')) {
            $category = Category::create(['name' => $request->new_category]);
            $validatedData['category_id'] = $category->id;
        }

        ServiceCharter::create($validatedData);
    
        return redirect()->route('cartaservicos.index')->with('success', 'Service Charter created successfully!');
    }
    

    public function show($id)
    {
        $serviceCharter = ServiceCharter::findOrFail($id);
        return view('panel.service_charters.show', compact('serviceCharter'));
    }

    public function edit($id)
    {
        $categoriesMain = Category::where('slug', 'carta-de-servicos-ao-cidadao')->first();
        $categories = Category::where('parent_id', $categoriesMain->id)->get();

        $serviceCharter = ServiceCharter::findOrFail($id);
        return view('panel.service_charters.edit', compact('serviceCharter', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'category_id' => 'required',
            'description' => 'string',
            'service_hours' => 'sometimes|required|string',
            'service_completion_time' => 'sometimes|required|string',
            'user_cost' => 'sometimes|required|numeric',
            'service_provision_methods' => 'sometimes|required|string',
            'service_steps' => 'sometimes|required|string',
            'requirements_documents' => 'sometimes|required|string',
            'links' => 'nullable|string',
            'views' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $serviceCharter = ServiceCharter::findOrFail($id);
        $serviceCharter->update($validatedData);

        return redirect()->route('cartaservicos.index')->with('success', 'Service Charter updated successfully!');
    }

    public function destroy($id)
    {
        $serviceCharter = ServiceCharter::findOrFail($id);
        $serviceCharter->delete();

        return redirect()->route('cartaservicos.index')->with('success', 'Service Charter deleted successfully!');
    }
}
