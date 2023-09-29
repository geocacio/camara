<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GeneralCrudSErvice;

class ProgressController extends Controller
{
    private $crud;

    public function __construct(GeneralCrudSErvice $crud)
    {
        $this->crud = $crud;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Bidding $bidding)
    {
        $progress = $bidding->progress;
        return view('panel.biddings.progress.index', compact('bidding', 'progress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Bidding $bidding)
    {
        $progress = $bidding->progress;
        return view('panel.biddings.progress.create', compact('bidding', 'progress'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bidding_id' => 'required',
            'title' => 'required',
            'datetime' => 'required',
            'description' => 'nullable',
        ]);
        $validatedData['slug'] = Str::slug($request->title);

        $bidding = Bidding::find($request->bidding_id);
        $redirect = ['route' => 'biddings.progress.index', 'params' => ['bidding' => $bidding->slug]];
        return $this->crud->initCrud('create', 'Progress', $validatedData, $request, $redirect);
    }

    /**
     * Display the specified resource.
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidding $bidding, Progress $progress)
    {
        return view('panel.biddings.progress.edit', compact('progress', 'bidding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Progress $progress)
    {
        $validatedData = $request->validate([
            'bidding_id' => 'required',
            'title' => 'required',
            'datetime' => 'nullable',
            'description' => 'nullable',
        ]);

        $bidding = Bidding::find($request->bidding_id);
        $redirect = ['route' => 'biddings.progress.index', 'params' => ['bidding' => $bidding->slug]];
        return $this->crud->initCrud('update', 'Progress', $validatedData, $request, $redirect, $progress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidding $bidding, Progress $progress)
    {
        $progress->delete();
        return redirect()->route('biddings.progress.index', $bidding->slug)->with('success', 'Progress Excluído com sucesso!');
    }
}
