<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expenses::all();

        return view('panel.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'creditor_number' => 'required',
            'date' => 'required|date',
            'exercise' => 'required|string',
            'organ' => 'required|string',
            'valor' => 'required',
            'fase' => 'required'
        ], [
            'recipe_data.required' => 'O campo data da receita é obrigatório',
        ]);

        $newExpenses = new Expenses();
        $newExpenses->fill($validatedData);

        if ($newExpenses->save()) {
            return redirect()->route('expenses.index')->with('success', 'Registro criado com sucesso!');
        } else {
            return redirect()->route('expenses.index')->with('error', 'Por favor, tente novamente!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenses $expense)
    {
        return view('panel.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenses $expense)
    {
        $validatedData = $request->validate([
            'creditor_number' => 'required',
            'date' => 'required|date',
            'exercise' => 'required|string',
            'organ' => 'required|string',
            'valor' => 'required',
            'fase' => 'required'
        ], [
            'recipe_data.required' => 'O campo data da receita é obrigatório',
        ]);

        if ($expense->update($validatedData)) {
            return redirect()->route('expenses.index')->with('success', 'Registro atualizado com sucesso!');
        } else {
            return redirect()->route('expenses.index')->with('error', 'Erro ao atualizar o registro. Por favor, tente novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expense)
    {
        if (!$expense) {
            return redirect()->route('ex$expenses.index')->with('error', 'Registro não encontrado!');
        }
    
        $deleted = $expense->delete();
    
        if ($deleted) {
            return redirect()->route('expenses.index')->with('success', 'Registro excluído com sucesso!');
        } else {
            return redirect()->route('expenses.index')->with('error', 'Erro ao excluir o registro. Por favor, tente novamente.');
        }
    }
}
