<?php

namespace App\Http\Controllers;

use App\Models\Secretary;
use App\Models\SicSolicitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SicSolicitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solicitations = SicSolicitation::all();
        // dd($solicitations[1]->situations);
        return view('pages.sic.panel.solicitations.index', compact('solicitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secretaries = Secretary::all();
        return view('pages.sic.panel.solicitations.create', compact('secretaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataValidated = $request->validate([
            'receive_in' => 'required',
            'title' => 'required',
            'solicitation' => 'required',
        ], [
            'receive_in.required' => 'O campo método de recebimento de informações é obrigatório',
            'title.required' => 'O campo título é obrigatório',
            'solicitation.required' => 'O campo solicitação é obrigatório',
        ]);
        
        $dataValidated['user_id'] = Auth()->user()->id;
        $dataValidated['protocol'] = SicSolicitation::count() > 0 ? date('Ymd') . str_pad(SicSolicitation::count() + 1, 4, '0', STR_PAD_LEFT): date('Ymd') . str_pad(1, 4, '0', STR_PAD_LEFT);
        $dataValidated['slug'] = Str::slug($request->title);
        
        $sicSolicitation = SicSolicitation::create($dataValidated);

        if($sicSolicitation){
            $sicSolicitation->situations()->create([ 'situation' => 'Solicitação registrada' ]);
            $sicSolicitation->responseTimes()->create([ 'response_deadline' => Carbon::now()->addDays(20) ]);
            return redirect()->route('solicitacoes.index')->with('success', 'Solicitação cadastrada com sucesso!');
        }
        return redirect()->route('solicitacoes.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SicSolicitation $sicSolicitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SicSolicitation $sicSolicitation)
    {
        return view('pages.sic.panel.solicitations.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SicSolicitation $sicSolicitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SicSolicitation $sicSolicitation)
    {
        //
    }
}
