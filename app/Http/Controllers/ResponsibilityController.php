<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Category;
use App\Models\ResponsibilityEmployee;
use Illuminate\Http\Request;

class ResponsibilityController extends Controller
{
    public function index(Bidding $bidding)
    {
        $responsibilities = $bidding->responsibilities;
        // dd($responsibilities[0]->pivot->employee->name);
        return view('panel.biddings.responsibilities.index', compact('bidding', 'responsibilities'));
    }

    public function create(Bidding $bidding)
    {
        $responsibilities = $bidding->responsibilities;
        $categories = Category::where('slug', 'responsabilidades')->with('children')->get();
        $employees = $bidding->secretary->getAllEmployees();

        return view('panel.biddings.responsibilities.create', compact('bidding', 'responsibilities', 'categories', 'employees'));
    }

    public function store(Request $request)
    {
        // Crie a nova relação
        $responsibilityEmployee = ResponsibilityEmployee::create([
            'bidding_id' => $request->bidding_id,
            'responsibility_id' => $request->responsibility_id,
            'employee_id' => $request->employee_id,
        ]);
        
        $bidding = Bidding::find($request->bidding_id);
        if($responsibilityEmployee){
            return redirect()->route('biddings.responsibilities.index', $bidding->slug)->with('success', 'Responsável cadastrado com sucesso!');
        }
        return redirect()->route('biddings.responsibilities.index', $bidding->slug)->with('error', 'Por favor tente novamente!');
    }

    public function edit(Bidding $bidding)
    {
        $responsibilities = $bidding->responsibilities;
        return view('panel.biddings.responsibilities.edit', compact('bidding', 'responsibilities'));
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy(ResponsibilityEmployee $responsibilityEmployee)
    {
        //
    }

    public function destroyResponsibility(Bidding $bidding, $id){
        $responsibilty = ResponsibilityEmployee::where('responsibility_id', $id)->first();
        $responsibilty->delete();
        return redirect()->back()->with('success', 'Responsabilidade Excluída com sucesso!');
    }

}
