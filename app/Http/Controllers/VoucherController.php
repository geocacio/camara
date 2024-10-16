<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('panel.expenses.voucher.index', compact('vouchers'));
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
        return view('vouchers.show', compact('voucher'));
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
