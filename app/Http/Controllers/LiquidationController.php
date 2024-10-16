<?php

namespace App\Http\Controllers;

use App\Models\Liquidation;
use App\Models\Voucher;
use Illuminate\Http\Request;

class LiquidationController extends Controller
{
    public function index($voucher)
    {
        $liquidations = Liquidation::where('voucher_id', $voucher)->get();

        return view('panel.expenses.liquidations.index', compact('liquidations', 'voucher'));
    }

    public function create(Voucher $voucher)
    {
        return view('panel.expenses.liquidations.create', compact('voucher'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
            'liquidation_date' => 'required|date',
            'invoice_number' => 'required|string',
            'fiscal_year' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        Liquidation::create($validatedData);

        return redirect()->route('liquidation.index', $request->voucher_id)->with('success', 'Liquidation created successfully!');
    }

    public function show($id)
    {
        $liquidation = Liquidation::with('voucher')->findOrFail($id);
        return view('liquidations.show', compact('liquidation'));
    }

    public function edit(Liquidation $liquidation)
    {
        return view('panel.expenses.liquidations.edit', compact('liquidation'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
            'liquidation_date' => 'required|date',
            'invoice_number' => 'required|string',
            'fiscal_year' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

        $liquidation = Liquidation::findOrFail($id);
        $liquidation->update($validatedData);

        return redirect()->route('liquidation.index', $liquidation->voucher_id)->with('success', 'Liquidation updated successfully!');
    }

    public function destroy($id)
    {
        $liquidation = Liquidation::findOrFail($id);
        $liquidation->delete();

        return redirect()->back()->with('success', 'Liquidation deleted successfully!');
    }
}
