<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Construction;
use App\Models\Expenses;
use App\Models\Law;
use App\Models\LRF;
use App\Models\OfficialJournal;
use App\Models\Publication;
use App\Models\Recipes;
use App\Models\ServiceLetter;
use App\Models\Type;
use App\Models\TypeContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdvancedSearchController extends Controller
{
    public function search(Request $request){
        $search = $request->get('search');
    
        $types = Type::where('name', 'like', '%'.$search.'%')->pluck('id');
        $type_contents = TypeContent::whereIn('type_id', $types)->pluck('typeable_id');
    
        $laws = Law::where('description', 'like', '%'.$search.'%')->get();
        $lrfs = LRF::where('title', 'like', '%'.$search.'%')->get();
        $publications = Publication::where('visibility', 'enabled')->orWhere('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')->get();
    
        $construction = Construction::where('title', 'like', '%'.$search.'%')->
            orWhere('local', 'like', '%'.$search.'%')
            ->orWhereIn('id', $type_contents)->get();
    
        // despesas ------
        $columnsExpenses = Schema::getColumnListing('expenses');
        $queryExpenses = Expenses::query();
    
        foreach ($columnsExpenses as $column) {
            $queryExpenses->orWhere($column, 'like', '%' . $search . '%');
        }
    
        $expenses = $queryExpenses->get();
    
        // fim de despesas ------
    
        // receitas ------
        $columnsRecipes = Schema::getColumnListing('recipes');
        $queryRecipes = Recipes::query();
    
        foreach ($columnsRecipes as $column) {
            $queryRecipes->orWhere($column, 'like', '%' . $search . '%');
        }
    
        $recipes = $queryRecipes->get();
    
        // fim receitas ------
    
        // $dayles = OfficialJournal::where('title', 'like', '%'.$search.'%')->get();
    
        $service_letters = ServiceLetter::where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')->get();
    
        $data = [
            'laws' => $laws,
            'lrfs' => $lrfs,
            'construction' => $construction,
            'expenses' => $expenses,
            'recipes' => $recipes,
            'service_letters' => $service_letters,
            'publications' => $publications,
            'query' => $search,
        ];
    
        session(['search_results' => $data]);
    
        return redirect()->route('advanced-search.result')->with('data', $data);
    }
    
    public function result(){
        $data = session('search_results');

        return view('pages.advanced-search.index')->with('data', $data);
    }
    
}
