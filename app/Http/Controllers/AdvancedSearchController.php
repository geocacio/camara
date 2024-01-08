<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Construction;
use App\Models\Expenses;
use App\Models\Law;
use App\Models\LRF;
use App\Models\Office;
use App\Models\OfficialJournal;
use App\Models\Ordinance;
use App\Models\Publication;
use App\Models\Recipes;
use App\Models\ServiceLetter;
use App\Models\Type;
use App\Models\TypeContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdvancedSearchController extends Controller
{
    public function search(Request $request){
        $search = $request->get('search');

        // Verificar se $search é uma data no formato 'd/m/Y'
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $search)) {
            // Converter para o formato 'Y-m-d'
            $searchDate = Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
        } else {
            // Se não for uma data, usar o valor original
            $searchDate = $search;
        }
    
        $types = Type::where('name', 'like', '%'.$search.'%')->pluck('id');
        $type_contents = TypeContent::whereIn('type_id', $types)->pluck('typeable_id');
        $officies = Office::where('office', 'like', '%'.$search.'%')->pluck('id');
    
        $laws = Law::where('description', 'like', '%'.$search.'%')->orWhere('title', 'like', '%'.$search.'%')->orWhere('date', 'like', '%'.$searchDate.'%')->get();
        $lrfs = LRF::where('title', 'like', '%'.$search.'%')->get();

        $ordinances = Ordinance::where('number', 'like', '%'.$search.'%')->orWhere('date', 'like', '%'.$search.'%')
            ->orWhere('agent', 'like', '%'.$search.'%')->orWhere('detail', 'like', '%'.$search.'%')->orWhereIn('office_id', $officies)
            ->get();

        $publications = Publication::where('visibility', 'enabled')->where('title', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')->get();
    
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
            'ordinances' => $ordinances,
        ];
    
        session(['search_results' => $data]);
    
        return redirect()->route('advanced-search.result')->with('data', $data);
    }
    
    public function result(){
        $data = session('search_results');

        return view('pages.advanced-search.index')->with('data', $data);
    }
    
}
