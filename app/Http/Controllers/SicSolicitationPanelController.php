<?php

namespace App\Http\Controllers;

use App\Models\SicSolicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SicSolicitationPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $solicitations = SicSolicitation::all();
        return view('panel.sic.solicitations', compact('solicitations', 'user'));
    }

    public function deadline(SicSolicitation $solicitation, Request $request){
        $result = $solicitation->responseTimes()->create(['response_deadline' => $request->response_deadline ]);
        if($result){
            
            return redirect()->route('solicitations.index')->with('success', 'Prazo alterado com sucesso!');
        }
        return redirect()->route('solicitations.index')->with('error', 'Por favor tente novamente!');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
