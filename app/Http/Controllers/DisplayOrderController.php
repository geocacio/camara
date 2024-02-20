<?php

namespace App\Http\Controllers;

use App\Models\DisplayOrder;
use Illuminate\Http\Request;

class DisplayOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $orderData = $request->input('order');

            foreach ($orderData as $item) {
                $itemId = $item['id'];
                $newOrder = $item['order'];

                DisplayOrder::updateOrCreate(
                    ['item_id' => $itemId, 'page' => $request->page],
                    ['display_order' => $newOrder]
                );
            }

            return response()->json(['message' => 'Ordem salva com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar a ordem no banco de dados.']);
        }
    }

    
    

    /**
     * Display the specified resource.
     */
    public function show(DisplayOrder $displayOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DisplayOrder $displayOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DisplayOrder $displayOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DisplayOrder $displayOrder)
    {
        //
    }
}
