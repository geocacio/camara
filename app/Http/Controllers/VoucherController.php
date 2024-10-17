<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\TransparencyGroup;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('panel.expenses.voucher.index', compact('vouchers'));
    }

    public function page(Request $request)
    {
        $query = Voucher::query();
        $expensesPage = Page::where('name', 'Despesas')->first();
        $groups = TransparencyGroup::all();
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = date("Y-m-d", strtotime($request->input('start_date')));
            $end_date = date("Y-m-d", strtotime($request->input('end_date')));
        
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }   

        $vouchers = $query->paginate(10);
        $searchData = $request->only(['start_date']);
    
        return view('pages.expenses.index', compact('expensesPage', 'searchData', 'vouchers'));

    }

    public function create()
    {
        return view('panel.expenses.voucher.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_number' => 'required|string',
            'voucher_date' => 'required|date',
            'amount' => 'required|numeric',
            'supplier' => 'required|string',
            'nature' => 'nullable|string',
            'economic_category' => 'nullable|string',
            'organization' => 'nullable|string',
            'budget_unit' => 'nullable|string',
            'project_activity' => 'nullable|string',
            'function' => 'nullable|string',
            'sub_function' => 'nullable|string',
            'resource_source' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Voucher::create($validatedData);

        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully!');
    }

    public function show($id)
    {
        $voucher = Voucher::with(['liquidations', 'payments'])->findOrFail($id);
        return view('pages.expenses.show', compact('voucher'));
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'voucher_number' => 'required|string',
            'voucher_date' => 'required|date',
            'amount' => 'required|numeric',
            'supplier' => 'required|string',
            'nature' => 'nullable|string',
            'economic_category' => 'nullable|string',
            'organization' => 'nullable|string',
            'budget_unit' => 'nullable|string',
            'project_activity' => 'nullable|string',
            'function' => 'nullable|string',
            'sub_function' => 'nullable|string',
            'resource_source' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $voucher = Voucher::findOrFail($id);
        $voucher->update($validatedData);

        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully!');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully!');
    }
}
