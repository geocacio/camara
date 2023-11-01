<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $excludedSlugs = ['competencias', 'exercicios', 'cargos', 'transparencia'];

        $excludedCategoryIds = Category::whereIn('slug', $excludedSlugs)->pluck('id')->toArray();

        $categories = Category::with('children')
            ->where(function ($query) use ($excludedCategoryIds) {
                $query->whereNull('parent_id')
                    ->orWhereNotIn('parent_id', $excludedCategoryIds);
            })
            ->whereNotIn('slug', $excludedSlugs)
            ->get();

        return view('panel.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('.panel.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $validatedData['slug'] = Str::slug($request->name);

        Category::create($validatedData);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '<>', $category->id)->get();
        return view('panel.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $mainCategory = Category::find($category->parent_id);
        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Não é possível excluir uma categoria que possui subcategorias.');
        }

        if ($category->categoryContents()->exists()) {
            return redirect()->route('subcategories.index', ['category' => $mainCategory->slug])->with('error', 'Não é possível excluir uma categoria que possui posts.');
        }

        $category->delete();

        return redirect()->route('subcategories.index', ['category' => $mainCategory->slug])->with('success', 'Categoria removida com sucesso!');
    }

    public function showSubcategories(Category $category)
    {
        $categories = $category->children;
        return view('panel.subcategories.index', compact('categories', 'category'));
    }

    public function createSubcategories(Category $category)
    {
        return view('panel.subcategories.create', compact('category'));
    }

    public function storeSubcategories(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|unique:categories',
                'parent_id' => 'nullable|exists:categories,id',
            ],
            [
                'name.unique' => 'O nome já está sendo usado por outra categoria.',
            ]
        );
        $validatedData['slug'] = Str::slug($request->name);

        Category::create($validatedData);
        $category = Category::find($request->parent_id);
        return redirect()->route('subcategories.index', ['category' => $category->slug])->with('success', 'Categoria criada com sucesso!');
    }
}
