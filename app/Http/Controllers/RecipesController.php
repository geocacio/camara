<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Recipes;
use App\Models\TransparencyGroup;
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

    public function page()
    {
        $recipePage = Page::where('name', 'Receitas')->first();
        $groups = TransparencyGroup::all();

        return view('panel.recipes.page.edit', compact('recipePage', 'groups'));
    }

    public function pageUpdate(Request $request)
    {
        $validateData = $request->validate([
            'transparency_group_id' => 'required',
            'main_title' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
            'description' => 'nullable',
            'link_type' => 'nullable',
            'url' => 'nullable',
        ], [
            'main_title.required' => 'O campo título principal é obrigatório',
            'transparency_group_id.required' => 'O campo Grupo é obrigatório!',
            'title.required' => 'O campo título é obrigatório'
        ]);
        $validateData['visibility'] = $request->visibility ? $request->visibility : 'disabled';

        $recipesPage = Page::where('name', 'Receitas')->first();

        if ($recipesPage->update($validateData)) {
            $recipesPage->groupContents()->delete();
            $recipesPage->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('recipes.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('recipes.page')->with('error', 'Por favor tente novamente!');
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
            'recipe_data' => 'nullable|date',
            'exercise' => 'nullable|string',
            'value' => 'nullable|string',
            'classification' => 'nullable',
            // 'origin_id' => 'nullable|exists:your_origin_table,id',
            'organ' => 'nullable|string',
            'recipe_type' => 'nullable|string',
            'slip_number' => 'nullable|string',
            'object' => 'nullable|string',
            'text_button' => 'nullable|string',
            'url' => 'nullable|string',
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
            'recipe_data' => 'nullable|date',
            'exercise' => 'nullable|string',
            'value' => 'nullable|string',
            'classification' => 'nullable',
            // 'origin_id' => 'nullable|exists:your_origin_table,id',
            'organ' => 'nullable|string',
            'recipe_type' => 'nullable|string',
            'slip_number' => 'nullable|string',
            'object' => 'nullable|string',
            'text_button' => 'nullable|string',
            'url' => 'nullable|string',
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
