<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipes::all();

        return view('panel.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'recipe_data' => 'required|date',
            'exercise' => 'required|string',
            'value' => 'required|string',
            'classification' => 'required',
            // 'origin_id' => 'nullable|exists:your_origin_table,id',
            'organ' => 'required|string',
            'recipe_type' => 'required|string',
            'slip_number' => 'required|string',
            'object' => 'required|string',
        ], [
            'recipe_data.required' => 'O campo data da receita é obrigatório',
        ]);

        $newRecipe = new Recipes();
        $newRecipe->fill($validatedData);

        if ($newRecipe->save()) {
            return redirect()->route('recipes.index')->with('success', 'Registro criado com sucesso!');
        } else {
            return redirect()->route('recipes.index')->with('error', 'Por favor, tente novamente!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipes $recipes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipes $recipe)
    {
        return view('panel.recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipes $recipe)
    {
        $validatedData = $request->validate([
            'recipe_data' => 'required|date',
            'exercise' => 'required|string',
            'value' => 'required|string',
            'classification' => 'required',
            // 'origin_id' => 'nullable|exists:your_origin_table,id',
            'organ' => 'required|string',
            'recipe_type' => 'required|string',
            'slip_number' => 'required|string',
            'object' => 'required|string',
        ], [
            'recipe_data.required' => 'O campo data da receita é obrigatório',
        ]);

        if ($recipe->update($validatedData)) {
            return redirect()->route('recipes.index')->with('success', 'Registro atualizado com sucesso!');
        } else {
            return redirect()->route('recipes.index')->with('error', 'Erro ao atualizar o registro. Por favor, tente novamente.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipes $recipe)
    {
        if (!$recipe) {
            return redirect()->route('recipes.index')->with('error', 'Registro não encontrado!');
        }
    
        $deleted = $recipe->delete();
    
        if ($deleted) {
            return redirect()->route('recipes.index')->with('success', 'Registro excluído com sucesso!');
        } else {
            return redirect()->route('recipes.index')->with('error', 'Erro ao excluir o registro. Por favor, tente novamente.');
        }
    }
    
}
