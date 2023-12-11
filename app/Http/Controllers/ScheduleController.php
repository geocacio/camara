<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::all();
        // dd($schedules);
        return view('panel.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'local' => 'nullable',
            'type' => 'nullable',
            'description' => 'nullable',
        ]);
        $validateData['slug'] = Str::slug($request->title);
        $validateData['secretary_id'] = Auth::user()->employee->responsible->responsibleable->id;
        $schedule = Schedule::create($validateData);
        if ($schedule) {
            return redirect()->route('schedules.index')->with('success', 'Agenda cadastrada com Sucesso!');
        }
        return redirect()->route('schedules.index')->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return view('panel.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'local' => 'nullable',
            'type' => 'nullable',
            'description' => 'nullable',
        ]);

        if ($schedule->update($validateData)) {
            return redirect()->route('schedules.index')->with('success', 'Agenda atualizada com Sucesso!');
        }
        return redirect()->route('schedules.index')->with('error', 'Por faovor tente novamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Agenda excluída com Sucesso!');
    }
}
