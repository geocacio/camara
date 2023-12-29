<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class TypeController extends Controller
{
    protected $directoryBreadcrumb = ['lrfs', 'ordinances'];
    /**
     * Display a listing of the resource.
     */
    public function index($item)
    {

        $type = Type::where('slug', $item)->first();

        $types = $type->children;
        $directoryBreadcrumb = $this->directoryBreadcrumb;
        return view('panel.types.index', compact('types', 'type', 'directoryBreadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Type $type)
    {
        $directoryBreadcrumb = $this->directoryBreadcrumb;
        return view('panel.types.create', compact('type', 'directoryBreadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:types,id',
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        Type::create($validatedData);
        $type = Type::find($request->parent_id);

        // dd($type);
        
        return redirect()->route('subtypes.index', $type['slug'])->with('type', $type)->with('success', 'Tipo criado com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $directoryBreadcrumb = $this->directoryBreadcrumb;
        $mainType = Type::find($type->parent_id);
        return view('panel.types.edit', compact('type', 'mainType', 'directoryBreadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable',
        ]);

        $type->update($validatedData);
        $type = Type::find($type->parent_id);

        return redirect()->route('subtypes.index', $type['slug'])->with('type', $type)->with('success', 'Tipo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
    
        return redirect()->back()->with('success', 'Tipo removido com sucesso!');
    }
    
}