<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($voucher)
    {
        $expenses = Expenses::where('voucher_id', $voucher)->get();

        return view('panel.expenses.index', compact('expenses', 'voucher'));
    }

    
    public function page()
    {
        $expensesPage = Page::where('name', 'Despesas')->first();
        $groups = TransparencyGroup::all();

        return view('panel.expenses.page.edit', compact('expensesPage', 'groups'));
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

        $expensesPage = Page::where('name', 'Despesas')->first();

        if ($expensesPage->update($validateData)) {
            $expensesPage->groupContents()->delete();
            $expensesPage->groupContents()->create(['transparency_group_id' => $validateData['transparency_group_id']]);
            return redirect()->route('expenses.page')->with('success', 'Informações atualizadas com sucesso!');
        }
        return redirect()->route('expenses.page')->with('error', 'Por favor tente novamente!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Voucher $voucher)
    {
        return view('panel.expenses.create', compact('voucher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_id' => 'nullable',
            'creditor_number' => 'nullable',
            'date' => 'nullable|date',
            'exercise' => 'nullable|string',
            'organ' => 'nullable|string',
            'valor' => 'nullable',
            'payment_number' => 'required',
            'fase' => 'nullable',
            'text_button' => 'nullable',
            'url' => 'nullable',
        ]);

        $newExpenses = new Expenses();
        $newExpenses->fill($validatedData);

        if ($newExpenses->save()) {
            return redirect()->route('expenses.index', $request->voucher_id)->with('success', 'Registro criado com sucesso!');
        } else {
            return redirect()->route('expenses.index', $request->voucher_id)->with('error', 'Por favor, tente novamente!');
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
            'voucher_id' => 'nullable',
            'creditor_number' => 'nullable',
            'date' => 'nullable|date',
            'exercise' => 'nullable|string',
            'organ' => 'nullable|string',
            'valor' => 'nullable',
            'payment_number' => 'required',
            'fase' => 'nullable',
            'text_button' => 'nullable',
            'url' => 'nullable',
        ]);

        if ($expense->update($validatedData)) {
            return redirect()->route('expenses.index', $expense->voucher_id)->with('success', 'Registro atualizado com sucesso!');
        } else {
            return redirect()->route('expenses.index', $expense->voucher_id)->with('error', 'Erro ao atualizar o registro. Por favor, tente novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expense)
    {
        if (!$expense) {
            return redirect()->back()->with('error', 'Registro não encontrado!');
        }
    
        $deleted = $expense->delete();
    
        if ($deleted) {
            return redirect()->back()->with('success', 'Registro excluído com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao excluir o registro. Por favor, tente novamente.');
        }
    }
}
