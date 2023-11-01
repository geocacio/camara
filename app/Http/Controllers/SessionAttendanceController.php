<?php

namespace App\Http\Controllers;

use App\Models\Councilor;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionAttendanceController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Session $session)
    {
        // Listar todos os vereadores da legislatura atual
        $allCouncilors = (new Councilor)->getCurrentCouncilors();
        
        // Obter a lista de vereadores presentes nesta sessão
        $presentCouncilors = $session->sessionAttendance->where('call', 'Presente')->pluck('councilor_id');

        // Marcar os vereadores presentes
        $councilors = $allCouncilors->map(function ($councilor) use ($presentCouncilors) {
            $councilor->present = $presentCouncilors->contains($councilor->id);
            return $councilor;
        });
        
        return view('panel.sessions.attendance.create', compact('session', 'councilors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Session $session)
    {
        $councilors = $request->councilors;
        foreach($councilors as $councilorData){
            $councilorId = $councilorData['id'];
        $attendanceStatus = array_key_exists('visibility', $councilorData) ? 'Presente' : 'Ausente';
        
        // Verificar se já existe uma entrada para a sessão atual e o vereador
        $existingAttendance = $session->sessionAttendance()->where('councilor_id', $councilorId)->first();
        
        if ($existingAttendance) {
            // Atualize o status da chamada
            $existingAttendance->update(['call' => $attendanceStatus]);
        } else {
            // Crie uma nova entrada
            $session->sessionAttendance()->create([
                'councilor_id' => $councilorId,
                'call' => $attendanceStatus,
            ]);
        }

            // $attendance = [
            //     'councilor_id' => $councilor['id'],
            //     'call' => array_key_exists('visibility', $councilor) ? 'Presente' : 'Ausente',
            // ];
            // if(!$session->sessionAttendance()->create($attendance)){
            //     return redirect()->back()->with('error', 'Erro ao fazer chamada, por favor tente novamente!');
            // }
        }

        return redirect()->route('sessions.index')->with('success', 'Chamada realizada com sucesso!');
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
